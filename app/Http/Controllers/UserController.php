<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Mail;
use App\Http\Requests;
class UserController extends Controller{

	public function index(){
		return view('register');
	}

	public function register(Request $request){
		$user_name = $request->input('user_name');
        $user_email = $request->input('user_email');
        $user_mobile = $request->input('user_mobile');

        $existingUser = User::where(['email'=>$user_email,'mobile'=>$user_mobile])->first();

        if(isset($existingUser)){

            //need to throw error here since the user is already registred.
            return;
        }

        $data=array('name'=>$user_name,"email"=>$user_email,"mobile"=>$user_mobile);
        User::insert($data);

        return redirect('/');
	}

	public function login(){
		return view('login');
	}

	public function customLogin(Request $request){

        $request->validate([
            'mobile' => 'required',
            'otp' => 'required',
        ]);


        $credentials = $request->only('mobile', 'otp');
        if (Auth::attempt($credentials, $remember=true)) {
            $user = Auth::guard()->user();
            $user->generateToken();
            Auth::loginUsingId($user->id, $remember = true);
            $list['id'] = $user->id;
            $list['api_token'] = $user->api_token;

            return response()->json([
                'error' => false,
                'msg' => $list
            ]);
        }

        return response()->json([
            'error' => true,
            'msg' => 'Please Enter the Correct credentials'
        ], 200);

    }

	public function loginVerify(Request $request) {
	  
	  	$user_mobile = $request->input('user_mobile');
	  	$users = User::where('mobile', $user_mobile)->first();
	  	if(isset($users)){
	        $name = $users->name;
	        $email = $users->email;
			$otp = rand(1111,9999);
			User::where('email',$email)->update(['otp' => $otp]);
			$data = array( 'otp' => $otp,'name'=>$name,'email'=>$email );
			Mail::send('mail', $data, function($message) use ($data) {
			 $message->to($data['email'], $data['name'])->subject
			    ('Login OTP');
			 $message->from('esanthosh28@gmail.com','Support Team');
			});
			$response = ['status'=>'success','message'=>'OTP sending to email','otp'=>$otp];
		}else{
			$response = ['status'=>'failed','message'=>'Mobile number is not registed..'];
		}
		echo json_encode($response);die;
   }
}