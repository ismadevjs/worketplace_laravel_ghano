<?php

namespace App\Http\Controllers\Web;

use App\CPU\CustomerManager;
use App\CPU\OrderManager;
use App\Http\Controllers\Controller;
use App\Model\Order;
use App\Model\ShippingAddress;
use App\Model\Shop;
use App\Model\SupportTicket;
use App\Model\Wishlist;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use SellerWalletWithdrawBal;

class UserProfileController extends Controller
{
    public function user_account(Request $request)
    {
        if (auth('customer')->check()) {
            $customerDetail = User::where('id', auth('customer')->id())->first();
            $shop = Shop::where('seller_id', auth('customer')->id())->first();
            return view('web-views.users-profile.account-profile', compact(['customerDetail', 'shop']));
        } else {
            return redirect()->route('home');
        }
    }

    public function user_update(Request $request)
    {

        $image = $request->file('image');

        if ($image != null) {
            $data = getimagesize($image);
            $imageName = Carbon::now()->toDateString() . "-" . uniqid() . "." . 'png';
            if (!Storage::disk('public')->exists('profile')) {
                Storage::disk('public')->makeDirectory('profile');
            }
            $note_img = Image::make($image)->fit($data[0], $data[1])->stream();
            Storage::disk('public')->put('profile/' . $imageName, $note_img);
        } else {
            $imageName = auth('customer')->user()->image;
        }

        User::where('id', auth('customer')->id())->update([
            'image' => $imageName,
        ]);

        if ($request['password'] != $request['con_password']) {
            Toastr::error('Password did not match.');
            return back();
        }

        $userDetails = [
            'f_name' => $request->f_name,
            'l_name' => $request->l_name,
            'phone' => $request->phone,
            'password' => strlen($request->password) > 5 ? bcrypt($request->password) : auth('customer')->user()->password,
            'CCP' => $request->CCP,
            'CLE' => $request->CLE
        ];
        if (auth('customer')->check()) {
            User::where(['id' => auth('customer')->id()])->update($userDetails);
            Toastr::info(' your Profile is update!');
            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }

    public function account_address()
    {
        if (auth('customer')->check()) {
            $shippingAddresses = \App\Model\ShippingAddress::where('customer_id', auth('customer')->id())->get();
            return view('web-views.users-profile.account-address', compact('shippingAddresses'));
        } else {
            return redirect()->route('home');
        }
    }

    public function address_store(Request $request)
    {
        $address = [
            'customer_id' => auth('customer')->check() ? auth('customer')->id() : null,
            'contact_person_name' => $request->name,
            'address_type' => $request->addressAs,
            'address' => $request->address,
            'city' => $request->city,
            'zip' => $request->zip,
            'phone' => $request->phone,
            'state' => $request->state,
            'country' => $request->country,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('shipping_addresses')->insert($address);
        return back();
    }

    public function address_update(Request $request)
    {
        $updateAddress = [
            'contact_person_name' => $request->name,
            'address_type' => $request->addressAs,
            'address' => $request->address,
            'city' => $request->city,
            'zip' => $request->zip,
            'phone' => $request->phone,
            'state' => $request->state,
            'country' => $request->country,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        if (auth('customer')->check()) {
            ShippingAddress::where('id', $request->id)->update($updateAddress);
            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }

    public function address_delete(Request $request)
    {
        if (auth('customer')->check()) {
            ShippingAddress::destroy($request->id);
            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }

    public function account_payment()
    {
        if (auth('customer')->check()) {
            return view('web-views.users-profile.account-payment');
        } else {
            return redirect()->route('home');
        }
    }

    public function account_oder()
    {
        $orders = Order::where('customer_id', auth('customer')->id())->latest()->get();
        $shippings = ShippingAddress::all();
        return view('web-views.users-profile.account-orders', compact('orders', 'shippings'));
    }
    public function account_oder_pending()
    {
        $orders = Order::where('customer_id', auth('customer')->id())->latest()->get();
        $shippings = ShippingAddress::all();
        return view('web-views.users-profile.account-orders-pending', compact('orders', 'shippings'));
    }
    public function account_oder_delivered()
    {
        $orders = Order::where('customer_id', auth('customer')->id())->latest()->get();
        $shippings = ShippingAddress::all();
        return view('web-views.users-profile.account-orders-delivered', compact('orders', 'shippings'));
    }
    public function account_oder_processing()
    {
        $orders = Order::where('customer_id', auth('customer')->id())->latest()->get();
        $shippings = ShippingAddress::all();
        return view('web-views.users-profile.account-orders-processing', compact('orders', 'shippings'));
    }
    public function account_oder_confirmed()
    {
        $orders = Order::where('customer_id', auth('customer')->id())->latest()->get();
        $shippings = ShippingAddress::all();
        return view('web-views.users-profile.account-orders-confirmed', compact('orders', 'shippings'));
    }
    public function account_oder_canceled()
    {
        $orders = Order::where('customer_id', auth('customer')->id())->latest()->get();
        $shippings = ShippingAddress::all();
        return view('web-views.users-profile.account-orders-canceled', compact('orders', 'shippings'));
    }
    public function bank_account()
    {
        $user = User::where('id', auth('customer')->id())->latest()->get();
        return view('web-views.users-profile.bank-account', compact('user'));
        //return 'hhh';
        // return view('web-views.users-profile.bank-account');
    }


    public function account_order_details(Request $request)
    {
        // $orders = Order::with(['sellerName', 'sellerName.seller'])->where('customer_id', auth('customer')->id())->get();
        // $shop = Shop::where($orders);
        // dd($orders);
        $order = Order::join('shipping_addresses', 'orders.shipping_address', '=', 'shipping_addresses.id')
            ->join('users', 'orders.customer_id', '=', 'users.id')
            ->select('orders.*', 'shipping_addresses.address', 'users.phone as customer_phone')
            ->where('orders.id', $request->id)
            ->first();
        $order_details = DB::table('order_details')->join('shipping_methods', 'order_details.shipping_method_id', '=', 'shipping_methods.id')->select('order_details.*', 'shipping_methods.cost')->where('order_id', $order->id)->get();
        
        $shipping_addr = DB::table('shipping_addresses')->get();
        
        $countries = DB::table('pr_shipping')->get();
        
        $states = DB::table('pr_dayra')->get();
        
        // dd($order_details, $order);
       
        return view('web-views.users-profile.account-order-details', compact('order', 'order_details', 'shipping_addr', 'countries', 'states'));
    }

    public function account_wishlist()
    {
        if (auth('customer')->check()) {
            $wishlists = Wishlist::where('customer_id', auth('customer')->id())->get();
            return view('web-views.products.wishlist', compact('wishlists'));
        } else {
            return redirect()->route('home');
        }
    }

    public function account_tickets()
    {
        if (auth('customer')->check()) {
            $supportTickets = SupportTicket::where('customer_id', auth('customer')->id())->get();
            return view('web-views.users-profile.account-tickets', compact('supportTickets'));
        } else {
            return redirect()->route('home');
        }
    }

    public function ticket_submit(Request $request)
    {
        $ticket = [
            'subject' => $request['ticket_subject'],
            'type' => $request['ticket_type'],
            'customer_id' => auth('customer')->check() ? auth('customer')->id() : null,
            'priority' => $request['ticket_priority'],
            'description' => $request['ticket_description'],
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('support_tickets')->insert($ticket);
        return back();
    }

    public function single_ticket(Request $request)
    {
        $ticket = SupportTicket::where('id', $request->id)->first();
        return view('web-views.users-profile.ticket-view', compact('ticket'));
    }

    public function comment_submit(Request $request, $id)
    {
        DB::table('support_tickets')->where(['id' => $id])->update([
            'status' => 'open',
            'updated_at' => now(),
        ]);

        DB::table('support_ticket_convs')->insert([
            'customer_message' => $request->comment,
            'support_ticket_id' => $id,
            'position' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return back();
    }

    public function support_ticket_close($id)
    {
        DB::table('support_tickets')->where(['id' => $id])->update([
            'status' => 'close',
            'updated_at' => now(),
        ]);
        Toastr::success('Ticket closed!');
        return redirect('/account-tickets');
    }

    public function account_transaction()
    {
        $customer_id = auth('customer')->id();
        $customer_type = 'customer';
        if (auth('customer')->check()) {
            $transactionHistory = CustomerManager::user_transactions($customer_id, $customer_type);
            return view('web-views.users-profile.account-transaction', compact('transactionHistory'));
        } else {
            return redirect()->route('home');
        }
    }

    public function support_ticket_delete(Request $request)
    {

        if (auth('customer')->check()) {
            $support = SupportTicket::find($request->id);
            $support->delete();
            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }

    public function account_wallet_history($user_id, $user_type = 'customer')
    {
        $customer_id = auth('customer')->id();
        $customer_type = 'customer';
        if (auth('customer')->check()) {
            $wallerHistory = CustomerManager::user_wallet_histories($customer_id);
            return view('web-views.users-profile.account-wallet', compact('wallerHistory'));
        } else {
            return redirect()->route('home');
        }
    }

    public function track_order()
    {
        return view('web-views.order-tracking-page');
    }

    public function track_order_result(Request $request)
    {
        $orderDetails = OrderManager::track_order($request['order_id']);

        if (isset($orderDetails)) {
            $customer = User::find($orderDetails->customer_id);

            if ($orderDetails != null && $customer->phone == $request->phone_number) {
                return view('web-views.order-tracking', compact('orderDetails'));
            } else {
                return redirect()->route('track-order.index')->with('Error', 'Invalid Order Id or Phone Number');
            }
        } else {
            return redirect()->route('track-order.index')->with('Error', 'Invalid Order Id or Phone Number');
        }
    }

    public function track_last_order()
    {
        $orderDetails = OrderManager::track_order(Order::where('customer_id', auth('customer')->id())->latest()->first()->id);

        if ($orderDetails != null) {
            return view('web-views.order-tracking', compact('orderDetails'));
        } else {
            return redirect()->route('track-order.index')->with('Error', 'Invalid Order Id or Phone Number');
        }
    }

    public function order_cancel($id)
    {
        $order = Order::where(['id' => $id])->first();
        if ($order['payment_method'] == 'cash_on_delivery' && $order['order_status'] == 'pending') {
            OrderManager::stock_update_on_order_status_change($order, 'canceled');
            Order::where(['id' => $id])->update([
                'order_status' => 'canceled'
            ]);
            Toastr::success('Order canceled successfully!');
            return back();
        }
        Toastr::error('Order status is not changeable now');
        return back();
    }

    public function generate_invoice($id)
    {
        $order = Order::with('shipping')->where('id', $id)->first();
        //        dd($order)->toArray();

        $data["email"] = $order->customer["email"];
        $data["client_name"] = $order->customer["f_name"] . ' ' . $order->customer["l_name"];
        $data["order"] = $order;

        //        return view('web-views.invoice', compact('order'));

        $pdf = PDF::loadView('web-views.invoice', $data);
        return $pdf->download('00' . $order->id . '.pdf');
    }

    public function withdraw()
    {
        return view('web-views.withdraw', [
            'currency' => DB::table('retrait_limite')->first(),
            'withdraw_balance' => DB::table('seller_wallets')->where('seller_id', auth('customer')->user()->id)->first(),
            'withdraw' => DB::table('seller_wallet_histories')->get(),
            'customer' => DB::table('users')->where('id', auth('customer')->user()->id)->first()
                          
        ]);
    }

    public function withdrawPost(Request $request)
    {

        $user = DB::table('users')->where('id', auth('customer')->user()->id)->first();
        
        
        
        if ($user->CCP == 0 || $user->CLE == 0) {
            Toastr::error('S\'il vous plait vouillez vérfié votre compte bancaire avant de demandé un retrait');
            return back();
        } else {
            $balance = DB::table('retrait_limite')->first();

            DB::table('users')->where('id', auth('customer')->user()->id)->update(['CCP' => $request['CCP'], 'CLE' => $request['CLE']]);


        if ($request['balance'] == "" || $request['balance'] == 0) {
            Toastr::error('Svp ajouter votre retrait');
            
            return back();
        }

            

            if ($request['balance'] < $balance->limite) {
                Toastr::error('The requested Withdrawal is bigger than the balence');
                return back();
            } else {
                DB::table('seller_wallet_histories')
                    ->insert([
                        'seller_id' => auth('customer')->user()->id,
                        'amount' => $request['balance'],
                        'created_at' =>  \Carbon\Carbon::now(),
                        'updated_at' => \Carbon\Carbon::now()
                    ]);
                $wallet = DB::table('seller_wallets')->where('seller_id', auth('customer')->user()->id)->first();

                $resultat = $wallet->balance - floatval($request['balance']);
                DB::table('seller_wallets')->where('seller_id', auth('customer')->user()->id)->update(['balance' => $resultat]);
                Toastr::success('Withdraw sent automatically');
                DB::table('notifications_jdidas')->insert([
                    'type' => 'Un Vendeur',
                    'num' => auth('customer')->user()->id,
                    'message' => 'est demander un retrait',
                    'status' => '1',
                    'forwho' => 'admin',
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                return back();
            }
        }
    }
}
