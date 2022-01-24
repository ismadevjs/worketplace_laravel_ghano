<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class becomeSellerController extends Controller
{
    public function index() {
        return view('customer-view.becomeSeller');
    }
}
