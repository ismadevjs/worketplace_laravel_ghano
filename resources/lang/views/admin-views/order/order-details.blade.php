@extends('layouts.back-end.app')

@section('title', 'Order Details')

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header d-print-none p-3" style="background: white">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-no-gutter">
                            <li class="breadcrumb-item"><a class="breadcrumb-link"
                                    href="{{ route('admin.orders.list', ['status' => 'all']) }}">{{ trans('messages.Orders') }}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Détails de commande </li>
                        </ol>
                    </nav>

                    <div class="d-sm-flex align-items-sm-center">
                        <h1 class="page-header-title">{{ trans('messages.Order') }} #{{ $order['id'] }}</h1>

                        @if ($order['payment_status'] == 'paid')
                            <span class="badge badge-soft-success ml-sm-3">
                                <span class="legend-indicator bg-success"></span>{{ trans('messages.Paid') }}
                            </span>
                        @else
                            <span class="badge badge-soft-danger ml-sm-3">
                                <span class="legend-indicator bg-danger"></span>{{ trans('messages.Unpaid') }}
                            </span>
                        @endif

                        @if ($order['order_status'] == 'pending')
                            <span class="badge badge-soft-info ml-2 ml-sm-3 text-capitalize">
                                <span
                                    class="legend-indicator bg-info text"></span>{{ str_replace('_', ' ', $order['order_status']) }}
                            </span>
                        @elseif($order['order_status']=='canceled')
                            <span class="badge badge-danger ml-2 ml-sm-3 text-capitalize">
                                <span
                                    class="legend-indicator bg-danger"></span>{{ str_replace('_', ' ', $order['order_status']) }}
                            </span>
                        @elseif($order['order_status']=='processing')
                            <span class="badge badge-soft-warning ml-2 ml-sm-3 text-capitalize">
                                <span
                                    class="legend-indicator bg-warning"></span>{{ str_replace('_', ' ', $order['order_status']) }}
                            </span>

                        @elseif($order['order_status']=='delivered')
                            <span class="badge badge-soft-success ml-2 ml-sm-3 text-capitalize">
                                <span
                                    class="legend-indicator bg-success"></span>{{ str_replace('_', ' ', $order['order_status']) }}
                            </span>
                        @elseif($order['order_status']=='confirmed')
                            <span class="badge badge-soft-success ml-2 ml-sm-3 text-capitalize">
                                <span
                                    class="legend-indicator bg-success"></span>{{ str_replace('_', ' ', $order['order_status']) }}
                            </span>
                            
                        @elseif($order['order_status']=='out_for_delivery')
                            <span class="badge badge-soft-warning ml-2 ml-sm-3 text-capitalize">
                                <span
                                    class="legend-indicator bg-soft-danger"></span>{{ str_replace('_', ' ', $order['order_status']) }}
                            </span>
                            
                            
                        @else
                            <span class="badge badge-soft-danger ml-2 ml-sm-3 text-capitalize">
                                <span
                                    class="legend-indicator bg-danger"></span>{{ str_replace('_', ' ', $order['order_status']) }}
                            </span>
                        @endif
                        <span class="ml-2 ml-sm-3">
                            <i class="tio-date-range"></i> {{ date('d M Y H:i:s', strtotime($order['created_at'])) }}
                        </span>
                    </div>
                    <div class="col-md-6 mt-2">
                        <a class="text-body mr-3" target="_blank"
                            href={{ route('admin.orders.generate-invoice', [$order['id']]) }}>
                            <i class="tio-print mr-1"></i> {{ trans('messages.Print') }}
                            {{ trans('messages.invoice') }}
                        </a>
                    </div>

                    <!-- Unfold -->

                    <div class="hs-unfold float-right">
                        <div class="dropdown">
                            <select name="order_status" onchange="order_status(this.value)" class="status form-control"
                                data-id="{{ $order['id'] }}">

                                <!--<option value="pending" {{ $order->order_status == 'pending' ? 'selected' : '' }}>
                                    {{ trans('messages.Pending') }}</option>-->
                                <option value="processing" {{ $order->order_status == 'processing' ? 'selected' : '' }}>
                                    {{ trans('messages.Processing') }} </option>
                                <option value="delivered" {{ $order->order_status == 'delivered' ? 'selected' : '' }}>
                                    {{ trans('messages.Delivered') }} </option>
                                <option value="confirmed" {{ $order->order_status == 'confirmed' ? 'selected' : '' }}>
                                    {{ trans('messages.Confirmed') }} </option>
                                <option value="canceled" {{ $order->order_status == 'canceled' ? 'selected' : '' }}>
                                    {{ trans('messages.canceled') }} </option>
                                <option value="out_for_delivery" {{ $order->order_status == 'out_for_delivery' ? 'selected' : '' }}>
                                    {{ trans('messages.out_for_delivery') }} </option>
                                    
                            </select>
                        </div>
                    </div>
                    <div class="hs-unfold float-right pr-2">
                        <div class="dropdown">
                            <select name="payment_status" class="payment_status form-control"
                                data-id="{{ $order['id'] }}">

                                <option
                                    onclick="route_alert('{{ route('admin.orders.payment-status', ['id' => $order['id'], 'payment_status' => 'paid']) }}','Change status to paid ?')"
                                    href="javascript:" value="paid"
                                    {{ $order->payment_status == 'paid' ? 'selected' : '' }}>
                                    {{ trans('messages.Paid') }}
                                </option>
                                <option value="unpaid" {{ $order->payment_status == 'unpaid' ? 'selected' : '' }}>
                                    {{ trans('messages.Unpaid') }}
                                </option>

                            </select>
                        </div>
                    </div>
                    <!-- End Unfold -->
                </div>
            </div>
        </div>

        <!-- End Page Header -->

        <div class="row" id="printableArea">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <!-- Card -->
                <div class="card mb-3 mb-lg-5">
                    <!-- Header -->
                    <div class="card-header" style="display: block!important;">
                        <div class="row">
                            <div class="col-12 pb-2 border-bottom">
                                <h4 class="card-header-title">
                                    Détails de commande
                                    <span
                                        class="badge badge-soft-dark rounded-circle ml-1">{{ $order->details->count() }}</span>
                                </h4>
                            </div>
                            <div class="col-6 pt-2">

                            </div>
                            <div class="col-6 pt-2">
                                <div class="text-right">
                                    <h6 class="" style="color: #8a8a8a;">
                                        {{ trans('messages.Payment') }} {{ trans('messages.Method') }}
                                        : {{ str_replace('_', ' ', $order['payment_method']) }}
                                    </h6>
                                    <h6 class="" style="color: #8a8a8a;">
                                        {{ trans('messages.Payment') }} {{ trans('messages.reference') }}
                                        : {{ str_replace('_', ' ', $order['transaction_ref']) }}
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Header -->

                    <!-- Body -->
                    <div class="card-body">
                        <div class="table-responsive">
                        
                        <table class="table">
                          <thead>
                            <tr>
                              <th scope="col">{{ trans('messages.image') }}</th>
                              <th scope="col">{{ trans('messages.Name') }}</th>
                              <th scope="col">{{ trans('messages.price') }}</th>
                              <th scope="col">Qtt</th>
                              <th scope="col">Cms</th>
                              <th scope="col">{{ trans('messages.Subtotal') }}</th>
                            </tr>
                          </thead>
                          <tbody>
                           @php($subtotal = 0)
                            @php($total = 0)
                            @php($shipping = 0)
                            @php($discount = 0)
                            @php($tax = 0)
                            @php($total_cc = 0)
                            @foreach ($order->details as $detail)
                                @if ($detail->product)
                            <tr>
                              <th scope="row">
                                  <div class="avatar avatar-xl mr-3">
                                        <img class="img-fluid"
                                            onerror="this.src='{{ asset('public/assets/back-end/img/160x160/img2.jpg') }}'"
                                            src="{{ \App\CPU\ProductManager::product_image_path('thumbnail') }}/{{ $detail->product['thumbnail'] }}"
                                            alt="Image Description">
                                    </div></th>
                              <td>{{ substr($detail->product['name'], 0, 100) }}{{ strlen($detail->product['name']) > 10 ? '...' : '' }}</td>
                              <td>{{ \App\CPU\BackEndHelper::usd_to_currency($detail['price']) }}</td>
                              <td>{{ $detail->qty }}</td>
                              <td>{{(($detail->price / 100) * $detail->product['commision']) * $detail->qty}}</td>
                             
                              <td>{{ \App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($subtotal)) }}</td>
                            </tr>
                             @php($discount += $detail['discount'])
                                @php($tax += $detail['tax'])
                                @php($shipping += $detail->shipping ? $detail->shipping->cost : 0)

                                @php($total += $subtotal)
                               
                            @endif
                        @endforeach
                          </tbody>
                        </table>

                        </div>
                        

                              

                        <div class="row justify-content-md-end mb-3">
                            <div class="col-md-9 col-lg-8">
                                <dl class="row text-sm-right">
                                    <dt class="col-sm-6">{{ trans('messages.Shipping') }}</dt>
                                    <dd class="col-sm-6 border-bottom">
                                        <strong>{{ \App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($shipping)) }}</strong>
                                    </dd>

                                    <dt class="col-sm-6">{{ trans('messages.Total') }}</dt>
                                    <dd class="col-sm-6">
                                        <strong>{{ \App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($total + $shipping)) }}</strong>
                                    </dd>
                                </dl>
                                <!-- End Row -->
                            </div>
                        </div>
                        <!-- End Row -->
                    </div>
                    <!-- End Body -->
                </div>
                <!-- End Card -->
            </div>

            <div class="col-lg-4">
                <!-- Card -->
                <div class="card">
                    <!-- Header -->
                    <div class="card-header">
                        <h4 class="card-header-title"> 
                        @if($order->customer['seller'] == 1) Vendeur @else Client  @endif  
                        
                        </h4>
                    </div>
                    <!-- End Header -->

                    <!-- Body -->
                    @if ($order->customer)
                       
                        <div class="card-body">
                            <div class="media align-items-center" href="javascript:">
                                <div class="avatar avatar-circle mr-3">
                                    <img class="avatar-img" style="width: 75px;height: 42px"
                                        onerror="this.src='{{ asset('public/assets/front-end/img/image-place-holder.png') }}'"
                                        src="{{ asset('storage/app/public/profile/' . $order->customer->image) }}"
                                        alt="Image">
                                </div>
                                <div class="media-body">
                                    <span
                                        class="text-body text-hover-primary">{{ $order->customer['f_name'] . ' ' . $order->customer['l_name'] }}</span>
                                </div>
                                <div class="media-body text-right">
                                    {{-- <i class="tio-chevron-right text-body"></i> --}}
                                </div>
                            </div>

                            <hr>

                            <div class="media align-items-center" href="javascript:">
                                <div class="icon icon-soft-info icon-circle mr-3">
                                    <i class="tio-shopping-basket-outlined"></i>
                                </div>
                                <div class="media-body">
                                    <span class="text-body text-hover-primary">
                                        {{ \App\Model\Order::where('customer_id', $order['customer_id'])->count() }}
                                        orders</span>
                                </div>
                                <div class="media-body text-right">
                                    {{-- <i class="tio-chevron-right text-body"></i> --}}
                                </div>
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between align-items-center">
                                <h5>{{ trans('messages.Contact') }} {{ trans('messages.info') }} </h5>
                            </div>

                            <ul class="list-unstyled list-unstyled-py-2">
                                <li>
                                    <i class="tio-online mr-2"></i>
                                    {{ $order->customer['email'] }}
                                </li>
                                <li>
                                    <i class="tio-android-phone-vs mr-2"></i>
                                    {{ $order->customer['phone'] }}
                                </li>
                            </ul>

                            <hr>


                            <div class="d-flex justify-content-between align-items-center">
                                <h5>{{ trans('messages.shipping_address') }}</h5>

                            </div>

                            <?php $counter = 0; ?>
                            @foreach ($shipping_addresses as $foo)
                                @if ($foo->phone == $order->shipping['phone'])
                                    {{ $counter = $counter + 1 }}
                                @endif
                            @endforeach


                            
                            <span class="d-block">
                                {{ trans('messages.Name') }} :
                                <strong>{{ $order->shipping ? $order->shipping['contact_person_name'] : 'empty' }}</strong>
                                @if ($counter > 1)<strong class="badge-success"> Dupliqué </strong> @endif <br>
                                {{ trans('messages.Country') }}:
                                @foreach ($wilayas as $wilaya)
                                    @if ($wilaya->id == $order->shipping->country)
                                    <strong>{{ $order->shipping ? $wilaya->wilaya : 'Empty' }}</strong><br>
                                    @endif
                                @endforeach
                                
                                {{ trans('messages.City') }}:

                                @foreach ($dayras as $dayra)
                                    @if ($dayra->id == $order->shipping->city)
                                    <strong>{{ $order->shipping ? $dayra->dayra : 'Empty' }}</strong><br>
                                    @endif
                                @endforeach
                                {{ trans('messages.Commission') }} :
                                
                                <?php $total_cc += (($detail->price / 100) * $detail->product['commision']) * $detail->qty ?>
                                <strong class="text-warning ">{{$total_cc}} DA</strong><br>
                               
                                {{ trans('messages.address') }} :
                                <p>{{ $order->shipping ? $order->shipping['address'] : 'Empty' }}</p><br>
                                {{ trans('messages.Phone') }}:
                                <strong>{{ $order->shipping ? $order->shipping['phone'] : 'Empty' }}</strong>

                            </span>

                        </div>
                    @endif
                    <!-- End Body -->
                </div>
                <!-- End Card -->
            </div>
        </div>
        <!-- End Row -->
    </div>
