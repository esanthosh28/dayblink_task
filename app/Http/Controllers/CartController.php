<?php
namespace App\Http\Controllers;
use App\Models\Cart;
use App\Models\Products;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public static function addToCart(Request $request){
        $params = $request->all();

        $productExists = Cart::join('products','products.id','cart.products_id')
            ->selectRaw('cart.qty, products.stock')
            ->where('products_id',$params['productid'])
            ->where('users_id',Auth::check() ? Auth::id() : 0);

        $productExistsCloned = clone $productExists;
        $productExistsCloned = $productExistsCloned->first();

        if(isset($productExistsCloned)){

            if($productExistsCloned->stock < ($productExistsCloned->qty+$params['qty'])){
                return response()->json([
                    'error' => true,
                    'msg' => 'stock not available',
                ], 200);
            }

            $productExists->update(['qty' => DB::raw('qty + '.$params['qty'])]);

        } else {
            Cart::insert([
                'users_id' => Auth::check() ? Auth::id() : 0,
                'products_id' => $params['productid'],
                'qty' => $params['qty'],
                'created_at' => Carbon::now()
            ]);
        }

        return response()->json([
            'error' => false,
            'msg' => 'added',
        ], 200);
    }

    public static function placeOrder(Request $request){

        $cartTotal = Cart::join('products','products.id','cart.products_id')
            ->where('cart.users_id',Auth::check() ? Auth::id() : 0)
            ->selectRaw('SUM(cart.qty * products.price) as total')->first();

        $insertIntoOrders = [
            'users_id' => Auth::check() ? Auth::id() : 0,
            'order_id' => rand(),
            'total' => $cartTotal->total,
            'created_at' => Carbon::now()
        ];

        $orderId = DB::table('orders')->insertGetId($insertIntoOrders);

        $cartItems = Cart::join('products','products.id','cart.products_id')
            ->selectRaw('cart.products_id,'.
                $orderId.' as orders_id,'.
                'NOW() as created_at,'.
                'cart.qty,'.
                'products.price,'.
                'cart.qty*products.price as total')
            ->where('cart.users_id',Auth::check() ? Auth::id() : 0)
            ->get()
            ->toArray();

        DB::table('order_item')->insert($cartItems);

        Cart::where('cart.users_id',Auth::check() ? Auth::id() : 0)->delete();

        foreach($cartItems as $cartItem){

            Products::where('id',$cartItem['products_id'])
                ->update(['stock' => DB::raw('stock - '.$cartItem['qty'])]);
        }

        return response()->json([
            'error' => false,
            'msg' => 'order placed',
        ], 200);
    }

}