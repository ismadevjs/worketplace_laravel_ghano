@extends('layouts.front-end.app')

@push('css_or_js')
    <link rel="stylesheet" media="screen"
        href="{{ asset('public/assets/front-end') }}/vendor/nouislider/distribute/nouislider.min.css" />

    <style>
        .headerTitle {
            font-size: 24px;
            font-weight: 600;
            margin-top: 1rem;
        }

        body {
            font-family: 'Titillium Web', sans-serif
        }

        .product-qty span {
            font-size: 14px;
            color: #6A6A6A;
        }

        .font-nameA {

            display: inline-block;
            margin-top: 5px !important;
            font-size: 13px !important;
            color: #030303;
        }

        .font-name {
            font-weight: 600;
            font-size: 15px;
            padding-bottom: 6px;
            color: #030303;
        }

        .modal-footer {
            border-top: none;
        }

        .cz-sidebar-body h3:hover+.divider-role {
            border-bottom: 3px solid {{ $web_config['primary_color'] }} !important;
            transition: .2s ease-in-out;
        }

        label {
            font-size: 15px;
            margin-bottom: 8px;
            color: #030303;

        }

        .nav-pills .nav-link.active {
            box-shadow: none;
            color: #ffffff !important;
        }

        .modal-header {
            border-bottom: none;
        }

        .nav-pills .nav-link {
            padding-top: .575rem;
            padding-bottom: .575rem;
            background-color: #ffffff;
            color: #050b16 !important;
            font-size: .9375rem;
            border: 1px solid #e4dfdf;
        }

        .nav-pills .nav-link :hover {
            padding-top: .575rem;
            padding-bottom: .575rem;
            background-color: #ffffff;
            color: #050b16 !important;
            font-size: .9375rem;
            border: 1px solid #e4dfdf;
        }

        .nav-pills .nav-link.active,
        .nav-pills .show>.nav-link {
            color: #fff;
            background-color: {{ $web_config['primary_color'] }};
        }

        .iconHad {
            color: {{ $web_config['primary_color'] }};
            padding: 4px;
        }

        .iconSp {
            margin-top: 0.70rem;
        }

        .fa-lg {
            padding: 4px;
        }

        .fa-trash {
            color: #FF4D4D;
        }

        .namHad {
            color: #030303;
            position: absolute;
            padding-left: 13px;
            padding-top: 8px;
        }

        .donate-now {
            list-style-type: none;
            margin: 25px 0 0 0;
            padding: 0;
        }

        .donate-now li {
            float: left;
            margin: 0 5px 0 0;
            width: 100px;
            height: 40px;
            position: relative;
            padding: 22px;
            text-align: center;
        }

        .donate-now label,
        .donate-now input {
            display: block;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        }

        .donate-now input[type="radio"] {
            opacity: 0.01;
            z-index: 100;
        }

        .donate-now input[type="radio"]:checked+label,
        .Checked+label {
            background: {{ $web_config['primary_color'] }};
            color: white !important;
            border-radius: 7px;
        }

        .active_address_type {
            background: {{ $web_config['primary_color'] }};
            color: white !important;
            border-radius: 7px;
        }

        .active_address_type:hover {
            background: {{ $web_config['primary_color'] }} !important;
            color: white !important;
        }

        .donate-now label {
            padding: 5px;
            border: 1px solid #CCC;
            cursor: pointer;
            z-index: 90;
        }

        .donate-now label:hover {
            background: #DDD;
        }

        .price_sidebar {
            padding: 20px;
        }

        #edit {
            cursor: pointer;
        }

        @media (max-width: 600px) {
            .sidebar_heading {
                background: {{ $web_config['primary_color'] }};
            }

            .sidebar_heading h1 {
                text-align: center;
                color: aliceblue;
                padding-bottom: 17px;
                font-size: 19px;
            }

            .sidebarR {
                padding: 24px;
            }

            .price_sidebar {
                padding: 20px;
            }

            .btn-b {
                width: 350px;
                margin-right: 30px;
                margin-bottom: 10px;

            }

            .div-secon {
                margin-top: 2rem;
            }
        }

    </style>
@endpush

