<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Products::where('created_by',Auth::id())
        ->latest()->paginate(50);

        return view('products.index', compact('projects'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'stock' => 'required'
        ]);

        Products::create($request->all());

        return redirect()->route('products.index')
            ->with('success', 'Project created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Products $project)
    {
        return view('products.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit($product_id)
    {
        $products = Products::find($product_id);
        return view('products.edit', compact('products'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Products $project)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'stock' => 'required'
        ]);
        $update_data = [
            'name'=>$request->input('name'),
            'price'=>$request->input('price'),
            'description'=>$request->input('description'),
            'stock'=>$request->input('stock'),
            'updated_at'=>date('Y-m-d H:i:s')
        ];
        Products::where("id", $request->input('id'))->update($update_data);
        return redirect()->route('products.index')
            ->with('success', 'Project updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $products = Products::find($request->input('product_id'));
        $products->delete();

        return redirect()->route('products.index')
            ->with('success', 'Project deleted successfully');
    }

    public function cart()
    {
        $products = Cart::join('products','products.id','cart.products_id')
            ->selectRaw('products.name,cart.qty,products.price * cart.qty as price')
            ->where('users_id',Auth::check() ? Auth::id() : 0)
            ->get();
        return view('products.cart', compact('products'));
    }

    public function product_list(){

        $products = Products::get();
        return view('products.product_list',compact('products'));
    }

    public function product($id){
        $products = Products::find($id);
        return view('products.product',compact('products'));
    }

    public function addtocart(Request $request){
        $params = $request->all();

        print_r($params);die;
    }
}
