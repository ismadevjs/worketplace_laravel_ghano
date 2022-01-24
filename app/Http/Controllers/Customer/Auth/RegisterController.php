<?php

namespace App\Http\Controllers\Customer\Auth;

use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use App\Rules\wilayasDayras;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:customer', ['except' => ['logout']]);
    }

    public function register()
    {
        $wilayas = DB::table('pr_shipping')->get();
        // $daryas = DB::table('pr_dayra')->get();
        session()->put('keep_return_url', url()->previous());
        return view('customer-view.auth.register', [
            'wilayas' => $wilayas
        ]);
    }

    public function dayras(Request $request)
    {   
         $sabi = DB::table('pr_dayra')->where('wilaya_id', $request->data)->get();
         return $sabi;
    }

    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'phone' => 'unique:users',
            'password' => 'required|min:6',
            'wilayas' => ['required', new wilayasDayras],
            'dayras' => ['required', new wilayasDayras]
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)]);
        }

        if ($request['password'] != $request['con_password']) {
            return response()->json(['errors' => ['code' => '', 'message' => 'password does not match.']], 403);
        }

        // if ($request['wilayas'] == "-") {
        //     return response()->json(['message'=> 'Le champ de Wilaya est obligatoire', 'url' => session('keep_return_url')]);
        // }

        // if ($request['dayras'] == "-") {
        //     return response()->json(['message'=> 'Le champ de Dayra est obligatoire', 'url' => session('keep_return_url')]);
        // }

        if (session()->has('keep_return_url') == false) {
            session()->put('keep_return_url', url()->previous());
        }

        DB::table('users')->insert([
            'f_name' => $request['f_name'],
            'l_name' => $request['l_name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'wilayas' => $request['wilayas'],
            'dayras' => $request['dayras'],
            'password' => bcrypt($request['password']),
            'created_at' => now(),
            'updated_at' => now()
        ]);


      

        DB::table('notifications_jdidas')->insert([
            'type' => 'Un client',
            'num' => rand(),
            'message' => 'est inscrit',
            'status' => '1',
            'forwho' => 'admin',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        if (auth('customer')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            return response()->json(['message' => 'Sign up process done successfully!', 'url' => session('keep_return_url')]);
        }

        return redirect()->back()->withInput($request->only('email', 'remember'))
            ->withErrors(['Something went wrong.']);
    }
}