@section('content')
    <!-- Page Content-->
    <div class="container pb-5 mb-2 mb-md-4 mt-3">
        <div class="row">
            <!-- Sidebar-->
            @include('web-views.partials._profile-aside')
            <!-- Content  -->
            <section class="col-lg-9 mt-3 col-md-9">

                <!-- Addresses list-->
                <div class="row">
                    <div class="col-lg-12 col-md-12  d-flex justify-content-between overflow-hidden">
                        <div class="col-sm-4">
                            <h1 class="h3  mb-0 folot-left headerTitle">{{ trans('messages.Withdraw') }}</h1>
                        </div>

                        <div class="row">
                            <div class="col-6 ml-3">
                                <div class="btn btn-primary"> {{ trans('messages.Balance') }} : {{ $withdraw_balance->balance }} DA
                                </div>
                            </div>
                            @if ($withdraw_balance->balance > $currency->limite)
                                <div class="col-5">
                                    <div class="col-md-12">
                                        <div class="modal-title btn btn-success" data-toggle="modal"
                                            data-target="#editAddress_{{ $withdraw_balance->id }}">
                                            {{ trans('messages.Withdraw') }}</div>
                                    </div>

                                </div>


                                {{-- Modal Address Edit --}}
                                <div class="modal fade" id="editAddress_{{ $withdraw_balance->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog  modal-md" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h5 class="modal-title font-name ">
                                                            {{ trans('messages.Withdraw') }} </h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-body">
                                                <form id="updateForm" action="{{ route('withdraw-post') }}"
                                                    method="post">
                                                    @csrf
                                                    <div class="pb-3" style="display: flex">
                                                        <!-- Nav pills -->

                                                        <input type="number" name="balance"
                                                            class="border border-success rounded col-8 p-3"
                                                            placeholder="{{ $withdraw_balance->balance }}"
                                                            {{ $withdraw_balance->balance }} />
                                                            
                                                            

                                                    </div>
                                                    
                                                    
                                                    <div class="pb-3" style="">
                                                        @if ($customer->CCP == 0 || $customer->CLE == 0) <span class='badge badge-danger'>{{trans('messages.ccp_message')}} {{trans('messages.add_it_to')}}  </span> 
                                                        
                                                        <a href="https://worketplace.com/user-account" class="text-white"><h4 class="text-success btn btn-primary">Lien 👍</h4></a>
                                                        
                                                        
                                                        @else 
                                                        
                                                        <label for="CCP">CCP : </label>
                                                        <input type="number" name="CCP" id="CCP"
                                                            class="border border-success rounded col-5 mr-2"
                                                            placeholder="" value="{{$customer->CCP}}"
                                                             />
                                                             <label for="CLE">CLE : </label>
                                                             <input type="number" name="CLE"
                                                            class="border border-success rounded col-2"
                                                            placeholder="" value="{{$customer->CLE}}"
                                                             />
                                                        
                                                        
                                                        @endif
                                                        
                                                    </div>
                                                    <!-- Tab panes -->

                                                    <div class="modal-footer">
                                                        <button type="button" class="closeB btn btn-secondary"
                                                            data-dismiss="modal">{{ trans('messages.close') }}</button>
                                                       
                                                       
                                                        <button type="submit" class="btn btn-primary" id="addressUpdate"
                                                            data-id="{{ $withdraw_balance->id }}"  @if ($customer->CCP == 0 || $customer->CLE == 0) disabled @endif>{{ trans('messages.send') }}
                                                        </button>
                                                        
                                                        
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            @endif
                        </div>
                    </div>

                </div>


                <div class="row mt-4">
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">{{ trans('messages.amount') }}</th>
                                <th scope="col">{{ trans('messages.status') }}</th>
                                <th scope="col">{{ trans('messages.created_at') }}</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($withdraw as $history)
                                @if ($history->seller_id == auth('customer')->user()->id)

                                    <tr>
                                        <th scope="row">{{ $history->id }}</th>
                                        <td>{{ $history->amount }} DA</td>
                                        <td>

                                            @if ($history->status == 0)
                                                <label class="badge badge-warning">En Attente</label>
                                            @elseif($history->status==2)
                                                <label class="badge badge-success">Confirmé</label>
                                            @elseif($history->status==3)
                                                <label class="badge badge-secoundary">Approuvé</label>
                                            @else
                                                <label class="badge badge-danger">Decliner</label>
                                            @endif

                                        </td>
                                        <td>{{ $history->created_at }}</td>
                                    </tr>

                                @endif


                            @endforeach


                        </tbody>
                    </table>


                </div>

            </section>
        </div>

    </div>
@endsection
