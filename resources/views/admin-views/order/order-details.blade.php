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

                    <div class="ml-2 ml-sm-3">
                        <span class="btn btn-success ghano-copy">
                            <i class="tio-copy"></i> 
                        </span>
                    </div>
                    <!-- End Unfold -->
                   
                            @php $order->shipping ? $contact_name_person_shipping = $order->shipping['contact_person_name'] : 'empty' @endphp
                            @php $order->shipping ? $contact_phone_shipping = $order->shipping['phone'] : 'Empty' @endphp
                            


                            @foreach ($wilayas as $wilaya)
                                @if ($wilaya->id == $order->shipping->country)
                                @php $order->shipping ? $ww = $wilaya->wilaya : 'Empty' @endphp
                                @endif
                            @endforeach
                            
                            

                            @foreach ($dayras as $dayra)
                                @if ($dayra->id == $order->shipping->city)
                                @php $order->shipping ? $dd = $dayra->dayra : 'Empty'  @endphp
                                @endif
                            @endforeach

                            
                            <?php $xx_text = "Commande N° : ".$order['id'] ."%0A"." Client :". $contact_name_person_shipping ."%0A"." Téléphone :". $contact_phone_shipping  ."%0A" . "Adresse Client :  " . $order->shipping->country . " - " . $ww . " / " . $dd . "%0A" ?>
                            
                            <?php $i=0; ?>
                            @foreach ($order->details as $detail) 
                                @if ($detail->product) 
                                    <?php $i =+ 1 ?>
                                    <?php $xx_text = $xx_text . "%0A" . $i  ." - ".$detail->product['name'] . "%0A" . "Quantité : " . $detail->qty . "%0A" . "Prix : " . $detail->price . " %0A "  ?>
                                @endif
                            @endforeach


                            @php($subtotal = 0)
                            @php($total = 0)
                            @php($shipping = 0)
                            @php($discount = 0)
                            @php($tax = 0)
                            @php($total_cc = 0)
                            @foreach ($order->details as $detail)
                                @if ($detail->product)
                            
                            
                            @php($discount += $detail['discount'])
                                @php($tax += $detail['tax'])
                                @php($shipping += $detail->shipping ? $detail->shipping->cost : 0)
                                @php($subtotal = $detail->price * $detail->qty  )
                                @php($total = $total +  $subtotal)

                            
                            
                        
                                <?php $xx_text = $xx_text . "Total : "  .  $total  ?>

                            
                            @endif
                        @endforeach

                 
                

                    @if( $order->order_status == 'delivered' )
                        <div class="hs-unfold float-right pr-2">
                            <a class="btn btn-success" href="https://api.whatsapp.com/send/?phone={{str_replace(' ', '', $web_config['phone']->value)}}&text={{$xx_text}}" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 39 39"><path fill="#00E676" d="M10.7 32.8l.6.3c2.5 1.5 5.3 2.2 8.1 2.2 8.8 0 16-7.2 16-16 0-4.2-1.7-8.3-4.7-11.3s-7-4.7-11.3-4.7c-8.8 0-16 7.2-15.9 16.1 0 3 .9 5.9 2.4 8.4l.4.6-1.6 5.9 6-1.5z"></path><path fill="#FFF" d="M32.4 6.4C29 2.9 24.3 1 19.5 1 9.3 1 1.1 9.3 1.2 19.4c0 3.2.9 6.3 2.4 9.1L1 38l9.7-2.5c2.7 1.5 5.7 2.2 8.7 2.2 10.1 0 18.3-8.3 18.3-18.4 0-4.9-1.9-9.5-5.3-12.9zM19.5 34.6c-2.7 0-5.4-.7-7.7-2.1l-.6-.3-5.8 1.5L6.9 28l-.4-.6c-4.4-7.1-2.3-16.5 4.9-20.9s16.5-2.3 20.9 4.9 2.3 16.5-4.9 20.9c-2.3 1.5-5.1 2.3-7.9 2.3zm8.8-11.1l-1.1-.5s-1.6-.7-2.6-1.2c-.1 0-.2-.1-.3-.1-.3 0-.5.1-.7.2 0 0-.1.1-1.5 1.7-.1.2-.3.3-.5.3h-.1c-.1 0-.3-.1-.4-.2l-.5-.2c-1.1-.5-2.1-1.1-2.9-1.9-.2-.2-.5-.4-.7-.6-.7-.7-1.4-1.5-1.9-2.4l-.1-.2c-.1-.1-.1-.2-.2-.4 0-.2 0-.4.1-.5 0 0 .4-.5.7-.8.2-.2.3-.5.5-.7.2-.3.3-.7.2-1-.1-.5-1.3-3.2-1.6-3.8-.2-.3-.4-.4-.7-.5h-1.1c-.2 0-.4.1-.6.1l-.1.1c-.2.1-.4.3-.6.4-.2.2-.3.4-.5.6-.7.9-1.1 2-1.1 3.1 0 .8.2 1.6.5 2.3l.1.3c.9 1.9 2.1 3.6 3.7 5.1l.4.4c.3.3.6.5.8.8 2.1 1.8 4.5 3.1 7.2 3.8.3.1.7.1 1 .2h1c.5 0 1.1-.2 1.5-.4.3-.2.5-.2.7-.4l.2-.2c.2-.2.4-.3.6-.5s.4-.4.5-.6c.2-.4.3-.9.4-1.4v-.7s-.1-.1-.3-.2z"></path></svg></a>
                        </div>
                    @endif
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
                             
                              @php($discount += $detail['discount'])
                                @php($tax += $detail['tax'])
                                @php($shipping += $detail->shipping ? $detail->shipping->cost : 0)
                                @php($subtotal = $detail->price * $detail->qty  )
                                @php($total = $total +  $subtotal)

                                                             
                              <td>{{ $detail->qty }}</td>
                              <td>{{(($detail->price / 100) * $detail->product['commision']) * $detail->qty}}</td>
                             
                              <td>{{ $subtotal }} DA</td>
                            </tr>
                             
                               
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
                                        
                                        <strong>{{ $total + $shipping }} DA</strong>
                                    </dd>
                                </dl>
                                <!-- End Row -->
                            </div>
                        </div>
                        <!-- End Row -->
                    </div>
                    <!-- End Body -->


                    @if($raison == null)
                    
                    @if ($order['order_status'] == "canceled") 
                         
                    <form action="{{ route('admin.orders.mafhatch') }}" method="POST">
                        <div class="card-footer text-center">
                            @csrf
                            <input type="hidden" value="{{$order['id']}}" name="order_id">
                            <input class="js-form-search form-control" type="text" name="raison"  placeholder="Pourquoi la commande est anullé" required>
                            <button type="submit" class="btn btn-primary mt-2"> Ajouter la raison </button>
                     </div>
                     
                    </form>
                        
                    
                    @endif

                    @else

                    @if ($order['order_status'] == "canceled") 
                         
                    <form action="{{ route('admin.orders.mafhatch') }}" method="POST">
                        <div class="card-footer text-center">
                            @csrf
                            <input type="hidden" value="{{$order['id']}}" name="order_id">
                            <input class="js-form-search form-control" type="text" name="raison" value="{{$raison->raison}}" placeholder="Pourquoi la commande est anullé" required>
                            <button type="submit" class="btn btn-primary mt-2"> Ajouter la raison </button>
                     </div>
                     
                    </form>
                        
                    
                    @endif 

                    @endif

                    
                    
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
        $(".ghano-copy").on('click', function() {


        let cmdDetails = "<?php echo $xx_text; ?>";

        alert(cmdDetails);

$(this).append(`
<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
<span class="sr-only">Loading...</span>
`);


var dummy = document.createElement("textarea");
// to avoid breaking orgain page when copying more words
// cant copy when adding below this code
// dummy.style.display = 'none'
document.body.appendChild(dummy);
//Be careful if you use texarea. setAttribute('value', value), which works with "input" does not work with "textarea". – Eduard
dummy.value = cmdDetails;
dummy.select();
document.execCommand("copy");
document.body.removeChild(dummy);


setTimeout(function(){
    $(".spinner-border").remove();
    $(".sr-only").remove(); 
}, 2000);
});
    </script>

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
        };

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
