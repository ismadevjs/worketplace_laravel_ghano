<?php

namespace App\Http\Controllers\Seller\Auth;

use App\CPU\ImageManager;
use App\Http\Controllers\Controller;
use App\Model\Seller;
use App\Model\Customer;
use App\Model\Shop;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Rules\agrementdutilisation;

class RegisterController extends Controller
{

    // public function __construct()
    // {
       
    //         return back($this->middleware('auth'), ,);
        

    // }
    
    public function create()
    {
        /*if(Auth::guest()) {
            Toastr::error('Veuillez vous inscrit svp');
            return back();
        } else {*/
            return view('seller-views.auth.register');
       /*}*/ 
        
    }

    public function store(Request $request)
     {
        if ($request->remember != 'on') {
            Toastr::error('Accepter les condition svp');
        }

        $this->validate($request, [
            'shop_name' => 'required',
        ]);
        
        

        if ($request->remember != 'on') {
            Toastr::error('Accepter les condition svp');
        } else {
            DB::transaction(function ($r) use ($request) {
                // $seller = new Seller();
                // $seller->f_name = $request->f_name;
                // $seller->l_name = $request->l_name;
                // $seller->phone = $request->phone;
                // $seller->email = $request->email;
                // $seller->image = ImageManager::upload('seller/', 'png', $request->file('image'));
                // $seller->password = bcrypt($request->password);
                // $seller->status = "pending";
                // $seller->save();
        
        
            DB::table('seller_wallets')
                         ->insert([
                             'seller_id' => auth('customer')->user()->id,
                             'balance' => 0,
                             'created_at' =>  \Carbon\Carbon::now(),
                             'updated_at' => \Carbon\Carbon::now()
                         ]);
    
            });
                
                // $customer = Customer::find();
                $customer = User::find(auth('customer')->user()->id);
                
                $shop = new Shop();
               // $shop->seller_id = $seller->id;
                $shop->seller_id = auth('customer')->user()->id; 
                $shop->name = $request->shop_name;
                $shop->address = "adress default";
                $shop->contact = auth('customer')->user()->phone;
                $customer->seller = 1;
                // $shop->image = ImageManager::upload('shop/', 'png', $request->file('logo'));
                // $shop->banner = ImageManager::upload('shop/banner/', 'png', $request->file('banner'));
                 $shop->save();
                 $customer->save();
                 DB::table('notifications_jdidas')->insert([
                    'type' => 'Un Vendeur',
                    'num' => auth('customer')->user()->id,
                    'message' => 'est inscrit',
                    'status' => '1',
                    'forwho' => 'admin',
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                // if (auth('customer')->attempt($request->remember)) {
                //     return response()->json(['message' => 'Sign up process done successfully!', 'url' => session('keep_return_url')]);
                // }
    
            Toastr::success('Shop apply successfully!');
            return redirect('/user-account');
        }
       

    }
}
