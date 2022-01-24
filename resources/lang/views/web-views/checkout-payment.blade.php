@extends('layouts.front-end.app')

@section('title','Choose Payment Method')

@push('css_or_js')
   

@endpush

@section('content')
    <!-- Page Content-->
    <div class="container pb-5 mb-2 mb-md-4">
        <div class="row">
            <div class="col-md-12 mb-5 pt-5">
                <div class="feature_header" style="background: #dcdcdc;line-height: 1px">
                    <span>{{ trans('messages.payment_method')}}</span>
                </div>
            </div>
            <section class="col-lg-8">
                <hr>
                <div class="checkout_details mt-3">
                @include('web-views.partials._checkout-steps',['step'=>3])
                <!-- Payment methods accordion-->
                   <!-- <h2 class="h6 pb-3 mb-2 mt-5">{{trans('messages.choose_payment')}}</h2>-->
                        <h2></h2>
                        <h2></h2>
                        <h2></h2>
                        <h2></h2>
                    <div class="row">
                        @php($config=\App\CPU\Helpers::get_business_settings('cash_on_delivery'))
                        @if($config['status'])
                            
                        <!-- Navigation (desktop)-->
                        <div class="row">
                            <div class="col-12">
                                <a class="btn btn-secondary btn-block" href="{{route('checkout-shipping')}}">
                                    <span class="d-none d-sm-inline">{{trans('messages.back_to_shipping')}}</span>
                                    <span class="d-inline d-sm-none">{{trans('messages.back_to_shipping')}}</span>
                                </a>
                            </div>
                            <div class="col-12"></div>
                        </div>
                        
                        <div class="col-md-6 mb-4" style="cursor: pointer">
                                <a class="btn btn-block btn-primary"
                                   href="{{route('checkout-complete',['payment_method'=>'cash_on_delivery'])}}">
                                    {{trans('messages.fnp')}}
                                </a>
                            </div>
                            
                            
                        @endif

                       

                        @php($coupon_discount = session()->has('coupon_discount') ? session('coupon_discount') : 0)
                        @php($amount = \App\CPU\CartManager::cart_grand_total(session('cart')) - $coupon_discount)

                       
                    </div>
                    
                </div>
            </section>
            <!-- Sidebar-->
            @include('web-views.partials._order-summary')
        </div>
    </div>
@endsection

@push('script')
    
@endpush