@endsection

@push('script_2')
    <script>
        $(document).on('change', '.payment_status', function() {
            var id = $(this).attr("data-id");
            var value = $(this).val();
            Swal.fire({
                title: 'Are you sure Change this?',
                text: "You won't be able to revert this!",
                showCancelButton: true,
                confirmButtonColor: '#377dff',
                cancelButtonColor: 'secondary',
                confirmButtonText: 'Yes, Change it!'
            }).then((result) => {
                if (result.value) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{ route('admin.orders.payment-status') }}",
                        method: 'POST',
                        data: {
                            "id": id,
                            "payment_status": value
                        },
                        success: function(data) {
                            toastr.success('Status Change successfully');
                            location.reload();
                        }
                    });
                }
            })
        });

        function order_status(status) {
            var value = status;
            Swal.fire({
                title: 'Are you sure Change this?',
                text: "You won't be able to revert this!",
                showCancelButton: true,
                confirmButtonColor: '#377dff',
                cancelButtonColor: 'secondary',
                confirmButtonText: 'Yes, Change it!'
            }).then((result) => {
                if (result.value) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{ route('admin.orders.status') }}",
                        method: 'POST',
                        data: {
                            "id": '{{ $order['id'] }}',
                            "order_status": value
                        },
                        success: function(data) {
                            toastr.success('Status Change successfully');
                            location.reload();
                        }
                    });
                }
            })
        }

        $(document).on('change', '.product_status', function() {
            var id = $(this).attr("data-id");
            var value = $(this).val();
            Swal.fire({
                title: 'Are you sure Change this?',
                text: "You won't be able to revert this!",
                showCancelButton: true,
                confirmButtonColor: '#377dff',
                cancelButtonColor: 'secondary',
                confirmButtonText: 'Yes, Change it!'
            }).then((result) => {
                if (result.value) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{ route('admin.orders.productStatus') }}",
                        method: 'POST',
                        data: {
                            "id": id,
                            "delivery_status": value
                        },
                        success: function(data) {
                            if (data.success == 0) {
                                toastr.warning(data.message);
                            } else {
                                toastr.success('Product Status updated successfully');
                                location.reload();
                            }
                        }
                    });
                }
            })
        });
    </script>
@endpush
