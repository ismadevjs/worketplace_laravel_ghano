@extends('layouts.front-end.app')

@section('title', 'Shipping Address Choose')



@section('content')
    <div class="container pb-5 mb-2 mb-md-4">
        <div class="row">
            <div class="col-md-12 mb-5 pt-5">
                <div class="feature_header" style="background: #dcdcdc;line-height: 1px">
                    <span>{{ trans('messages.shipping_address') }}</span>
                </div>
            </div>
            <section class="col-lg-8">
                <hr>
                <div class="checkout_details mt-3">
                    <!-- Steps-->
                    @include('web-views.partials._checkout-steps',['step'=>2])
                    <!-- Shipping methods table-->
                    <h2 class="h4 pb-3 mb-2 mt-5">{{ trans('messages.shipping_address') }}
                        {{ trans('messages.choose_shipping_address') }}</h2>
                    @php($shipping_addresses = \App\Model\ShippingAddress::where('customer_id', auth('customer')->id())->get())
                    <form method="post" action="" id="address-form">
                        @csrf
                        <div class="card-body" style="padding: 0!important;">
                            <ul class="list-group">
                               
                                <li class="list-group-item mb-2 mt-2" onclick="anotherAddress()">
                                   
                                    <div id="accordion">
                                        
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label
                                                        for="exampleInputEmail1">{{ trans('messages.contact_person_name') }}
                                                        <span style="color: red">*</span></label>
                                                    <input type="text" class="form-control" name="contact_person_name"
                                                        {{ $shipping_addresses->count() == 0 ? 'required' : '' }}>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">{{ trans('messages.Phone') }}<span
                                                            style="color: red">*</span></label>
                                                    <input type="text" class="form-control" name="phone"
                                                        {{ $shipping_addresses->count() == 0 ? 'required' : '' }}>
                                                </div>
                                                <div class="form-group" hidden>
                                                    <label for="exampleInputPassword1">{{ trans('messages.address') }}
                                                        {{ trans('messages.Type') }}</label>
                                                    <select class="form-control" name="address_type">
                                                        <option value="permanent">{{ trans('messages.Permanent') }}
                                                        </option>
                                                        <option value="home">{{ trans('messages.Home') }}</option>
                                                        <option value="others">{{ trans('messages.Others') }}</option>
                                                    </select>
                                                </div>


                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="reg-wilaya">Wilaya</label>
                                                        <select class="form-select form-control wilayas" name="wilayas"
                                                            aria-label="Default select example">
                                                            <option selected>-</option>
                                                            @foreach ($wilayas as $wilaya)
                                                                <option value="{{ $wilaya->id }}">
                                                                    {{ $wilaya->wilaya }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="reg-wilaya">Commune</label>
                                                        <select class="form-select form-control dayras" id="dayras"
                                                            name="dayras" aria-label="Default select example">
                                                            <option selected>-</option>
                                                        </select>
                                                    </div>
                                                </div>


                                                {{-- <div class="form-group">
                                                    <label for="exampleInputEmail1">{{ trans('messages.City') }} <span
                                                            style="color: red">*</span></label>
                                                    <input type="text" class="form-control" name="city"
                                                        {{ $shipping_addresses->count() == 0 ? 'required' : '' }}>
                                                </div> --}}

                                                <div class="form-group" hidden>
                                                    <label for="exampleInputEmail1">{{ trans('messages.zip_code') }}
                                                        <span style="color: red">*</span></label>
                                                    <input type="number" class="form-control" name="zip" value='0'
                                                    >
                                                </div>

                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">{{ trans('messages.address') }} <span
                                                            style="color: red">*</span></label>
                                                    <textarea class="form-control" name="address"
                                                        {{ $shipping_addresses->count() == 0 ? 'required' : '' }}></textarea>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" name="save_address" class="form-check-input"
                                                        id="exampleCheck1">
                                                    <label class="form-check-label" for="exampleCheck1">
                                                        {{ trans('messages.save_this_address') }}
                                                    </label>
                                                </div>
                                                <button type="submit" class="btn btn-primary" style="display: none"
                                                    id="address_submit"></button>
                                            </div>
                                        </div>
                                  
                                </li>
                            </ul>
                        </div>
                    </form>
                    <!-- Navigation (desktop)-->
                    <div class="row">
                        <div class="col-6">
                            <a class="btn btn-secondary btn-block" href="{{ route('checkout-details') }}">
                                <i class="czi-arrow-left mt-sm-0 mr-1"></i>
                                <span class="d-none d-sm-inline">{{ trans('messages.Back') }}
                                    {{ trans('messages.to') }}
                                    {{ trans('messages.address') }}</span>
                                <span class="d-inline d-sm-none">{{ trans('messages.Back') }}</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a class="btn btn-primary btn-block" href="javascript:" onclick="proceed_to_next()">
                                <span class="d-none d-sm-inline">{{ trans('messages.proceed_payment') }}</span>
                                <span class="d-inline d-sm-none">{{ trans('messages.Next') }}</span>
                                <i class="czi-arrow-right mt-sm-0 ml-1"></i>
                            </a>
                        </div>
                    </div>
                    <!-- Sidebar-->
                </div>
            </section>
            @include('web-views.partials._order-summary')
        </div>
    </div>
@endsection

@push('script')

    <script>
        function anotherAddress() {
            $('#sh-0').prop('checked', true);
            $("#collapseThree").collapse();
        }
    </script>

    <script>
        function proceed_to_next() {

            let allAreFilled = true;
            document.getElementById("address-form").querySelectorAll("[required]").forEach(function(i) {
                if (!allAreFilled) return;
                if (!i.value) allAreFilled = false;
                if (i.type === "radio") {
                    let radioValueCheck = false;
                    document.getElementById("address-form").querySelectorAll(`[name=${i.name}]`).forEach(function(
                        r) {
                        if (r.checked) radioValueCheck = true;
                    });
                    allAreFilled = radioValueCheck;
                }
            });


            if (allAreFilled) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.post({
                    url: '{{ route('customer.choose-shipping-address') }}',
                    dataType: 'json',
                    data: $('#address-form').serialize(),
                    beforeSend: function() {
                        $('#loading').show();
                    },
                    success: function(data) {
                        if (data.errors) {
                            for (var i = 0; i < data.errors.length; i++) {
                                toastr.error(data.errors[i].message, {
                                    CloseButton: true,
                                    ProgressBar: true
                                });
                            }
                        } else {
                            location.href = '{{ route('checkout-payment') }}';
                        }
                    },
                    complete: function() {
                        $('#loading').hide();
                    },
                    error: function() {
                        toastr.error('Something went wrong!', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    }
                });
            } else {
                toastr.error('Please fill all required fields', {
                    CloseButton: true,
                    ProgressBar: true
                });
            }
        }
    </script>


    <script>
        const dayras = [{
                "id": "1",
                "wilaya_id": "1",
                "dayra": "Adrar",
                "status": "1",
                "created": null
            },
            {
                "id": "2",
                "wilaya_id": "1",
                "dayra": "Akabli",
                "status": "1",
                "created": null
            },
            {
                "id": "3",
                "wilaya_id": "1",
                "dayra": "Aougrout",
                "status": "1",
                "created": null
            },
            {
                "id": "4",
                "wilaya_id": "1",
                "dayra": "Aoulef",
                "status": "1",
                "created": null
            },
            {
                "id": "5",
                "wilaya_id": "1",
                "dayra": "Bordj badji mokhtar",
                "status": "1",
                "created": null
            },
            {
                "id": "6",
                "wilaya_id": "1",
                "dayra": "Bouda",
                "status": "1",
                "created": null
            },
            {
                "id": "7",
                "wilaya_id": "1",
                "dayra": "Charouine",
                "status": "1",
                "created": null
            },
            {
                "id": "8",
                "wilaya_id": "1",
                "dayra": "Deldoul",
                "status": "1",
                "created": null
            },
            {
                "id": "9",
                "wilaya_id": "1",
                "dayra": "Fenoughil",
                "status": "1",
                "created": null
            },
            {
                "id": "10",
                "wilaya_id": "1",
                "dayra": "In zghamir",
                "status": "1",
                "created": null
            },
            {
                "id": "11",
                "wilaya_id": "1",
                "dayra": "Ksar kaddour",
                "status": "1",
                "created": null
            },
            {
                "id": "12",
                "wilaya_id": "1",
                "dayra": "Metarfa",
                "status": "1",
                "created": null
            },
            {
                "id": "13",
                "wilaya_id": "1",
                "dayra": "Ouled ahmed timmi",
                "status": "1",
                "created": null
            },
            {
                "id": "14",
                "wilaya_id": "1",
                "dayra": "Ouled aissa",
                "status": "1",
                "created": null
            },
            {
                "id": "15",
                "wilaya_id": "1",
                "dayra": "Ouled said",
                "status": "1",
                "created": null
            },
            {
                "id": "16",
                "wilaya_id": "1",
                "dayra": "Reggane",
                "status": "1",
                "created": null
            },
            {
                "id": "17",
                "wilaya_id": "1",
                "dayra": "Sali",
                "status": "1",
                "created": null
            },
            {
                "id": "18",
                "wilaya_id": "1",
                "dayra": "Sebaa",
                "status": "1",
                "created": null
            },
            {
                "id": "19",
                "wilaya_id": "1",
                "dayra": "Talmine",
                "status": "1",
                "created": null
            },
            {
                "id": "20",
                "wilaya_id": "1",
                "dayra": "Tamantit",
                "status": "1",
                "created": null
            },
            {
                "id": "21",
                "wilaya_id": "1",
                "dayra": "Tamest",
                "status": "1",
                "created": null
            },
            {
                "id": "22",
                "wilaya_id": "1",
                "dayra": "Timekten",
                "status": "1",
                "created": null
            },
            {
                "id": "23",
                "wilaya_id": "1",
                "dayra": "Timiaouine",
                "status": "1",
                "created": null
            },
            {
                "id": "24",
                "wilaya_id": "1",
                "dayra": "Timmimoun",
                "status": "1",
                "created": null
            },
            {
                "id": "25",
                "wilaya_id": "1",
                "dayra": "Tinerkouk",
                "status": "1",
                "created": null
            },
            {
                "id": "26",
                "wilaya_id": "1",
                "dayra": "Tit",
                "status": "1",
                "created": null
            },
            {
                "id": "27",
                "wilaya_id": "1",
                "dayra": "Tsabit",
                "status": "1",
                "created": null
            },
            {
                "id": "28",
                "wilaya_id": "1",
                "dayra": "Zaouiet kounta",
                "status": "1",
                "created": null
            },
            {
                "id": "29",
                "wilaya_id": "0",
                "dayra": "",
                "status": "1",
                "created": null
            },
            {
                "id": "30",
                "wilaya_id": "3",
                "dayra": "Abou el hassane",
                "status": "1",
                "created": null
            },
            {
                "id": "31",
                "wilaya_id": "3",
                "dayra": "Ain merane",
                "status": "1",
                "created": null
            },
            {
                "id": "32",
                "wilaya_id": "3",
                "dayra": "Benairia",
                "status": "1",
                "created": null
            },
            {
                "id": "33",
                "wilaya_id": "3",
                "dayra": "Beni bouttab",
                "status": "1",
                "created": null
            },
            {
                "id": "34",
                "wilaya_id": "3",
                "dayra": "Beni Haoua",
                "status": "1",
                "created": null
            },
            {
                "id": "35",
                "wilaya_id": "3",
                "dayra": "Beni rached",
                "status": "1",
                "created": null
            },
            {
                "id": "36",
                "wilaya_id": "3",
                "dayra": "Boukadir",
                "status": "1",
                "created": null
            },
            {
                "id": "37",
                "wilaya_id": "3",
                "dayra": "Bouzghaia",
                "status": "1",
                "created": null
            },
            {
                "id": "38",
                "wilaya_id": "3",
                "dayra": "Breira",
                "status": "1",
                "created": null
            },
            {
                "id": "39",
                "wilaya_id": "3",
                "dayra": "Chettia",
                "status": "1",
                "created": null
            },
            {
                "id": "40",
                "wilaya_id": "3",
                "dayra": "Chlef",
                "status": "1",
                "created": null
            },
            {
                "id": "41",
                "wilaya_id": "3",
                "dayra": "Dahra",
                "status": "1",
                "created": null
            },
            {
                "id": "42",
                "wilaya_id": "3",
                "dayra": "El hadjadj",
                "status": "1",
                "created": null
            },
            {
                "id": "43",
                "wilaya_id": "3",
                "dayra": "El karimia",
                "status": "1",
                "created": null
            },
            {
                "id": "44",
                "wilaya_id": "3",
                "dayra": "El marsa",
                "status": "1",
                "created": null
            },
            {
                "id": "45",
                "wilaya_id": "3",
                "dayra": "Harchoun",
                "status": "1",
                "created": null
            },
            {
                "id": "46",
                "wilaya_id": "3",
                "dayra": "Herenfa",
                "status": "1",
                "created": null
            },
            {
                "id": "47",
                "wilaya_id": "3",
                "dayra": "Labiod medjadja",
                "status": "1",
                "created": null
            },
            {
                "id": "48",
                "wilaya_id": "3",
                "dayra": "Moussadek",
                "status": "1",
                "created": null
            },
            {
                "id": "49",
                "wilaya_id": "3",
                "dayra": "Oued fodda",
                "status": "1",
                "created": null
            },
            {
                "id": "50",
                "wilaya_id": "3",
                "dayra": "Oued goussine",
                "status": "1",
                "created": null
            },
            {
                "id": "51",
                "wilaya_id": "3",
                "dayra": "Oued sly",
                "status": "1",
                "created": null
            },
            {
                "id": "52",
                "wilaya_id": "3",
                "dayra": "Ouled abbes",
                "status": "1",
                "created": null
            },
            {
                "id": "53",
                "wilaya_id": "3",
                "dayra": "Ouled ben abbdelkader",
                "status": "1",
                "created": null
            },
            {
                "id": "54",
                "wilaya_id": "3",
                "dayra": "Ouled fares",
                "status": "1",
                "created": null
            },
            {
                "id": "55",
                "wilaya_id": "3",
                "dayra": "Oum drou",
                "status": "1",
                "created": null
            },
            {
                "id": "56",
                "wilaya_id": "3",
                "dayra": "Sendjas",
                "status": "1",
                "created": null
            },
            {
                "id": "57",
                "wilaya_id": "3",
                "dayra": "Sidi abderrahmane",
                "status": "1",
                "created": null
            },
            {
                "id": "58",
                "wilaya_id": "3",
                "dayra": "Sidi akkacha",
                "status": "1",
                "created": null
            },
            {
                "id": "59",
                "wilaya_id": "3",
                "dayra": "Sobha",
                "status": "1",
                "created": null
            },
            {
                "id": "60",
                "wilaya_id": "3",
                "dayra": "Tadjena",
                "status": "1",
                "created": null
            },
            {
                "id": "61",
                "wilaya_id": "3",
                "dayra": "Talassa",
                "status": "1",
                "created": null
            },
            {
                "id": "62",
                "wilaya_id": "3",
                "dayra": "Taougrit",
                "status": "1",
                "created": null
            },
            {
                "id": "63",
                "wilaya_id": "3",
                "dayra": "Tenes",
                "status": "1",
                "created": null
            },
            {
                "id": "64",
                "wilaya_id": "3",
                "dayra": "Zeboudja",
                "status": "1",
                "created": null
            },
            {
                "id": "65",
                "wilaya_id": "4",
                "dayra": "Aflou",
                "status": "1",
                "created": null
            },
            {
                "id": "66",
                "wilaya_id": "4",
                "dayra": "Ain madhi",
                "status": "1",
                "created": null
            },
            {
                "id": "67",
                "wilaya_id": "4",
                "dayra": "Ain sidi ali",
                "status": "1",
                "created": null
            },
            {
                "id": "68",
                "wilaya_id": "4",
                "dayra": "Benacer benchohra",
                "status": "1",
                "created": null
            },
            {
                "id": "69",
                "wilaya_id": "4",
                "dayra": "Brida",
                "status": "1",
                "created": null
            },
            {
                "id": "70",
                "wilaya_id": "4",
                "dayra": "El assafia",
                "status": "1",
                "created": null
            },
            {
                "id": "71",
                "wilaya_id": "4",
                "dayra": "El beidha",
                "status": "1",
                "created": null
            },
            {
                "id": "72",
                "wilaya_id": "4",
                "dayra": "El ghicha",
                "status": "1",
                "created": null
            },
            {
                "id": "73",
                "wilaya_id": "4",
                "dayra": "El hauaita",
                "status": "1",
                "created": null
            },
            {
                "id": "74",
                "wilaya_id": "4",
                "dayra": "Gueltat sidi saad",
                "status": "1",
                "created": null
            },
            {
                "id": "75",
                "wilaya_id": "4",
                "dayra": "Hadj delaa",
                "status": "1",
                "created": null
            },
            {
                "id": "76",
                "wilaya_id": "4",
                "dayra": "Hassi rmel",
                "status": "1",
                "created": null
            },
            {
                "id": "77",
                "wilaya_id": "4",
                "dayra": "Kheneg",
                "status": "1",
                "created": null
            },
            {
                "id": "78",
                "wilaya_id": "4",
                "dayra": "Ksar el hirane",
                "status": "1",
                "created": null
            },
            {
                "id": "79",
                "wilaya_id": "4",
                "dayra": "Laghouat",
                "status": "1",
                "created": null
            },
            {
                "id": "80",
                "wilaya_id": "4",
                "dayra": "Oued mzi",
                "status": "1",
                "created": null
            },
            {
                "id": "81",
                "wilaya_id": "4",
                "dayra": "Oued morra",
                "status": "1",
                "created": null
            },
            {
                "id": "82",
                "wilaya_id": "4",
                "dayra": "Sebgag",
                "status": "1",
                "created": null
            },
            {
                "id": "83",
                "wilaya_id": "4",
                "dayra": "Sidi Bouzid",
                "status": "1",
                "created": null
            },
            {
                "id": "84",
                "wilaya_id": "4",
                "dayra": "Tadjrouna",
                "status": "1",
                "created": null
            },
            {
                "id": "85",
                "wilaya_id": "4",
                "dayra": "Touiala",
                "status": "1",
                "created": null
            },
            {
                "id": "89",
                "wilaya_id": "5",
                "dayra": "Ain babouche",
                "status": "1",
                "created": null
            },
            {
                "id": "90",
                "wilaya_id": "5",
                "dayra": "Ain beida",
                "status": "1",
                "created": null
            },
            {
                "id": "91",
                "wilaya_id": "5",
                "dayra": "Ain diss",
                "status": "1",
                "created": null
            },
            {
                "id": "92",
                "wilaya_id": "5",
                "dayra": "Ain fekroun",
                "status": "1",
                "created": null
            },
            {
                "id": "93",
                "wilaya_id": "5",
                "dayra": "Ain kercha",
                "status": "1",
                "created": null
            },
            {
                "id": "94",
                "wilaya_id": "5",
                "dayra": "Ain mlila",
                "status": "1",
                "created": null
            },
            {
                "id": "95",
                "wilaya_id": "5",
                "dayra": "Ain zitoun",
                "status": "1",
                "created": null
            },
            {
                "id": "96",
                "wilaya_id": "5",
                "dayra": "Behir chergui",
                "status": "1",
                "created": null
            },
            {
                "id": "97",
                "wilaya_id": "5",
                "dayra": "Berriche",
                "status": "1",
                "created": null
            },
            {
                "id": "98",
                "wilaya_id": "5",
                "dayra": "Bir chouhada",
                "status": "1",
                "created": null
            },
            {
                "id": "99",
                "wilaya_id": "5",
                "dayra": "Dhalaa",
                "status": "1",
                "created": null
            },
            {
                "id": "100",
                "wilaya_id": "5",
                "dayra": "El amiria",
                "status": "1",
                "created": null
            },
            {
                "id": "101",
                "wilaya_id": "5",
                "dayra": "El belala",
                "status": "1",
                "created": null
            },
            {
                "id": "102",
                "wilaya_id": "5",
                "dayra": "El djazia",
                "status": "1",
                "created": null
            },
            {
                "id": "103",
                "wilaya_id": "5",
                "dayra": "El fedjoudj boughrara sa",
                "status": "1",
                "created": null
            },
            {
                "id": "104",
                "wilaya_id": "5",
                "dayra": "El harmilia",
                "status": "1",
                "created": null
            },
            {
                "id": "105",
                "wilaya_id": "5",
                "dayra": "Hanchir Toumghani",
                "status": "1",
                "created": null
            },
            {
                "id": "106",
                "wilaya_id": "5",
                "dayra": "Ouled Gacem",
                "status": "1",
                "created": null
            },
            {
                "id": "107",
                "wilaya_id": "5",
                "dayra": "Ouled Hamla",
                "status": "1",
                "created": null
            },
            {
                "id": "108",
                "wilaya_id": "5",
                "dayra": "Dhalâa",
                "status": "1",
                "created": null
            },
            {
                "id": "109",
                "wilaya_id": "5",
                "dayra": "Souk Naamane",
                "status": "1",
                "created": null
            },
            {
                "id": "110",
                "wilaya_id": "5",
                "dayra": "Fkirina",
                "status": "1",
                "created": null
            },
            {
                "id": "111",
                "wilaya_id": "5",
                "dayra": "Oued Nini",
                "status": "1",
                "created": null
            },
            {
                "id": "112",
                "wilaya_id": "5",
                "dayra": "Ksar Sbahi",
                "status": "1",
                "created": null
            },
            {
                "id": "113",
                "wilaya_id": "5",
                "dayra": "Rahia",
                "status": "1",
                "created": null
            },
            {
                "id": "114",
                "wilaya_id": "5",
                "dayra": "El Belala",
                "status": "1",
                "created": null
            },
            {
                "id": "115",
                "wilaya_id": "5",
                "dayra": "Oum el Bouaghi",
                "status": "1",
                "created": null
            },
            {
                "id": "116",
                "wilaya_id": "5",
                "dayra": "Sigus",
                "status": "1",
                "created": null
            },
            {
                "id": "117",
                "wilaya_id": "5",
                "dayra": "Ouled Zouaï",
                "status": "1",
                "created": null
            },
            {
                "id": "118",
                "wilaya_id": "6",
                "dayra": "Aïn Djasser",
                "status": "1",
                "created": null
            },
            {
                "id": "119",
                "wilaya_id": "6",
                "dayra": "El Hassi",
                "status": "1",
                "created": null
            },
            {
                "id": "120",
                "wilaya_id": "6",
                "dayra": "Aïn Touta",
                "status": "1",
                "created": null
            },
            {
                "id": "121",
                "wilaya_id": "6",
                "dayra": " Ben Foudhala El Hakania",
                "status": "1",
                "created": null
            },
            {
                "id": "122",
                "wilaya_id": "6",
                "dayra": "Maafa",
                "status": "1",
                "created": null
            },
            {
                "id": "123",
                "wilaya_id": "6",
                "dayra": "Ouled Aouf",
                "status": "1",
                "created": null
            },
            {
                "id": "124",
                "wilaya_id": "6",
                "dayra": "Arris",
                "status": "1",
                "created": null
            },
            {
                "id": "125",
                "wilaya_id": "6",
                "dayra": "Tighanimine",
                "status": "1",
                "created": null
            },
            {
                "id": "126",
                "wilaya_id": "6",
                "dayra": "Barika",
                "status": "1",
                "created": null
            },
            {
                "id": "127",
                "wilaya_id": "6",
                "dayra": " M'doukel ",
                "status": "1",
                "created": null
            },
            {
                "id": "128",
                "wilaya_id": "6",
                "dayra": "Bitam",
                "status": "1",
                "created": null
            },
            {
                "id": "129",
                "wilaya_id": "6",
                "dayra": "Batna ",
                "status": "1",
                "created": null
            },
            {
                "id": "130",
                "wilaya_id": "6",
                "dayra": " Fesdis",
                "status": "1",
                "created": null
            },
            {
                "id": "131",
                "wilaya_id": "6",
                "dayra": "Oued Chaaba",
                "status": "1",
                "created": null
            },
            {
                "id": "132",
                "wilaya_id": "6",
                "dayra": "Bouzina",
                "status": "1",
                "created": null
            },
            {
                "id": "133",
                "wilaya_id": "6",
                "dayra": "Larbaâ",
                "status": "1",
                "created": null
            },
            {
                "id": "134",
                "wilaya_id": "6",
                "dayra": "Chemora",
                "status": "1",
                "created": null
            },
            {
                "id": "135",
                "wilaya_id": "6",
                "dayra": "Boulhilat",
                "status": "1",
                "created": null
            },
            {
                "id": "136",
                "wilaya_id": "6",
                "dayra": "Djezzar",
                "status": "1",
                "created": null
            },
            {
                "id": "137",
                "wilaya_id": "6",
                "dayra": " Ouled Ammar",
                "status": "1",
                "created": null
            },
            {
                "id": "138",
                "wilaya_id": "6",
                "dayra": "Abdelkader Azil",
                "status": "1",
                "created": null
            },
            {
                "id": "139",
                "wilaya_id": "6",
                "dayra": "El Madher ",
                "status": "1",
                "created": null
            },
            {
                "id": "140",
                "wilaya_id": "6",
                "dayra": " Aïn Yagout",
                "status": "1",
                "created": null
            },
            {
                "id": "141",
                "wilaya_id": "6",
                "dayra": " Boumia",
                "status": "1",
                "created": null
            },
            {
                "id": "142",
                "wilaya_id": "6",
                "dayra": "Djerma",
                "status": "1",
                "created": null
            },
            {
                "id": "143",
                "wilaya_id": "6",
                "dayra": "Ichmoul",
                "status": "1",
                "created": null
            },
            {
                "id": "144",
                "wilaya_id": "6",
                "dayra": "Foum Toub ",
                "status": "1",
                "created": null
            },
            {
                "id": "145",
                "wilaya_id": "6",
                "dayra": "Inoughissen",
                "status": "1",
                "created": null
            },
            {
                "id": "146",
                "wilaya_id": "6",
                "dayra": "Menaa",
                "status": "1",
                "created": null
            },
            {
                "id": "147",
                "wilaya_id": "6",
                "dayra": "Tigherghar",
                "status": "1",
                "created": null
            },
            {
                "id": "148",
                "wilaya_id": "6",
                "dayra": "Merouana",
                "status": "1",
                "created": null
            },
            {
                "id": "149",
                "wilaya_id": "6",
                "dayra": "Oued El Ma",
                "status": "1",
                "created": null
            },
            {
                "id": "150",
                "wilaya_id": "6",
                "dayra": "Ksar Bellezma",
                "status": "1",
                "created": null
            },
            {
                "id": "151",
                "wilaya_id": "6",
                "dayra": "Hidoussa",
                "status": "1",
                "created": null
            },
            {
                "id": "152",
                "wilaya_id": "6",
                "dayra": "N'Gaous",
                "status": "1",
                "created": null
            },
            {
                "id": "153",
                "wilaya_id": "6",
                "dayra": "Boumagueur",
                "status": "1",
                "created": null
            },
            {
                "id": "154",
                "wilaya_id": "6",
                "dayra": " Sefiane",
                "status": "1",
                "created": null
            },
            {
                "id": "155",
                "wilaya_id": "6",
                "dayra": "Ouled Si Slimane",
                "status": "1",
                "created": null
            },
            {
                "id": "156",
                "wilaya_id": "6",
                "dayra": "Taxlent",
                "status": "1",
                "created": null
            },
            {
                "id": "157",
                "wilaya_id": "6",
                "dayra": "Lemsane",
                "status": "1",
                "created": null
            },
            {
                "id": "158",
                "wilaya_id": "6",
                "dayra": "Ras Ei Aioun",
                "status": "1",
                "created": null
            },
            {
                "id": "159",
                "wilaya_id": "6",
                "dayra": "Gosbat",
                "status": "1",
                "created": null
            },
            {
                "id": "160",
                "wilaya_id": "6",
                "dayra": "Guigba",
                "status": "1",
                "created": null
            },
            {
                "id": "161",
                "wilaya_id": "6",
                "dayra": "Rahbat ",
                "status": "1",
                "created": null
            },
            {
                "id": "162",
                "wilaya_id": "6",
                "dayra": "Talkhamet",
                "status": "1",
                "created": null
            },
            {
                "id": "163",
                "wilaya_id": "6",
                "dayra": "Ouled Sellam",
                "status": "1",
                "created": null
            },
            {
                "id": "164",
                "wilaya_id": "6",
                "dayra": "Seggana ",
                "status": "1",
                "created": null
            },
            {
                "id": "165",
                "wilaya_id": "6",
                "dayra": "Tilatou",
                "status": "1",
                "created": null
            },
            {
                "id": "166",
                "wilaya_id": "6",
                "dayra": "Seriana",
                "status": "1",
                "created": null
            },
            {
                "id": "167",
                "wilaya_id": "6",
                "dayra": "Lazrou",
                "status": "1",
                "created": null
            },
            {
                "id": "168",
                "wilaya_id": "6",
                "dayra": "Zanat El Beida",
                "status": "1",
                "created": null
            },
            {
                "id": "169",
                "wilaya_id": "6",
                "dayra": "M'doukel\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "170",
                "wilaya_id": "6",
                "dayra": "Ouled Ammar\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "171",
                "wilaya_id": "6",
                "dayra": "El Hassi\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "172",
                "wilaya_id": "6",
                "dayra": "Lazrou\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "173",
                "wilaya_id": "6",
                "dayra": "Boumia",
                "status": "1",
                "created": null
            },
            {
                "id": "174",
                "wilaya_id": "0",
                "dayra": "Boulhilat\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "175",
                "wilaya_id": "0",
                "dayra": "Larbaâ\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "176",
                "wilaya_id": "7",
                "dayra": "Béjaïa\t",
                "status": "1",
                "created": null
            },
            {
                "id": "177",
                "wilaya_id": "7",
                "dayra": "Amizour\t",
                "status": "1",
                "created": null
            },
            {
                "id": "178",
                "wilaya_id": "7",
                "dayra": "Ferraoun\t",
                "status": "1",
                "created": null
            },
            {
                "id": "179",
                "wilaya_id": "7",
                "dayra": "Taourirt Ighil\t",
                "status": "1",
                "created": null
            },
            {
                "id": "180",
                "wilaya_id": "7",
                "dayra": "Chellata\t",
                "status": "1",
                "created": null
            },
            {
                "id": "181",
                "wilaya_id": "7",
                "dayra": "Tamokra\t",
                "status": "1",
                "created": null
            },
            {
                "id": "182",
                "wilaya_id": "7",
                "dayra": "Timezrit\t",
                "status": "1",
                "created": null
            },
            {
                "id": "183",
                "wilaya_id": "7",
                "dayra": "Souk El Ténine\t",
                "status": "1",
                "created": null
            },
            {
                "id": "184",
                "wilaya_id": "7",
                "dayra": "M'cisna\t",
                "status": "1",
                "created": null
            },
            {
                "id": "185",
                "wilaya_id": "7",
                "dayra": "Tinabdher\t",
                "status": "1",
                "created": null
            },
            {
                "id": "186",
                "wilaya_id": "7",
                "dayra": "Tichy\t",
                "status": "1",
                "created": null
            },
            {
                "id": "187",
                "wilaya_id": "7",
                "dayra": "Semaoun\t",
                "status": "1",
                "created": null
            },
            {
                "id": "188",
                "wilaya_id": "7",
                "dayra": "Kendira\t",
                "status": "1",
                "created": null
            },
            {
                "id": "189",
                "wilaya_id": "7",
                "dayra": "Tifra\t",
                "status": "1",
                "created": null
            },
            {
                "id": "190",
                "wilaya_id": "7",
                "dayra": "Ighram\t",
                "status": "1",
                "created": null
            },
            {
                "id": "191",
                "wilaya_id": "7",
                "dayra": "Amalou\t",
                "status": "1",
                "created": null
            },
            {
                "id": "192",
                "wilaya_id": "7",
                "dayra": "Ighil Ali\t",
                "status": "1",
                "created": null
            },
            {
                "id": "193",
                "wilaya_id": "7",
                "dayra": "Fenaïa Ilmaten\t",
                "status": "1",
                "created": null
            },
            {
                "id": "194",
                "wilaya_id": "7",
                "dayra": "Toudja\t",
                "status": "1",
                "created": null
            },
            {
                "id": "195",
                "wilaya_id": "7",
                "dayra": "Darguina\t",
                "status": "1",
                "created": null
            },
            {
                "id": "196",
                "wilaya_id": "7",
                "dayra": "Sidi-Ayad\t",
                "status": "1",
                "created": null
            },
            {
                "id": "197",
                "wilaya_id": "7",
                "dayra": "Aokas\t",
                "status": "1",
                "created": null
            },
            {
                "id": "198",
                "wilaya_id": "7",
                "dayra": "Ait Djellil",
                "status": "1",
                "created": null
            },
            {
                "id": "199",
                "wilaya_id": "7",
                "dayra": "Adekar\t",
                "status": "1",
                "created": null
            },
            {
                "id": "200",
                "wilaya_id": "7",
                "dayra": "Akbou\t",
                "status": "1",
                "created": null
            },
            {
                "id": "201",
                "wilaya_id": "7",
                "dayra": "Seddouk\t",
                "status": "1",
                "created": null
            },
            {
                "id": "202",
                "wilaya_id": "7",
                "dayra": "Tazmalt\t",
                "status": "1",
                "created": null
            },
            {
                "id": "203",
                "wilaya_id": "7",
                "dayra": "Aït-R'zine\t",
                "status": "1",
                "created": null
            },
            {
                "id": "204",
                "wilaya_id": "7",
                "dayra": "Chemini\t",
                "status": "1",
                "created": null
            },
            {
                "id": "205",
                "wilaya_id": "7",
                "dayra": "Souk-Oufella\t",
                "status": "1",
                "created": null
            },
            {
                "id": "206",
                "wilaya_id": "7",
                "dayra": "Taskriout\t",
                "status": "1",
                "created": null
            },
            {
                "id": "207",
                "wilaya_id": "7",
                "dayra": "Tibane\t",
                "status": "1",
                "created": null
            },
            {
                "id": "208",
                "wilaya_id": "7",
                "dayra": "Tala Hamza\t",
                "status": "1",
                "created": null
            },
            {
                "id": "209",
                "wilaya_id": "7",
                "dayra": "Barbacha\t",
                "status": "1",
                "created": null
            },
            {
                "id": "210",
                "wilaya_id": "7",
                "dayra": "Aït Ksila\t",
                "status": "1",
                "created": null
            },
            {
                "id": "211",
                "wilaya_id": "7",
                "dayra": "Ouzellaguen\t",
                "status": "1",
                "created": null
            },
            {
                "id": "212",
                "wilaya_id": "7",
                "dayra": "Bouhamza\t",
                "status": "1",
                "created": null
            },
            {
                "id": "213",
                "wilaya_id": "7",
                "dayra": "Beni Mellikeche\t",
                "status": "1",
                "created": null
            },
            {
                "id": "214",
                "wilaya_id": "7",
                "dayra": "Sidi-Aïch\t",
                "status": "1",
                "created": null
            },
            {
                "id": "215",
                "wilaya_id": "7",
                "dayra": "El Kseur\t",
                "status": "1",
                "created": null
            },
            {
                "id": "216",
                "wilaya_id": "7",
                "dayra": "Melbou\t",
                "status": "1",
                "created": null
            },
            {
                "id": "217",
                "wilaya_id": "7",
                "dayra": "Akfadou\t",
                "status": "1",
                "created": null
            },
            {
                "id": "218",
                "wilaya_id": "7",
                "dayra": "Leflaye\t",
                "status": "1",
                "created": null
            },
            {
                "id": "219",
                "wilaya_id": "7",
                "dayra": "Kherrata\t",
                "status": "1",
                "created": null
            },
            {
                "id": "220",
                "wilaya_id": "7",
                "dayra": "Draâ El-Kaïd\t",
                "status": "1",
                "created": null
            },
            {
                "id": "221",
                "wilaya_id": "7",
                "dayra": "Tamridjet\t",
                "status": "1",
                "created": null
            },
            {
                "id": "222",
                "wilaya_id": "7",
                "dayra": "Aït-Smail\t",
                "status": "1",
                "created": null
            },
            {
                "id": "223",
                "wilaya_id": "7",
                "dayra": "Boukhelifa\t",
                "status": "1",
                "created": null
            },
            {
                "id": "224",
                "wilaya_id": "7",
                "dayra": "Tizi N'Berber\t",
                "status": "1",
                "created": null
            },
            {
                "id": "225",
                "wilaya_id": "7",
                "dayra": "Aït Maouche\t",
                "status": "1",
                "created": null
            },
            {
                "id": "226",
                "wilaya_id": "7",
                "dayra": "Oued Ghir\t",
                "status": "1",
                "created": null
            },
            {
                "id": "227",
                "wilaya_id": "7",
                "dayra": "Boudjellil\t",
                "status": "1",
                "created": null
            },
            {
                "id": "228",
                "wilaya_id": "8",
                "dayra": "Aïn Naga\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "229",
                "wilaya_id": "8",
                "dayra": "Aïn Zaatout\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "230",
                "wilaya_id": "8",
                "dayra": "Biskra\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "231",
                "wilaya_id": "8",
                "dayra": "Bordj Ben Azzouz\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "232",
                "wilaya_id": "0",
                "dayra": "Bouchagroune\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "233",
                "wilaya_id": "8",
                "dayra": "Branis\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "234",
                "wilaya_id": "8",
                "dayra": "Chetma\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "235",
                "wilaya_id": "8",
                "dayra": "Djemorah\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "236",
                "wilaya_id": "8",
                "dayra": "El Feidh\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "237",
                "wilaya_id": "8",
                "dayra": "El Ghrous\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "238",
                "wilaya_id": "8",
                "dayra": "El Hadjeb\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "239",
                "wilaya_id": "8",
                "dayra": "El Haouch\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "240",
                "wilaya_id": "8",
                "dayra": "El Kantara\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "241",
                "wilaya_id": "8",
                "dayra": "El Mizaraa\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "242",
                "wilaya_id": "8",
                "dayra": "El Outaya\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "243",
                "wilaya_id": "8",
                "dayra": "Foughala\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "244",
                "wilaya_id": "8",
                "dayra": "Khenguet Sidi Nadji\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "245",
                "wilaya_id": "8",
                "dayra": "Lichana\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "246",
                "wilaya_id": "8",
                "dayra": "Lioua\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "247",
                "wilaya_id": "8",
                "dayra": "M'Chouneche\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "248",
                "wilaya_id": "8",
                "dayra": "Mekhadma\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "249",
                "wilaya_id": "8",
                "dayra": "M'Lili\r\n\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "250",
                "wilaya_id": "8",
                "dayra": "Oumache\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "251",
                "wilaya_id": "8",
                "dayra": "Ourlal\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "252",
                "wilaya_id": "8",
                "dayra": "Sidi Okba\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "253",
                "wilaya_id": "8",
                "dayra": "Tolga\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "254",
                "wilaya_id": "8",
                "dayra": "Zeribet El Oued\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "255",
                "wilaya_id": "9",
                "dayra": "Béchar\t",
                "status": "1",
                "created": null
            },
            {
                "id": "256",
                "wilaya_id": "9",
                "dayra": "Erg Ferradj\t",
                "status": "1",
                "created": null
            },
            {
                "id": "257",
                "wilaya_id": "9",
                "dayra": "Ouled Khoudir\t",
                "status": "1",
                "created": null
            },
            {
                "id": "258",
                "wilaya_id": "9",
                "dayra": "Meridja\t",
                "status": "1",
                "created": null
            },
            {
                "id": "259",
                "wilaya_id": "9",
                "dayra": "Timoudi\t",
                "status": "1",
                "created": null
            },
            {
                "id": "260",
                "wilaya_id": "9",
                "dayra": "Lahmar\t",
                "status": "1",
                "created": null
            },
            {
                "id": "261",
                "wilaya_id": "9",
                "dayra": "Béni Abbès\t",
                "status": "1",
                "created": null
            },
            {
                "id": "262",
                "wilaya_id": "9",
                "dayra": "Beni Ikhlef\t",
                "status": "1",
                "created": null
            },
            {
                "id": "263",
                "wilaya_id": "9",
                "dayra": "Mechraa Houari Boumedienne\t",
                "status": "1",
                "created": null
            },
            {
                "id": "264",
                "wilaya_id": "9",
                "dayra": "Kenadsa\t",
                "status": "1",
                "created": null
            },
            {
                "id": "265",
                "wilaya_id": "9",
                "dayra": "Igli\t",
                "status": "1",
                "created": null
            },
            {
                "id": "266",
                "wilaya_id": "9",
                "dayra": "Tabelbala\t",
                "status": "1",
                "created": null
            },
            {
                "id": "267",
                "wilaya_id": "9",
                "dayra": "Taghit\t",
                "status": "1",
                "created": null
            },
            {
                "id": "268",
                "wilaya_id": "9",
                "dayra": "El Ouata\t",
                "status": "1",
                "created": null
            },
            {
                "id": "269",
                "wilaya_id": "9",
                "dayra": "Boukais\t",
                "status": "1",
                "created": null
            },
            {
                "id": "270",
                "wilaya_id": "9",
                "dayra": "Mougheul\t",
                "status": "1",
                "created": null
            },
            {
                "id": "271",
                "wilaya_id": "9",
                "dayra": "Abadla\t",
                "status": "1",
                "created": null
            },
            {
                "id": "272",
                "wilaya_id": "9",
                "dayra": "Kerzaz\t",
                "status": "1",
                "created": null
            },
            {
                "id": "273",
                "wilaya_id": "9",
                "dayra": "Ksabi\t",
                "status": "1",
                "created": null
            },
            {
                "id": "274",
                "wilaya_id": "9",
                "dayra": "Tamtert\t",
                "status": "1",
                "created": null
            },
            {
                "id": "275",
                "wilaya_id": "9",
                "dayra": "Beni Ounif\t",
                "status": "1",
                "created": null
            },
            {
                "id": "276",
                "wilaya_id": "10",
                "dayra": "Blida\t",
                "status": "1",
                "created": null
            },
            {
                "id": "277",
                "wilaya_id": "10",
                "dayra": "Chebli\t",
                "status": "1",
                "created": null
            },
            {
                "id": "278",
                "wilaya_id": "10",
                "dayra": "Bouinan\t",
                "status": "1",
                "created": null
            },
            {
                "id": "279",
                "wilaya_id": "10",
                "dayra": "Oued Alleug\t",
                "status": "1",
                "created": null
            },
            {
                "id": "280",
                "wilaya_id": "10",
                "dayra": "Ouled Yaïch\t",
                "status": "1",
                "created": null
            },
            {
                "id": "281",
                "wilaya_id": "10",
                "dayra": "Chréa\t",
                "status": "1",
                "created": null
            },
            {
                "id": "282",
                "wilaya_id": "10",
                "dayra": "El Affroun\t",
                "status": "1",
                "created": null
            },
            {
                "id": "283",
                "wilaya_id": "10",
                "dayra": "Chiffa\t",
                "status": "1",
                "created": null
            },
            {
                "id": "284",
                "wilaya_id": "10",
                "dayra": "Hammam Melouane\t",
                "status": "1",
                "created": null
            },
            {
                "id": "285",
                "wilaya_id": "10",
                "dayra": "Benkhelil\t",
                "status": "1",
                "created": null
            },
            {
                "id": "286",
                "wilaya_id": "10",
                "dayra": "Soumaa\t",
                "status": "1",
                "created": null
            },
            {
                "id": "287",
                "wilaya_id": "10",
                "dayra": "Mouzaia\t",
                "status": "1",
                "created": null
            },
            {
                "id": "288",
                "wilaya_id": "10",
                "dayra": "Souhane\t",
                "status": "1",
                "created": null
            },
            {
                "id": "289",
                "wilaya_id": "10",
                "dayra": "Meftah\t",
                "status": "1",
                "created": null
            },
            {
                "id": "290",
                "wilaya_id": "10",
                "dayra": "Ouled Slama\t",
                "status": "1",
                "created": null
            },
            {
                "id": "291",
                "wilaya_id": "10",
                "dayra": "Boufarik\t",
                "status": "1",
                "created": null
            },
            {
                "id": "292",
                "wilaya_id": "10",
                "dayra": "Larbaa\t",
                "status": "1",
                "created": null
            },
            {
                "id": "293",
                "wilaya_id": "10",
                "dayra": "Oued Djer\t",
                "status": "1",
                "created": null
            },
            {
                "id": "294",
                "wilaya_id": "10",
                "dayra": "Beni Tamou\t",
                "status": "1",
                "created": null
            },
            {
                "id": "295",
                "wilaya_id": "10",
                "dayra": "Bouarfa\t",
                "status": "1",
                "created": null
            },
            {
                "id": "296",
                "wilaya_id": "10",
                "dayra": "Beni Mered\t",
                "status": "1",
                "created": null
            },
            {
                "id": "297",
                "wilaya_id": "10",
                "dayra": "Bougara\t",
                "status": "1",
                "created": null
            },
            {
                "id": "298",
                "wilaya_id": "10",
                "dayra": "Guerouaou\t",
                "status": "1",
                "created": null
            },
            {
                "id": "299",
                "wilaya_id": "10",
                "dayra": "Aïn Romana\t",
                "status": "1",
                "created": null
            },
            {
                "id": "300",
                "wilaya_id": "10",
                "dayra": "Djebabra\t",
                "status": "1",
                "created": null
            },
            {
                "id": "301",
                "wilaya_id": "11",
                "dayra": "Aïn Bessem\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "302",
                "wilaya_id": "11",
                "dayra": "Hanif\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "303",
                "wilaya_id": "11",
                "dayra": "Aghbalou\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "304",
                "wilaya_id": "11",
                "dayra": "Aïn El Hadjar\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "305",
                "wilaya_id": "11",
                "dayra": "Ahl El Ksar\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "306",
                "wilaya_id": "11",
                "dayra": "Aïn Laloui\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "307",
                "wilaya_id": "11",
                "dayra": "Ath Mansour\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "308",
                "wilaya_id": "11",
                "dayra": "Aomar\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "309",
                "wilaya_id": "11",
                "dayra": "Aïn El Turc\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "310",
                "wilaya_id": "11",
                "dayra": "Aït Laziz\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "311",
                "wilaya_id": "11",
                "dayra": "Bouderbala\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "312",
                "wilaya_id": "11",
                "dayra": "Bechloul\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "313",
                "wilaya_id": "11",
                "dayra": "Bir Ghbalou\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "314",
                "wilaya_id": "11",
                "dayra": "Boukram\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "315",
                "wilaya_id": "11",
                "dayra": "Bordj Okhriss\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "316",
                "wilaya_id": "11",
                "dayra": "Bouira\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "317",
                "wilaya_id": "11",
                "dayra": "Chorfa\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "318",
                "wilaya_id": "11",
                "dayra": "Dechmia\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "319",
                "wilaya_id": "11",
                "dayra": "Dirrah\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "320",
                "wilaya_id": "11",
                "dayra": "Djebahia\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "321",
                "wilaya_id": "11",
                "dayra": "El Hakimia\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "322",
                "wilaya_id": "11",
                "dayra": "El Hachimia\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "323",
                "wilaya_id": "11",
                "dayra": "El Adjiba\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "324",
                "wilaya_id": "11",
                "dayra": "El Khabouzia\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "325",
                "wilaya_id": "11",
                "dayra": "El Mokrani\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "326",
                "wilaya_id": "11",
                "dayra": "El Asnam\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "327",
                "wilaya_id": "11",
                "dayra": "Guerrouma\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "328",
                "wilaya_id": "11",
                "dayra": "Haizer\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "329",
                "wilaya_id": "11",
                "dayra": "Hadjera Zerga\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "330",
                "wilaya_id": "11",
                "dayra": "Kadiria\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "331",
                "wilaya_id": "11",
                "dayra": "Lakhdaria\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "332",
                "wilaya_id": "11",
                "dayra": "M'Chedallah\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "333",
                "wilaya_id": "11",
                "dayra": "Mezdour\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "334",
                "wilaya_id": "11",
                "dayra": "Maala\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "335",
                "wilaya_id": "11",
                "dayra": "Maamora\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "336",
                "wilaya_id": "11",
                "dayra": "Oued El Berdi\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "337",
                "wilaya_id": "11",
                "dayra": "Ouled Rached\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "338",
                "wilaya_id": "11",
                "dayra": "Raouraoua\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "339",
                "wilaya_id": "11",
                "dayra": "Ridane\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "340",
                "wilaya_id": "11",
                "dayra": "Saharidj\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "341",
                "wilaya_id": "11",
                "dayra": "Sour El Ghouzlane\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "342",
                "wilaya_id": "11",
                "dayra": "Souk El Khemis\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "343",
                "wilaya_id": "11",
                "dayra": "Taguedit\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "344",
                "wilaya_id": "11",
                "dayra": "Taghzout\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "345",
                "wilaya_id": "11",
                "dayra": "Zbarbar\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "346",
                "wilaya_id": "47",
                "dayra": "Tamanrasset ",
                "status": "1",
                "created": null
            },
            {
                "id": "347",
                "wilaya_id": "47",
                "dayra": "Abalessa ",
                "status": "1",
                "created": null
            },
            {
                "id": "348",
                "wilaya_id": "47",
                "dayra": "In Ghar ",
                "status": "1",
                "created": null
            },
            {
                "id": "349",
                "wilaya_id": "47",
                "dayra": "In Guezzam",
                "status": "1",
                "created": null
            },
            {
                "id": "350",
                "wilaya_id": "47",
                "dayra": "Idles",
                "status": "1",
                "created": null
            },
            {
                "id": "351",
                "wilaya_id": "47",
                "dayra": "Tazrouk ",
                "status": "1",
                "created": null
            },
            {
                "id": "352",
                "wilaya_id": "47",
                "dayra": "Tin Zaouatine",
                "status": "1",
                "created": null
            },
            {
                "id": "353",
                "wilaya_id": "47",
                "dayra": " In Salah",
                "status": "1",
                "created": null
            },
            {
                "id": "354",
                "wilaya_id": "47",
                "dayra": " In Amguel",
                "status": "1",
                "created": null
            },
            {
                "id": "355",
                "wilaya_id": "47",
                "dayra": "Foggaret Ezzaouia",
                "status": "1",
                "created": null
            },
            {
                "id": "356",
                "wilaya_id": "12",
                "dayra": "Tébessa\t",
                "status": "1",
                "created": null
            },
            {
                "id": "357",
                "wilaya_id": "12",
                "dayra": "Bir el-Ater\t",
                "status": "1",
                "created": null
            },
            {
                "id": "358",
                "wilaya_id": "12",
                "dayra": "Cheria\t",
                "status": "1",
                "created": null
            },
            {
                "id": "359",
                "wilaya_id": "12",
                "dayra": "Stah Guentis\t",
                "status": "1",
                "created": null
            },
            {
                "id": "360",
                "wilaya_id": "12",
                "dayra": "El Aouinet\t",
                "status": "1",
                "created": null
            },
            {
                "id": "361",
                "wilaya_id": "12",
                "dayra": "El Houidjbet\t",
                "status": "1",
                "created": null
            },
            {
                "id": "362",
                "wilaya_id": "12",
                "dayra": "Safsaf El Ouesra\t",
                "status": "1",
                "created": null
            },
            {
                "id": "363",
                "wilaya_id": "12",
                "dayra": "Hammamet\t",
                "status": "1",
                "created": null
            },
            {
                "id": "364",
                "wilaya_id": "12",
                "dayra": "Negrine\t",
                "status": "1",
                "created": null
            },
            {
                "id": "365",
                "wilaya_id": "12",
                "dayra": "Bir Mokkadem\t",
                "status": "1",
                "created": null
            },
            {
                "id": "366",
                "wilaya_id": "12",
                "dayra": "El Kouif\t",
                "status": "1",
                "created": null
            },
            {
                "id": "367",
                "wilaya_id": "12",
                "dayra": "Morsott\t",
                "status": "1",
                "created": null
            },
            {
                "id": "368",
                "wilaya_id": "12",
                "dayra": "El Ogla\t",
                "status": "1",
                "created": null
            },
            {
                "id": "369",
                "wilaya_id": "12",
                "dayra": "Bir Dheb\t",
                "status": "1",
                "created": null
            },
            {
                "id": "370",
                "wilaya_id": "12",
                "dayra": "Ogla Melha\t",
                "status": "1",
                "created": null
            },
            {
                "id": "371",
                "wilaya_id": "12",
                "dayra": "Guorriguer\t",
                "status": "1",
                "created": null
            },
            {
                "id": "372",
                "wilaya_id": "12",
                "dayra": "Bekkaria\t",
                "status": "1",
                "created": null
            },
            {
                "id": "373",
                "wilaya_id": "12",
                "dayra": "Boukhadra\t",
                "status": "1",
                "created": null
            },
            {
                "id": "374",
                "wilaya_id": "12",
                "dayra": "Ouenza\t",
                "status": "1",
                "created": null
            },
            {
                "id": "375",
                "wilaya_id": "12",
                "dayra": "El Ma Labiodh\t",
                "status": "1",
                "created": null
            },
            {
                "id": "376",
                "wilaya_id": "12",
                "dayra": "Oum Ali\t",
                "status": "1",
                "created": null
            },
            {
                "id": "377",
                "wilaya_id": "12",
                "dayra": "Tlidjene\t",
                "status": "1",
                "created": null
            },
            {
                "id": "378",
                "wilaya_id": "12",
                "dayra": "Aïn Zerga\t",
                "status": "1",
                "created": null
            },
            {
                "id": "379",
                "wilaya_id": "12",
                "dayra": "El Meridj\t",
                "status": "1",
                "created": null
            },
            {
                "id": "380",
                "wilaya_id": "12",
                "dayra": "Boulhaf Dir\t",
                "status": "1",
                "created": null
            },
            {
                "id": "381",
                "wilaya_id": "12",
                "dayra": "Bedjene\t",
                "status": "1",
                "created": null
            },
            {
                "id": "382",
                "wilaya_id": "12",
                "dayra": "El Mezeraa\t",
                "status": "1",
                "created": null
            },
            {
                "id": "383",
                "wilaya_id": "12",
                "dayra": "Ferkane\t",
                "status": "1",
                "created": null
            },
            {
                "id": "384",
                "wilaya_id": "13",
                "dayra": "Tlemcen\t",
                "status": "1",
                "created": null
            },
            {
                "id": "385",
                "wilaya_id": "13",
                "dayra": "Beni Mester\t",
                "status": "1",
                "created": null
            },
            {
                "id": "386",
                "wilaya_id": "13",
                "dayra": "Aïn Tallout\t",
                "status": "1",
                "created": null
            },
            {
                "id": "387",
                "wilaya_id": "13",
                "dayra": "Remchi\t",
                "status": "1",
                "created": null
            },
            {
                "id": "388",
                "wilaya_id": "13",
                "dayra": "El Fehoul\t",
                "status": "1",
                "created": null
            },
            {
                "id": "389",
                "wilaya_id": "13",
                "dayra": "Sabra\t",
                "status": "1",
                "created": null
            },
            {
                "id": "390",
                "wilaya_id": "13",
                "dayra": "Ghazaouet\t",
                "status": "1",
                "created": null
            },
            {
                "id": "391",
                "wilaya_id": "13",
                "dayra": "Souani\t",
                "status": "1",
                "created": null
            },
            {
                "id": "392",
                "wilaya_id": "13",
                "dayra": "Djebala\t",
                "status": "1",
                "created": null
            },
            {
                "id": "393",
                "wilaya_id": "13",
                "dayra": "El Gor\t",
                "status": "1",
                "created": null
            },
            {
                "id": "394",
                "wilaya_id": "13",
                "dayra": "Oued Lakhdar\t",
                "status": "1",
                "created": null
            },
            {
                "id": "395",
                "wilaya_id": "13",
                "dayra": "Aïn Fezza\t",
                "status": "1",
                "created": null
            },
            {
                "id": "396",
                "wilaya_id": "13",
                "dayra": "Ouled Mimoun\t",
                "status": "1",
                "created": null
            },
            {
                "id": "397",
                "wilaya_id": "13",
                "dayra": "Amieur\t",
                "status": "1",
                "created": null
            },
            {
                "id": "398",
                "wilaya_id": "13",
                "dayra": "Aïn Youcef\t",
                "status": "1",
                "created": null
            },
            {
                "id": "399",
                "wilaya_id": "13",
                "dayra": "Zenata\t",
                "status": "1",
                "created": null
            },
            {
                "id": "400",
                "wilaya_id": "13",
                "dayra": "Beni Snous\t",
                "status": "1",
                "created": null
            },
            {
                "id": "401",
                "wilaya_id": "13",
                "dayra": "Bab El Assa\t",
                "status": "1",
                "created": null
            },
            {
                "id": "402",
                "wilaya_id": "13",
                "dayra": "Dar Yaghmouracene\t",
                "status": "1",
                "created": null
            },
            {
                "id": "403",
                "wilaya_id": "13",
                "dayra": "Fellaoucene\t",
                "status": "1",
                "created": null
            },
            {
                "id": "404",
                "wilaya_id": "13",
                "dayra": "Azails\t",
                "status": "1",
                "created": null
            },
            {
                "id": "405",
                "wilaya_id": "13",
                "dayra": "Sebaa Chioukh\t",
                "status": "1",
                "created": null
            },
            {
                "id": "406",
                "wilaya_id": "13",
                "dayra": "Terny Beni Hdiel\t",
                "status": "1",
                "created": null
            },
            {
                "id": "407",
                "wilaya_id": "13",
                "dayra": "Bensekrane\t",
                "status": "1",
                "created": null
            },
            {
                "id": "408",
                "wilaya_id": "13",
                "dayra": "Aïn Nehala\t",
                "status": "1",
                "created": null
            },
            {
                "id": "409",
                "wilaya_id": "13",
                "dayra": "Hennaya\t",
                "status": "1",
                "created": null
            },
            {
                "id": "410",
                "wilaya_id": "13",
                "dayra": "Maghnia\t",
                "status": "1",
                "created": null
            },
            {
                "id": "411",
                "wilaya_id": "13",
                "dayra": "Hammam Boughrara\t",
                "status": "1",
                "created": null
            },
            {
                "id": "412",
                "wilaya_id": "13",
                "dayra": "Souahlia\t",
                "status": "1",
                "created": null
            },
            {
                "id": "413",
                "wilaya_id": "13",
                "dayra": "MSirda Fouaga\t",
                "status": "1",
                "created": null
            },
            {
                "id": "414",
                "wilaya_id": "13",
                "dayra": "Aïn Fetah\t",
                "status": "1",
                "created": null
            },
            {
                "id": "415",
                "wilaya_id": "13",
                "dayra": "El Aricha\t",
                "status": "1",
                "created": null
            },
            {
                "id": "416",
                "wilaya_id": "13",
                "dayra": "Souk Tlata\t",
                "status": "1",
                "created": null
            },
            {
                "id": "417",
                "wilaya_id": "13",
                "dayra": "Sidi Abdelli\t",
                "status": "1",
                "created": null
            },
            {
                "id": "418",
                "wilaya_id": "13",
                "dayra": "Sebdou\t",
                "status": "1",
                "created": null
            },
            {
                "id": "419",
                "wilaya_id": "13",
                "dayra": "Beni Ouarsous\t",
                "status": "1",
                "created": null
            },
            {
                "id": "420",
                "wilaya_id": "13",
                "dayra": "Sidi Medjahed\t",
                "status": "1",
                "created": null
            },
            {
                "id": "421",
                "wilaya_id": "13",
                "dayra": "Beni Boussaid\t",
                "status": "1",
                "created": null
            },
            {
                "id": "422",
                "wilaya_id": "13",
                "dayra": "Marsa Ben M'Hidi\t",
                "status": "1",
                "created": null
            },
            {
                "id": "423",
                "wilaya_id": "13",
                "dayra": "Nedroma\t",
                "status": "1",
                "created": null
            },
            {
                "id": "424",
                "wilaya_id": "13",
                "dayra": "Sidi Djillali\t",
                "status": "1",
                "created": null
            },
            {
                "id": "425",
                "wilaya_id": "13",
                "dayra": "Beni Bahdel\t",
                "status": "1",
                "created": null
            },
            {
                "id": "426",
                "wilaya_id": "13",
                "dayra": "El Bouihi\t",
                "status": "1",
                "created": null
            },
            {
                "id": "427",
                "wilaya_id": "13",
                "dayra": "Honaïne\t",
                "status": "1",
                "created": null
            },
            {
                "id": "428",
                "wilaya_id": "13",
                "dayra": "Tienet\t",
                "status": "1",
                "created": null
            },
            {
                "id": "429",
                "wilaya_id": "13",
                "dayra": "Ouled Riyah\t",
                "status": "1",
                "created": null
            },
            {
                "id": "430",
                "wilaya_id": "13",
                "dayra": "Bouhlou\t",
                "status": "1",
                "created": null
            },
            {
                "id": "431",
                "wilaya_id": "13",
                "dayra": "Beni Khellad\t",
                "status": "1",
                "created": null
            },
            {
                "id": "432",
                "wilaya_id": "13",
                "dayra": "Aïn Ghoraba\t",
                "status": "1",
                "created": null
            },
            {
                "id": "433",
                "wilaya_id": "13",
                "dayra": "Chetouane\t",
                "status": "1",
                "created": null
            },
            {
                "id": "434",
                "wilaya_id": "13",
                "dayra": "Mansourah\t",
                "status": "1",
                "created": null
            },
            {
                "id": "435",
                "wilaya_id": "13",
                "dayra": "Beni Semiel\t",
                "status": "1",
                "created": null
            },
            {
                "id": "436",
                "wilaya_id": "13",
                "dayra": "Aïn Kebira\t",
                "status": "1",
                "created": null
            },
            {
                "id": "437",
                "wilaya_id": "14",
                "dayra": "Aïn Bouchekif\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "438",
                "wilaya_id": "14",
                "dayra": "Aïn Deheb\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "439",
                "wilaya_id": "14",
                "dayra": "Aïn El Hadid\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "440",
                "wilaya_id": "14",
                "dayra": "Aïn Kermes\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "441",
                "wilaya_id": "14",
                "dayra": "Aïn Dzarit\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "442",
                "wilaya_id": "14",
                "dayra": "Bougara\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "443",
                "wilaya_id": "14",
                "dayra": "Chehaima\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "444",
                "wilaya_id": "14",
                "dayra": "Dahmouni\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "445",
                "wilaya_id": "14",
                "dayra": "Djebilet Rosfa\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "446",
                "wilaya_id": "14",
                "dayra": "Djillali Ben Amar\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "447",
                "wilaya_id": "14",
                "dayra": "Faidja\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "448",
                "wilaya_id": "14",
                "dayra": "Frenda\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "449",
                "wilaya_id": "14",
                "dayra": "Guertoufa\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "450",
                "wilaya_id": "14",
                "dayra": "Hamadia\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "451",
                "wilaya_id": "14",
                "dayra": "Ksar Chellala\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "452",
                "wilaya_id": "14",
                "dayra": "Madna\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "453",
                "wilaya_id": "14",
                "dayra": "Mahdia\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "454",
                "wilaya_id": "14",
                "dayra": "Mechraa Safa\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "455",
                "wilaya_id": "14",
                "dayra": "Medrissa\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "456",
                "wilaya_id": "14",
                "dayra": "Medroussa\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "457",
                "wilaya_id": "14",
                "dayra": "Meghila\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "458",
                "wilaya_id": "14",
                "dayra": "Mellakou\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "459",
                "wilaya_id": "14",
                "dayra": "Nadorah\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "460",
                "wilaya_id": "14",
                "dayra": "Naima\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "461",
                "wilaya_id": "14",
                "dayra": "Oued Lilli\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "462",
                "wilaya_id": "14",
                "dayra": "Rahouia\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "463",
                "wilaya_id": "14",
                "dayra": "Rechaïga\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "464",
                "wilaya_id": "14",
                "dayra": "Sebaïne\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "465",
                "wilaya_id": "14",
                "dayra": "Sebt\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "466",
                "wilaya_id": "14",
                "dayra": "Serghine\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "467",
                "wilaya_id": "14",
                "dayra": "Si Abdelghani\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "468",
                "wilaya_id": "14",
                "dayra": "Sidi Abderahmane\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "469",
                "wilaya_id": "14",
                "dayra": "Sidi Ali Mellal\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "470",
                "wilaya_id": "14",
                "dayra": "Sidi Bakhti\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "471",
                "wilaya_id": "14",
                "dayra": "Sidi Hosni\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "472",
                "wilaya_id": "14",
                "dayra": "Sougueur\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "473",
                "wilaya_id": "14",
                "dayra": "Tagdemt\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "474",
                "wilaya_id": "14",
                "dayra": "Takhemaret\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "475",
                "wilaya_id": "14",
                "dayra": "Tiaret\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "476",
                "wilaya_id": "14",
                "dayra": "Tidda\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "477",
                "wilaya_id": "14",
                "dayra": "Tousnina\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "478",
                "wilaya_id": "14",
                "dayra": "Zmalet El Emir Abdelkader\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "479",
                "wilaya_id": "15",
                "dayra": "Tizi Ouzou\t",
                "status": "1",
                "created": null
            },
            {
                "id": "480",
                "wilaya_id": "15",
                "dayra": "Ain El Hammam\t",
                "status": "1",
                "created": null
            },
            {
                "id": "481",
                "wilaya_id": "15",
                "dayra": "Akbil\t",
                "status": "1",
                "created": null
            },
            {
                "id": "482",
                "wilaya_id": "15",
                "dayra": "Freha\t",
                "status": "1",
                "created": null
            },
            {
                "id": "483",
                "wilaya_id": "15",
                "dayra": "Souamaâ\t",
                "status": "1",
                "created": null
            },
            {
                "id": "484",
                "wilaya_id": "15",
                "dayra": "Mechtras\t",
                "status": "1",
                "created": null
            },
            {
                "id": "485",
                "wilaya_id": "15",
                "dayra": "Irdjen\t",
                "status": "1",
                "created": null
            },
            {
                "id": "486",
                "wilaya_id": "15",
                "dayra": "Timizart\t",
                "status": "1",
                "created": null
            },
            {
                "id": "487",
                "wilaya_id": "15",
                "dayra": "Makouda\t",
                "status": "1",
                "created": null
            },
            {
                "id": "488",
                "wilaya_id": "15",
                "dayra": "Draâ El Mizan\t",
                "status": "1",
                "created": null
            },
            {
                "id": "489",
                "wilaya_id": "15",
                "dayra": "Tizi Gheniff\t",
                "status": "1",
                "created": null
            },
            {
                "id": "490",
                "wilaya_id": "15",
                "dayra": "Bounouh\t",
                "status": "1",
                "created": null
            },
            {
                "id": "491",
                "wilaya_id": "15",
                "dayra": "Aït Chafâa\t",
                "status": "1",
                "created": null
            },
            {
                "id": "492",
                "wilaya_id": "15",
                "dayra": "Frikat\t",
                "status": "1",
                "created": null
            },
            {
                "id": "493",
                "wilaya_id": "15",
                "dayra": "Beni Aïssi\t",
                "status": "1",
                "created": null
            },
            {
                "id": "494",
                "wilaya_id": "15",
                "dayra": "Aït Zmenzer\t",
                "status": "1",
                "created": null
            },
            {
                "id": "495",
                "wilaya_id": "15",
                "dayra": "Iferhounène\t",
                "status": "1",
                "created": null
            },
            {
                "id": "496",
                "wilaya_id": "15",
                "dayra": "Azazga\t",
                "status": "1",
                "created": null
            },
            {
                "id": "497",
                "wilaya_id": "15",
                "dayra": "Illoula Oumalou\t",
                "status": "1",
                "created": null
            },
            {
                "id": "498",
                "wilaya_id": "15",
                "dayra": "Yakouren\t",
                "status": "1",
                "created": null
            },
            {
                "id": "499",
                "wilaya_id": "15",
                "dayra": "Larbaâ Nath Irathen\t",
                "status": "1",
                "created": null
            },
            {
                "id": "500",
                "wilaya_id": "15",
                "dayra": "Tizi Rached\t",
                "status": "1",
                "created": null
            },
            {
                "id": "501",
                "wilaya_id": "15",
                "dayra": "Zekri\t",
                "status": "1",
                "created": null
            },
            {
                "id": "502",
                "wilaya_id": "15",
                "dayra": "Ouaguenoun\t",
                "status": "1",
                "created": null
            },
            {
                "id": "503",
                "wilaya_id": "15",
                "dayra": "Aïn Zaouia\t",
                "status": "1",
                "created": null
            },
            {
                "id": "504",
                "wilaya_id": "15",
                "dayra": "Imkiren\t",
                "status": "1",
                "created": null
            },
            {
                "id": "505",
                "wilaya_id": "15",
                "dayra": "Aït Yahia\t",
                "status": "1",
                "created": null
            },
            {
                "id": "506",
                "wilaya_id": "15",
                "dayra": "Aït Mahmoud\t",
                "status": "1",
                "created": null
            },
            {
                "id": "507",
                "wilaya_id": "15",
                "dayra": "Mâatkas\t",
                "status": "1",
                "created": null
            },
            {
                "id": "508",
                "wilaya_id": "15",
                "dayra": "Aït Boumahdi\t",
                "status": "1",
                "created": null
            },
            {
                "id": "509",
                "wilaya_id": "15",
                "dayra": "Abi Youcef\t",
                "status": "1",
                "created": null
            },
            {
                "id": "510",
                "wilaya_id": "15",
                "dayra": "Beni Douala\t",
                "status": "1",
                "created": null
            },
            {
                "id": "511",
                "wilaya_id": "15",
                "dayra": "Illilten\t",
                "status": "1",
                "created": null
            },
            {
                "id": "512",
                "wilaya_id": "15",
                "dayra": "Bouzeguène\t",
                "status": "1",
                "created": null
            },
            {
                "id": "513",
                "wilaya_id": "15",
                "dayra": "Aït Aggouacha\t",
                "status": "1",
                "created": null
            },
            {
                "id": "514",
                "wilaya_id": "15",
                "dayra": "Ouadhia\t",
                "status": "1",
                "created": null
            },
            {
                "id": "515",
                "wilaya_id": "15",
                "dayra": "Azeffoun\t",
                "status": "1",
                "created": null
            },
            {
                "id": "516",
                "wilaya_id": "15",
                "dayra": "Tigzirt\t",
                "status": "1",
                "created": null
            },
            {
                "id": "517",
                "wilaya_id": "15",
                "dayra": "Aït Aïssa Mimoun\t",
                "status": "1",
                "created": null
            },
            {
                "id": "518",
                "wilaya_id": "15",
                "dayra": "Boghni\t",
                "status": "1",
                "created": null
            },
            {
                "id": "519",
                "wilaya_id": "15",
                "dayra": "Ifigha\t",
                "status": "1",
                "created": null
            },
            {
                "id": "520",
                "wilaya_id": "15",
                "dayra": "Aït Oumalou\t",
                "status": "1",
                "created": null
            },
            {
                "id": "521",
                "wilaya_id": "15",
                "dayra": "Tirmitine\t",
                "status": "1",
                "created": null
            },
            {
                "id": "522",
                "wilaya_id": "15",
                "dayra": "Akerrou\t",
                "status": "1",
                "created": null
            },
            {
                "id": "523",
                "wilaya_id": "15",
                "dayra": "Yatafen\t",
                "status": "1",
                "created": null
            },
            {
                "id": "524",
                "wilaya_id": "15",
                "dayra": "Ath Zikki\t",
                "status": "1",
                "created": null
            },
            {
                "id": "525",
                "wilaya_id": "15",
                "dayra": "Draâ Ben Khedda\t",
                "status": "1",
                "created": null
            },
            {
                "id": "526",
                "wilaya_id": "15",
                "dayra": "Aït Ouacif\t",
                "status": "1",
                "created": null
            },
            {
                "id": "527",
                "wilaya_id": "15",
                "dayra": "Idjeur\t",
                "status": "1",
                "created": null
            },
            {
                "id": "528",
                "wilaya_id": "15",
                "dayra": "Mekla\t",
                "status": "1",
                "created": null
            },
            {
                "id": "529",
                "wilaya_id": "15",
                "dayra": "Tizi N'Tleta\t",
                "status": "1",
                "created": null
            },
            {
                "id": "530",
                "wilaya_id": "15",
                "dayra": "Aït Yenni\t",
                "status": "1",
                "created": null
            },
            {
                "id": "531",
                "wilaya_id": "15",
                "dayra": "Aghribs\t",
                "status": "1",
                "created": null
            },
            {
                "id": "532",
                "wilaya_id": "15",
                "dayra": "Iflissen\t",
                "status": "1",
                "created": null
            },
            {
                "id": "533",
                "wilaya_id": "15",
                "dayra": "Boudjima\t",
                "status": "1",
                "created": null
            },
            {
                "id": "534",
                "wilaya_id": "15",
                "dayra": "Aït Yahia Moussa\t",
                "status": "1",
                "created": null
            },
            {
                "id": "535",
                "wilaya_id": "15",
                "dayra": "Souk El Thenine\t",
                "status": "1",
                "created": null
            },
            {
                "id": "536",
                "wilaya_id": "15",
                "dayra": "Aït Khellili\t",
                "status": "1",
                "created": null
            },
            {
                "id": "537",
                "wilaya_id": "15",
                "dayra": "Sidi Namane\t",
                "status": "1",
                "created": null
            },
            {
                "id": "538",
                "wilaya_id": "15",
                "dayra": "Iboudraren\t",
                "status": "1",
                "created": null
            },
            {
                "id": "539",
                "wilaya_id": "15",
                "dayra": "Agouni Gueghrane\t",
                "status": "1",
                "created": null
            },
            {
                "id": "540",
                "wilaya_id": "15",
                "dayra": "Mizrana\t",
                "status": "1",
                "created": null
            },
            {
                "id": "541",
                "wilaya_id": "15",
                "dayra": "Imsouhel\t",
                "status": "1",
                "created": null
            },
            {
                "id": "542",
                "wilaya_id": "16",
                "dayra": "Alger-Centre",
                "status": "1",
                "created": null
            },
            {
                "id": "543",
                "wilaya_id": "16",
                "dayra": "Sidi M'Hamed\t",
                "status": "1",
                "created": null
            },
            {
                "id": "544",
                "wilaya_id": "16",
                "dayra": "El Madania\t",
                "status": "1",
                "created": null
            },
            {
                "id": "545",
                "wilaya_id": "16",
                "dayra": "Belouizdad\t",
                "status": "1",
                "created": null
            },
            {
                "id": "546",
                "wilaya_id": "16",
                "dayra": "Bab El Oued\t",
                "status": "1",
                "created": null
            },
            {
                "id": "547",
                "wilaya_id": "16",
                "dayra": "Bologhine\t",
                "status": "1",
                "created": null
            },
            {
                "id": "548",
                "wilaya_id": "16",
                "dayra": "Casbah\t",
                "status": "1",
                "created": null
            },
            {
                "id": "549",
                "wilaya_id": "16",
                "dayra": "Oued Koriche\t",
                "status": "1",
                "created": null
            },
            {
                "id": "550",
                "wilaya_id": "16",
                "dayra": "Bir Mourad Raïs\t",
                "status": "1",
                "created": null
            },
            {
                "id": "551",
                "wilaya_id": "16",
                "dayra": "El Biar\t",
                "status": "1",
                "created": null
            },
            {
                "id": "552",
                "wilaya_id": "16",
                "dayra": "Bouzareah\t",
                "status": "1",
                "created": null
            },
            {
                "id": "553",
                "wilaya_id": "16",
                "dayra": "Birkhadem\t",
                "status": "1",
                "created": null
            },
            {
                "id": "554",
                "wilaya_id": "16",
                "dayra": "El Harrach\t",
                "status": "1",
                "created": null
            },
            {
                "id": "555",
                "wilaya_id": "16",
                "dayra": "Baraki\t",
                "status": "1",
                "created": null
            },
            {
                "id": "556",
                "wilaya_id": "16",
                "dayra": "Oued Smar\t",
                "status": "1",
                "created": null
            },
            {
                "id": "557",
                "wilaya_id": "16",
                "dayra": "Bachdjerrah\t",
                "status": "1",
                "created": null
            },
            {
                "id": "558",
                "wilaya_id": "16",
                "dayra": "Hussein Dey\t",
                "status": "1",
                "created": null
            },
            {
                "id": "559",
                "wilaya_id": "16",
                "dayra": "Kouba\t",
                "status": "1",
                "created": null
            },
            {
                "id": "560",
                "wilaya_id": "16",
                "dayra": "Bourouba\t",
                "status": "1",
                "created": null
            },
            {
                "id": "561",
                "wilaya_id": "16",
                "dayra": "Dar El Beïda\t",
                "status": "1",
                "created": null
            },
            {
                "id": "562",
                "wilaya_id": "16",
                "dayra": "Bab Ezzouar\t",
                "status": "1",
                "created": null
            },
            {
                "id": "563",
                "wilaya_id": "16",
                "dayra": "Ben Aknoun\t",
                "status": "1",
                "created": null
            },
            {
                "id": "564",
                "wilaya_id": "16",
                "dayra": "Dely Ibrahim\t",
                "status": "1",
                "created": null
            },
            {
                "id": "565",
                "wilaya_id": "16",
                "dayra": "El Hammamet\t",
                "status": "1",
                "created": null
            },
            {
                "id": "566",
                "wilaya_id": "16",
                "dayra": "Raïs Hamidou\t",
                "status": "1",
                "created": null
            },
            {
                "id": "567",
                "wilaya_id": "16",
                "dayra": "Djasr Kasentina",
                "status": "1",
                "created": null
            },
            {
                "id": "568",
                "wilaya_id": "16",
                "dayra": "El Mouradia\t",
                "status": "1",
                "created": null
            },
            {
                "id": "569",
                "wilaya_id": "16",
                "dayra": "Hydra\t",
                "status": "1",
                "created": null
            },
            {
                "id": "570",
                "wilaya_id": "16",
                "dayra": "Mohammadia\t",
                "status": "1",
                "created": null
            },
            {
                "id": "571",
                "wilaya_id": "16",
                "dayra": "Bordj El Kiffan\t",
                "status": "1",
                "created": null
            },
            {
                "id": "572",
                "wilaya_id": "16",
                "dayra": "El Magharia\t",
                "status": "1",
                "created": null
            },
            {
                "id": "573",
                "wilaya_id": "16",
                "dayra": "Beni Messous\t",
                "status": "1",
                "created": null
            },
            {
                "id": "574",
                "wilaya_id": "16",
                "dayra": "Les Eucalyptus\t",
                "status": "1",
                "created": null
            },
            {
                "id": "575",
                "wilaya_id": "16",
                "dayra": "Birtouta\t",
                "status": "1",
                "created": null
            },
            {
                "id": "576",
                "wilaya_id": "16",
                "dayra": "Tessala El Merdja\t",
                "status": "1",
                "created": null
            },
            {
                "id": "577",
                "wilaya_id": "16",
                "dayra": "Ouled Chebel\t",
                "status": "1",
                "created": null
            },
            {
                "id": "578",
                "wilaya_id": "16",
                "dayra": "Sidi Moussa\t",
                "status": "1",
                "created": null
            },
            {
                "id": "579",
                "wilaya_id": "16",
                "dayra": "Aïn Taya\t",
                "status": "1",
                "created": null
            },
            {
                "id": "580",
                "wilaya_id": "16",
                "dayra": "Bordj El Bahri\t",
                "status": "1",
                "created": null
            },
            {
                "id": "581",
                "wilaya_id": "16",
                "dayra": "El Marsa\t",
                "status": "1",
                "created": null
            },
            {
                "id": "582",
                "wilaya_id": "16",
                "dayra": "H'raoua\t",
                "status": "1",
                "created": null
            },
            {
                "id": "583",
                "wilaya_id": "16",
                "dayra": "Rouïba\t",
                "status": "1",
                "created": null
            },
            {
                "id": "584",
                "wilaya_id": "16",
                "dayra": "Reghaïa\t",
                "status": "1",
                "created": null
            },
            {
                "id": "585",
                "wilaya_id": "16",
                "dayra": "Aïn Benian\t",
                "status": "1",
                "created": null
            },
            {
                "id": "586",
                "wilaya_id": "16",
                "dayra": "Staoueli\t",
                "status": "1",
                "created": null
            },
            {
                "id": "587",
                "wilaya_id": "16",
                "dayra": "Zeralda\t",
                "status": "1",
                "created": null
            },
            {
                "id": "588",
                "wilaya_id": "16",
                "dayra": "Mahelma\t",
                "status": "1",
                "created": null
            },
            {
                "id": "589",
                "wilaya_id": "16",
                "dayra": "Rahmania\t",
                "status": "1",
                "created": null
            },
            {
                "id": "590",
                "wilaya_id": "16",
                "dayra": "Souidania\t",
                "status": "1",
                "created": null
            },
            {
                "id": "591",
                "wilaya_id": "16",
                "dayra": "Cheraga\t",
                "status": "1",
                "created": null
            },
            {
                "id": "592",
                "wilaya_id": "16",
                "dayra": "Ouled Fayet\t",
                "status": "1",
                "created": null
            },
            {
                "id": "593",
                "wilaya_id": "16",
                "dayra": "El Achour\t",
                "status": "1",
                "created": null
            },
            {
                "id": "594",
                "wilaya_id": "16",
                "dayra": "Draria\t",
                "status": "1",
                "created": null
            },
            {
                "id": "595",
                "wilaya_id": "16",
                "dayra": "Douera\t",
                "status": "1",
                "created": null
            },
            {
                "id": "596",
                "wilaya_id": "16",
                "dayra": "Baba Hassen\t",
                "status": "1",
                "created": null
            },
            {
                "id": "597",
                "wilaya_id": "16",
                "dayra": "Khraicia\t",
                "status": "1",
                "created": null
            },
            {
                "id": "598",
                "wilaya_id": "16",
                "dayra": "Saoula\t",
                "status": "1",
                "created": null
            },
            {
                "id": "599",
                "wilaya_id": "17",
                "dayra": "Aïn Chouhada\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "600",
                "wilaya_id": "17",
                "dayra": "Aïn El Ibel\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "601",
                "wilaya_id": "17",
                "dayra": "Aïn Feka\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "602",
                "wilaya_id": "17",
                "dayra": "Aïn Maabed\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "603",
                "wilaya_id": "17",
                "dayra": "Aïn Oussara\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "604",
                "wilaya_id": "17",
                "dayra": "Amourah\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "605",
                "wilaya_id": "17",
                "dayra": "Benhar\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "606",
                "wilaya_id": "17",
                "dayra": "Beni Yagoub\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "607",
                "wilaya_id": "17",
                "dayra": "Birine\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "608",
                "wilaya_id": "17",
                "dayra": "Bouira Lahdab\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "609",
                "wilaya_id": "17",
                "dayra": "Charef\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "610",
                "wilaya_id": "17",
                "dayra": "Dar Chioukh\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "611",
                "wilaya_id": "17",
                "dayra": "Deldoul\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "612",
                "wilaya_id": "17",
                "dayra": "Djelfa\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "613",
                "wilaya_id": "17",
                "dayra": "Douis\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "614",
                "wilaya_id": "17",
                "dayra": "El Guedid\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "615",
                "wilaya_id": "17",
                "dayra": "El Idrissia\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "616",
                "wilaya_id": "17",
                "dayra": "El Khemis\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "617",
                "wilaya_id": "17",
                "dayra": "Faidh El Botma\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "618",
                "wilaya_id": "17",
                "dayra": "Guernini\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "619",
                "wilaya_id": "17",
                "dayra": "Guettara\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "620",
                "wilaya_id": "17",
                "dayra": "Had-Sahary\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "621",
                "wilaya_id": "17",
                "dayra": "Hassi Bahbah\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "622",
                "wilaya_id": "17",
                "dayra": "Hassi El Euch\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "623",
                "wilaya_id": "17",
                "dayra": "Hassi Fedoul\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "624",
                "wilaya_id": "17",
                "dayra": "Messaad",
                "status": "1",
                "created": null
            },
            {
                "id": "625",
                "wilaya_id": "17",
                "dayra": "M'Liliha\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "626",
                "wilaya_id": "17",
                "dayra": "Moudjebara\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "627",
                "wilaya_id": "17",
                "dayra": "Oum Laadham\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "628",
                "wilaya_id": "17",
                "dayra": "Sed Rahal\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "629",
                "wilaya_id": "17",
                "dayra": "Selmana\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "630",
                "wilaya_id": "17",
                "dayra": "Sidi Baizid\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "631",
                "wilaya_id": "17",
                "dayra": "Sidi Ladjel\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "632",
                "wilaya_id": "17",
                "dayra": "Tadmit\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "633",
                "wilaya_id": "17",
                "dayra": "Zaafrane\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "634",
                "wilaya_id": "17",
                "dayra": "Zaccar\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "635",
                "wilaya_id": "18",
                "dayra": "Jijel\t",
                "status": "1",
                "created": null
            },
            {
                "id": "636",
                "wilaya_id": "18",
                "dayra": "Eraguene\t",
                "status": "1",
                "created": null
            },
            {
                "id": "637",
                "wilaya_id": "18",
                "dayra": "El Aouana\t",
                "status": "1",
                "created": null
            },
            {
                "id": "638",
                "wilaya_id": "18",
                "dayra": "Ziama Mansouriah\t",
                "status": "1",
                "created": null
            },
            {
                "id": "639",
                "wilaya_id": "18",
                "dayra": "Taher\t",
                "status": "1",
                "created": null
            },
            {
                "id": "640",
                "wilaya_id": "18",
                "dayra": "Emir Abdelkader\t",
                "status": "1",
                "created": null
            },
            {
                "id": "641",
                "wilaya_id": "18",
                "dayra": "Chekfa\t",
                "status": "1",
                "created": null
            },
            {
                "id": "642",
                "wilaya_id": "18",
                "dayra": "Chahna\t",
                "status": "1",
                "created": null
            },
            {
                "id": "643",
                "wilaya_id": "18",
                "dayra": "El Milia\t",
                "status": "1",
                "created": null
            },
            {
                "id": "644",
                "wilaya_id": "18",
                "dayra": "Sidi Maarouf\t",
                "status": "1",
                "created": null
            },
            {
                "id": "645",
                "wilaya_id": "18",
                "dayra": "Settara\t",
                "status": "1",
                "created": null
            },
            {
                "id": "646",
                "wilaya_id": "18",
                "dayra": "El Ancer\t",
                "status": "1",
                "created": null
            },
            {
                "id": "647",
                "wilaya_id": "18",
                "dayra": "Sidi Abdelaziz\t",
                "status": "1",
                "created": null
            },
            {
                "id": "648",
                "wilaya_id": "18",
                "dayra": "Kaous\t",
                "status": "1",
                "created": null
            },
            {
                "id": "649",
                "wilaya_id": "18",
                "dayra": "Ghebala\t",
                "status": "1",
                "created": null
            },
            {
                "id": "650",
                "wilaya_id": "18",
                "dayra": "Bouraoui Belhadef\t",
                "status": "1",
                "created": null
            },
            {
                "id": "651",
                "wilaya_id": "18",
                "dayra": "Djimla\t",
                "status": "1",
                "created": null
            },
            {
                "id": "652",
                "wilaya_id": "18",
                "dayra": "Selma Benziada\t",
                "status": "1",
                "created": null
            },
            {
                "id": "653",
                "wilaya_id": "18",
                "dayra": "Boucif Ouled Askeur\t",
                "status": "1",
                "created": null
            },
            {
                "id": "654",
                "wilaya_id": "18",
                "dayra": "El Kennar Nouchfi\t",
                "status": "1",
                "created": null
            },
            {
                "id": "655",
                "wilaya_id": "18",
                "dayra": "Ouled Yahia Khedrouche\t",
                "status": "1",
                "created": null
            },
            {
                "id": "656",
                "wilaya_id": "18",
                "dayra": "Boudriaa Ben Yadjis\t",
                "status": "1",
                "created": null
            },
            {
                "id": "657",
                "wilaya_id": "18",
                "dayra": "Kheïri Oued Adjoul\t",
                "status": "1",
                "created": null
            },
            {
                "id": "658",
                "wilaya_id": "18",
                "dayra": "Texenna\t",
                "status": "1",
                "created": null
            },
            {
                "id": "659",
                "wilaya_id": "18",
                "dayra": "Djemaa Beni Habibi\t",
                "status": "1",
                "created": null
            },
            {
                "id": "660",
                "wilaya_id": "18",
                "dayra": "Bordj Tahar\t",
                "status": "1",
                "created": null
            },
            {
                "id": "661",
                "wilaya_id": "18",
                "dayra": "Ouled Rabah\t",
                "status": "1",
                "created": null
            },
            {
                "id": "662",
                "wilaya_id": "18",
                "dayra": "Ouadjana\t",
                "status": "1",
                "created": null
            },
            {
                "id": "663",
                "wilaya_id": "19",
                "dayra": "Aïn Abessa\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "664",
                "wilaya_id": "19",
                "dayra": "Aïn Arnat\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "665",
                "wilaya_id": "19",
                "dayra": "Aïn Azel\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "666",
                "wilaya_id": "19",
                "dayra": "Aïn El Kebira\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "667",
                "wilaya_id": "19",
                "dayra": "Aïn Lahdjar\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "668",
                "wilaya_id": "19",
                "dayra": "Aïn Legradj\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "669",
                "wilaya_id": "19",
                "dayra": "Aïn Oulmene\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "670",
                "wilaya_id": "19",
                "dayra": "Aïn Roua\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "671",
                "wilaya_id": "19",
                "dayra": "Aïn Sebt\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "672",
                "wilaya_id": "19",
                "dayra": "Aït Naoual Mezada\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "673",
                "wilaya_id": "19",
                "dayra": "Aït Tizi\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "674",
                "wilaya_id": "19",
                "dayra": "Beni Ouartilene\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "675",
                "wilaya_id": "19",
                "dayra": "Amoucha\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "676",
                "wilaya_id": "19",
                "dayra": "Babor\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "677",
                "wilaya_id": "19",
                "dayra": "Bazer Sakhra\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "678",
                "wilaya_id": "19",
                "dayra": "Beidha Bordj\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "679",
                "wilaya_id": "19",
                "dayra": "Belaa\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "680",
                "wilaya_id": "19",
                "dayra": "Beni Aziz\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "681",
                "wilaya_id": "19",
                "dayra": "Beni Chebana\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "682",
                "wilaya_id": "19",
                "dayra": "Beni Fouda\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "683",
                "wilaya_id": "19",
                "dayra": "Beni Hocine\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "684",
                "wilaya_id": "19",
                "dayra": "Beni Mouhli\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "685",
                "wilaya_id": "19",
                "dayra": "Bir El Arch\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "686",
                "wilaya_id": "19",
                "dayra": "Bir Haddada\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "687",
                "wilaya_id": "19",
                "dayra": "Bouandas\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "688",
                "wilaya_id": "19",
                "dayra": "Bougaa\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "689",
                "wilaya_id": "19",
                "dayra": "Bousselam\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "690",
                "wilaya_id": "19",
                "dayra": "Boutaleb\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "691",
                "wilaya_id": "19",
                "dayra": "Dehamcha\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "692",
                "wilaya_id": "19",
                "dayra": "Djemila\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "693",
                "wilaya_id": "19",
                "dayra": "Draa Kebila\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "694",
                "wilaya_id": "19",
                "dayra": "El Eulma",
                "status": "1",
                "created": null
            },
            {
                "id": "695",
                "wilaya_id": "19",
                "dayra": "El Ouldja\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "696",
                "wilaya_id": "19",
                "dayra": "El Ouricia\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "697",
                "wilaya_id": "19",
                "dayra": "Guellal\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "698",
                "wilaya_id": "19",
                "dayra": "Guelta Zerka",
                "status": "1",
                "created": null
            },
            {
                "id": "699",
                "wilaya_id": "19",
                "dayra": "Guenzet\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "700",
                "wilaya_id": "19",
                "dayra": "Guidjel\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "701",
                "wilaya_id": "19",
                "dayra": "Hamma\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "702",
                "wilaya_id": "19",
                "dayra": "Hammam Guergour\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "703",
                "wilaya_id": "19",
                "dayra": "Hammam Soukhna\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "704",
                "wilaya_id": "19",
                "dayra": "Harbil\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "705",
                "wilaya_id": "19",
                "dayra": "Ksar El Abtal\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "706",
                "wilaya_id": "19",
                "dayra": "Maaouia\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "707",
                "wilaya_id": "19",
                "dayra": "Maoklane\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "708",
                "wilaya_id": "19",
                "dayra": "Mezloug\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "709",
                "wilaya_id": "19",
                "dayra": "Oued El Barad\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "710",
                "wilaya_id": "19",
                "dayra": "Ouled Addouane",
                "status": "1",
                "created": null
            },
            {
                "id": "711",
                "wilaya_id": "19",
                "dayra": "Ouled Sabor\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "712",
                "wilaya_id": "19",
                "dayra": "Ouled Si Ahmed\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "713",
                "wilaya_id": "19",
                "dayra": "Ouled Tebben\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "714",
                "wilaya_id": "19",
                "dayra": "Rasfa\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "715",
                "wilaya_id": "19",
                "dayra": "Salah Bey\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "716",
                "wilaya_id": "19",
                "dayra": "Serdj El Ghoul\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "717",
                "wilaya_id": "19",
                "dayra": "Sétif\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "718",
                "wilaya_id": "19",
                "dayra": "Tachouda\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "719",
                "wilaya_id": "19",
                "dayra": "Talaifacene\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "720",
                "wilaya_id": "19",
                "dayra": "Taya",
                "status": "1",
                "created": null
            },
            {
                "id": "721",
                "wilaya_id": "19",
                "dayra": "Tella",
                "status": "1",
                "created": null
            },
            {
                "id": "722",
                "wilaya_id": "19",
                "dayra": "Tizi N'Bechar",
                "status": "1",
                "created": null
            },
            {
                "id": "723",
                "wilaya_id": "20",
                "dayra": "Aïn El Hadjar\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "724",
                "wilaya_id": "20",
                "dayra": "Aïn Sekhouna\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "725",
                "wilaya_id": "20",
                "dayra": "Aïn Soltane\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "726",
                "wilaya_id": "20",
                "dayra": "Doui Thabet\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "727",
                "wilaya_id": "20",
                "dayra": "El Hassasna\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "728",
                "wilaya_id": "20",
                "dayra": "Hounet\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "729",
                "wilaya_id": "20",
                "dayra": "Maamora\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "730",
                "wilaya_id": "20",
                "dayra": "Moulay Larbi\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "731",
                "wilaya_id": "20",
                "dayra": "Ouled Brahim\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "732",
                "wilaya_id": "20",
                "dayra": "Ouled Khaled\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "733",
                "wilaya_id": "20",
                "dayra": "Saïda\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "734",
                "wilaya_id": "20",
                "dayra": "Sidi Ahmed\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "735",
                "wilaya_id": "20",
                "dayra": "Sidi Amar\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "736",
                "wilaya_id": "20",
                "dayra": "Sidi Boubekeur\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "737",
                "wilaya_id": "20",
                "dayra": "Tircine\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "738",
                "wilaya_id": "20",
                "dayra": "Youb\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "739",
                "wilaya_id": "22",
                "dayra": "Aïn Adden\t",
                "status": "1",
                "created": null
            },
            {
                "id": "740",
                "wilaya_id": "22",
                "dayra": "Aïn El Berd\t",
                "status": "1",
                "created": null
            },
            {
                "id": "741",
                "wilaya_id": "22",
                "dayra": "Aïn Kada\t",
                "status": "1",
                "created": null
            },
            {
                "id": "742",
                "wilaya_id": "22",
                "dayra": "Aïn Thrid\t",
                "status": "1",
                "created": null
            },
            {
                "id": "743",
                "wilaya_id": "22",
                "dayra": "Aïn Tindamine\t",
                "status": "1",
                "created": null
            },
            {
                "id": "744",
                "wilaya_id": "22",
                "dayra": "Amarnas\t",
                "status": "1",
                "created": null
            },
            {
                "id": "745",
                "wilaya_id": "22",
                "dayra": "Badredine El Mokrani\t",
                "status": "1",
                "created": null
            },
            {
                "id": "746",
                "wilaya_id": "22",
                "dayra": "Belarbi\t",
                "status": "1",
                "created": null
            },
            {
                "id": "747",
                "wilaya_id": "22",
                "dayra": "Ben Badis\t",
                "status": "1",
                "created": null
            },
            {
                "id": "748",
                "wilaya_id": "22",
                "dayra": "Benachiba Chelia\t",
                "status": "1",
                "created": null
            },
            {
                "id": "749",
                "wilaya_id": "22",
                "dayra": "Bir El Hammam\t",
                "status": "1",
                "created": null
            },
            {
                "id": "750",
                "wilaya_id": "22",
                "dayra": "Boudjebaa El Bordj\t",
                "status": "1",
                "created": null
            },
            {
                "id": "751",
                "wilaya_id": "22",
                "dayra": "Boukhanafis\t",
                "status": "1",
                "created": null
            },
            {
                "id": "752",
                "wilaya_id": "22",
                "dayra": "Chettouane Belaila\t",
                "status": "1",
                "created": null
            },
            {
                "id": "753",
                "wilaya_id": "22",
                "dayra": "Dhaya\t",
                "status": "1",
                "created": null
            },
            {
                "id": "754",
                "wilaya_id": "22",
                "dayra": "El Haçaiba\t",
                "status": "1",
                "created": null
            },
            {
                "id": "755",
                "wilaya_id": "22",
                "dayra": "Hassi Dahou\t",
                "status": "1",
                "created": null
            },
            {
                "id": "756",
                "wilaya_id": "22",
                "dayra": "Hassi Zehana\t",
                "status": "1",
                "created": null
            },
            {
                "id": "757",
                "wilaya_id": "22",
                "dayra": "Lamtar\t",
                "status": "1",
                "created": null
            },
            {
                "id": "758",
                "wilaya_id": "22",
                "dayra": "Makedra\t",
                "status": "1",
                "created": null
            },
            {
                "id": "759",
                "wilaya_id": "22",
                "dayra": "Marhoum\t",
                "status": "1",
                "created": null
            },
            {
                "id": "760",
                "wilaya_id": "22",
                "dayra": "M'Cid\t",
                "status": "1",
                "created": null
            },
            {
                "id": "761",
                "wilaya_id": "22",
                "dayra": "Merine\t",
                "status": "1",
                "created": null
            },
            {
                "id": "762",
                "wilaya_id": "22",
                "dayra": "Mezaourou\t",
                "status": "1",
                "created": null
            },
            {
                "id": "763",
                "wilaya_id": "22",
                "dayra": "Mostefa Ben Brahim\t",
                "status": "1",
                "created": null
            },
            {
                "id": "764",
                "wilaya_id": "22",
                "dayra": "Moulay Slissen\t",
                "status": "1",
                "created": null
            },
            {
                "id": "765",
                "wilaya_id": "22",
                "dayra": "Oued Sebaa\t",
                "status": "1",
                "created": null
            },
            {
                "id": "766",
                "wilaya_id": "22",
                "dayra": "Oued Sefioun\t",
                "status": "1",
                "created": null
            },
            {
                "id": "767",
                "wilaya_id": "22",
                "dayra": "Oued Taourira\t",
                "status": "1",
                "created": null
            },
            {
                "id": "768",
                "wilaya_id": "22",
                "dayra": "Ras El Ma\t",
                "status": "1",
                "created": null
            },
            {
                "id": "769",
                "wilaya_id": "22",
                "dayra": "Redjem Demouche\t",
                "status": "1",
                "created": null
            },
            {
                "id": "770",
                "wilaya_id": "22",
                "dayra": "Sehala Thaoura\t",
                "status": "1",
                "created": null
            },
            {
                "id": "771",
                "wilaya_id": "22",
                "dayra": "Sfisef\t",
                "status": "1",
                "created": null
            },
            {
                "id": "772",
                "wilaya_id": "22",
                "dayra": "Sidi Ali Benyoub\t",
                "status": "1",
                "created": null
            },
            {
                "id": "773",
                "wilaya_id": "22",
                "dayra": "Sidi Ali Boussidi\t",
                "status": "1",
                "created": null
            },
            {
                "id": "774",
                "wilaya_id": "22",
                "dayra": "Sidi Bel Abbes\t",
                "status": "1",
                "created": null
            },
            {
                "id": "775",
                "wilaya_id": "22",
                "dayra": "Sidi Brahim\t",
                "status": "1",
                "created": null
            },
            {
                "id": "776",
                "wilaya_id": "22",
                "dayra": "Sidi Chaib\t",
                "status": "1",
                "created": null
            },
            {
                "id": "777",
                "wilaya_id": "22",
                "dayra": "Sidi Daho des Zairs\t",
                "status": "1",
                "created": null
            },
            {
                "id": "778",
                "wilaya_id": "22",
                "dayra": "Sidi Hamadouche\t",
                "status": "1",
                "created": null
            },
            {
                "id": "779",
                "wilaya_id": "22",
                "dayra": "Sidi Khaled\t",
                "status": "1",
                "created": null
            },
            {
                "id": "780",
                "wilaya_id": "22",
                "dayra": "Sidi Lahcene\t",
                "status": "1",
                "created": null
            },
            {
                "id": "781",
                "wilaya_id": "22",
                "dayra": "Sidi Yacoub\t",
                "status": "1",
                "created": null
            },
            {
                "id": "782",
                "wilaya_id": "22",
                "dayra": "Tabia\t",
                "status": "1",
                "created": null
            },
            {
                "id": "783",
                "wilaya_id": "22",
                "dayra": "Tafissour\t",
                "status": "1",
                "created": null
            },
            {
                "id": "784",
                "wilaya_id": "22",
                "dayra": "Taoudmout\t",
                "status": "1",
                "created": null
            },
            {
                "id": "785",
                "wilaya_id": "22",
                "dayra": "Teghalimet\t",
                "status": "1",
                "created": null
            },
            {
                "id": "786",
                "wilaya_id": "22",
                "dayra": "Telagh\t",
                "status": "1",
                "created": null
            },
            {
                "id": "787",
                "wilaya_id": "22",
                "dayra": "Tenira\t",
                "status": "1",
                "created": null
            },
            {
                "id": "788",
                "wilaya_id": "22",
                "dayra": "Tessala\t",
                "status": "1",
                "created": null
            },
            {
                "id": "789",
                "wilaya_id": "22",
                "dayra": "Tilmouni\t",
                "status": "1",
                "created": null
            },
            {
                "id": "790",
                "wilaya_id": "22",
                "dayra": "Zerouala\t",
                "status": "1",
                "created": null
            },
            {
                "id": "791",
                "wilaya_id": "21",
                "dayra": "Aïn Bouziane\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "792",
                "wilaya_id": "21",
                "dayra": "Aïn Charchar\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "793",
                "wilaya_id": "21",
                "dayra": "Aïn Kechra\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "794",
                "wilaya_id": "21",
                "dayra": "Aïn Zouit\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "795",
                "wilaya_id": "21",
                "dayra": "Zitouna\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "796",
                "wilaya_id": "21",
                "dayra": "Azzaba\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "797",
                "wilaya_id": "21",
                "dayra": "Bekkouche Lakhdar\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "798",
                "wilaya_id": "21",
                "dayra": "Bin El Ouiden\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "799",
                "wilaya_id": "21",
                "dayra": "Ben Azzouz\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "800",
                "wilaya_id": "21",
                "dayra": "Beni Bechir\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "801",
                "wilaya_id": "21",
                "dayra": "Beni Oulbane\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "802",
                "wilaya_id": "21",
                "dayra": "Beni Zid\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "803",
                "wilaya_id": "21",
                "dayra": "Bouchtata\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "804",
                "wilaya_id": "21",
                "dayra": "Cheraia\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "805",
                "wilaya_id": "21",
                "dayra": "Collo\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "806",
                "wilaya_id": "21",
                "dayra": "Djendel Saadi Mohamed\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "807",
                "wilaya_id": "21",
                "dayra": "El Ghedir\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "808",
                "wilaya_id": "21",
                "dayra": "El Hadaiek\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "809",
                "wilaya_id": "21",
                "dayra": "El Harrouch\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "810",
                "wilaya_id": "21",
                "dayra": "El Marsa\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "811",
                "wilaya_id": "21",
                "dayra": "Emdjez Edchich\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "812",
                "wilaya_id": "21",
                "dayra": "Es Sebt\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "813",
                "wilaya_id": "21",
                "dayra": "Filfila\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "814",
                "wilaya_id": "21",
                "dayra": "Hamadi Krouma\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "815",
                "wilaya_id": "21",
                "dayra": "Kanoua\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "816",
                "wilaya_id": "21",
                "dayra": "Kerkera\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "817",
                "wilaya_id": "21",
                "dayra": "Kheneg Mayoum\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "818",
                "wilaya_id": "21",
                "dayra": "Oued Zehour\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "819",
                "wilaya_id": "21",
                "dayra": "Ouldja Boulballout\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "820",
                "wilaya_id": "21",
                "dayra": "Ouled Attia\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "821",
                "wilaya_id": "21",
                "dayra": "Ouled Hbaba\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "822",
                "wilaya_id": "21",
                "dayra": "Oum Toub\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "823",
                "wilaya_id": "21",
                "dayra": "Ramdane Djamel\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "824",
                "wilaya_id": "21",
                "dayra": "Salah Bouchaour\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "825",
                "wilaya_id": "21",
                "dayra": "Sidi Mezghiche\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "826",
                "wilaya_id": "21",
                "dayra": "Skikda\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "827",
                "wilaya_id": "21",
                "dayra": "Tamalous\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "828",
                "wilaya_id": "21",
                "dayra": "Zerdaza\r\n",
                "status": "1",
                "created": null
            },
            {
                "id": "829",
                "wilaya_id": "23",
                "dayra": "Aïn Ben Beida",
                "status": "1",
                "created": null
            },
            {
                "id": "830",
                "wilaya_id": "23",
                "dayra": "Aïn Larbi",
                "status": "1",
                "created": null
            },
            {
                "id": "831",
                "wilaya_id": "23",
                "dayra": "Aïn Makhlouf",
                "status": "1",
                "created": null
            },
            {
                "id": "832",
                "wilaya_id": "23",
                "dayra": "Aïn Reggada",
                "status": "1",
                "created": null
            },
            {
                "id": "833",
                "wilaya_id": "23",
                "dayra": "Aïn Sandel",
                "status": "1",
                "created": null
            },
            {
                "id": "834",
                "wilaya_id": "23",
                "dayra": "Belkheir",
                "status": "1",
                "created": null
            },
            {
                "id": "835",
                "wilaya_id": "23",
                "dayra": "Ben Djerrah",
                "status": "1",
                "created": null
            },
            {
                "id": "836",
                "wilaya_id": "23",
                "dayra": "Beni Mezline",
                "status": "1",
                "created": null
            },
            {
                "id": "837",
                "wilaya_id": "23",
                "dayra": "Bordj Sabath",
                "status": "1",
                "created": null
            },
            {
                "id": "838",
                "wilaya_id": "23",
                "dayra": "Bouhachana",
                "status": "1",
                "created": null
            },
            {
                "id": "839",
                "wilaya_id": "23",
                "dayra": "Bouhamdane",
                "status": "1",
                "created": null
            },
            {
                "id": "840",
                "wilaya_id": "23",
                "dayra": "Bouati Mahmoud",
                "status": "1",
                "created": null
            },
            {
                "id": "841",
                "wilaya_id": "23",
                "dayra": "Bouchegouf",
                "status": "1",
                "created": null
            },
            {
                "id": "842",
                "wilaya_id": "23",
                "dayra": "Boumahra Ahmed",
                "status": "1",
                "created": null
            },
            {
                "id": "843",
                "wilaya_id": "23",
                "dayra": "Dahouara",
                "status": "1",
                "created": null
            },
            {
                "id": "844",
                "wilaya_id": "23",
                "dayra": "Djeballah Khemissi",
                "status": "1",
                "created": null
            },
            {
                "id": "845",
                "wilaya_id": "23",
                "dayra": "El Fedjoudj",
                "status": "1",
                "created": null
            },
            {
                "id": "846",
                "wilaya_id": "23",
                "dayra": "Guellat Bou Sbaa",
                "status": "1",
                "created": null
            },
            {
                "id": "847",
                "wilaya_id": "23",
                "dayra": "Guelma",
                "status": "1",
                "created": null
            },
            {
                "id": "848",
                "wilaya_id": "23",
                "dayra": "Hammam Debagh",
                "status": "1",
                "created": null
            },
            {
                "id": "849",
                "wilaya_id": "23",
                "dayra": "Hammam N'Bail",
                "status": "1",
                "created": null
            },
            {
                "id": "850",
                "wilaya_id": "23",
                "dayra": "Héliopolis",
                "status": "1",
                "created": null
            },
            {
                "id": "851",
                "wilaya_id": "23",
                "dayra": "Houari Boumédiène",
                "status": "1",
                "created": null
            },
            {
                "id": "852",
                "wilaya_id": "23",
                "dayra": "Khezarra",
                "status": "1",
                "created": null
            },
            {
                "id": "853",
                "wilaya_id": "23",
                "dayra": "Medjez Amar",
                "status": "1",
                "created": null
            },
            {
                "id": "854",
                "wilaya_id": "23",
                "dayra": "Medjez Sfa",
                "status": "1",
                "created": null
            },
            {
                "id": "855",
                "wilaya_id": "23",
                "dayra": "Nechmaya",
                "status": "1",
                "created": null
            },
            {
                "id": "856",
                "wilaya_id": "23",
                "dayra": "Oued Cheham",
                "status": "1",
                "created": null
            },
            {
                "id": "857",
                "wilaya_id": "23",
                "dayra": "Oued Fragha",
                "status": "1",
                "created": null
            },
            {
                "id": "858",
                "wilaya_id": "23",
                "dayra": "Oued Zenati",
                "status": "1",
                "created": null
            },
            {
                "id": "859",
                "wilaya_id": "23",
                "dayra": "Ras El Agba",
                "status": "1",
                "created": null
            },
            {
                "id": "860",
                "wilaya_id": "23",
                "dayra": "Roknia",
                "status": "1",
                "created": null
            },
            {
                "id": "861",
                "wilaya_id": "23",
                "dayra": "Sellaoua Announa",
                "status": "1",
                "created": null
            },
            {
                "id": "862",
                "wilaya_id": "23",
                "dayra": "Tamlouka",
                "status": "1",
                "created": null
            },
            {
                "id": "863",
                "wilaya_id": "24",
                "dayra": "Aïn Ben Beida\n",
                "status": "1",
                "created": null
            },
            {
                "id": "864",
                "wilaya_id": "24",
                "dayra": "Aïn Larbi\n",
                "status": "1",
                "created": null
            },
            {
                "id": "865",
                "wilaya_id": "24",
                "dayra": "Aïn Makhlouf\n",
                "status": "1",
                "created": null
            },
            {
                "id": "866",
                "wilaya_id": "24",
                "dayra": "Aïn Reggada\n",
                "status": "1",
                "created": null
            },
            {
                "id": "867",
                "wilaya_id": "24",
                "dayra": "Aïn Sandel\n",
                "status": "1",
                "created": null
            },
            {
                "id": "868",
                "wilaya_id": "24",
                "dayra": "Belkheir\n",
                "status": "1",
                "created": null
            },
            {
                "id": "869",
                "wilaya_id": "24",
                "dayra": "Ben Djerrah\n",
                "status": "1",
                "created": null
            },
            {
                "id": "870",
                "wilaya_id": "24",
                "dayra": "Beni Mezline\n",
                "status": "1",
                "created": null
            },
            {
                "id": "871",
                "wilaya_id": "24",
                "dayra": "Bordj Sabath\n",
                "status": "1",
                "created": null
            },
            {
                "id": "872",
                "wilaya_id": "24",
                "dayra": "Bouhachana\n",
                "status": "1",
                "created": null
            },
            {
                "id": "873",
                "wilaya_id": "24",
                "dayra": "Bouhamdane",
                "status": "1",
                "created": null
            },
            {
                "id": "874",
                "wilaya_id": "24",
                "dayra": "Bouati Mahmoud\n",
                "status": "1",
                "created": null
            },
            {
                "id": "875",
                "wilaya_id": "24",
                "dayra": "Bouchegouf\n",
                "status": "1",
                "created": null
            },
            {
                "id": "876",
                "wilaya_id": "24",
                "dayra": "Boumahra Ahmed\n",
                "status": "1",
                "created": null
            },
            {
                "id": "877",
                "wilaya_id": "24",
                "dayra": "Dahouara\n",
                "status": "1",
                "created": null
            },
            {
                "id": "878",
                "wilaya_id": "24",
                "dayra": "Djeballah Khemissi\n",
                "status": "1",
                "created": null
            },
            {
                "id": "879",
                "wilaya_id": "24",
                "dayra": "El Fedjoudj\n",
                "status": "1",
                "created": null
            },
            {
                "id": "880",
                "wilaya_id": "24",
                "dayra": "Guellat Bou Sbaa\n",
                "status": "1",
                "created": null
            },
            {
                "id": "881",
                "wilaya_id": "24",
                "dayra": "Guelma\n",
                "status": "1",
                "created": null
            },
            {
                "id": "882",
                "wilaya_id": "24",
                "dayra": "Hammam Debagh\n",
                "status": "1",
                "created": null
            },
            {
                "id": "883",
                "wilaya_id": "24",
                "dayra": "Hammam N'Bail\n",
                "status": "1",
                "created": null
            },
            {
                "id": "884",
                "wilaya_id": "24",
                "dayra": "Héliopolis\n",
                "status": "1",
                "created": null
            },
            {
                "id": "885",
                "wilaya_id": "24",
                "dayra": "Houari Boumédiène\n",
                "status": "1",
                "created": null
            },
            {
                "id": "886",
                "wilaya_id": "24",
                "dayra": "Khezarra\n",
                "status": "1",
                "created": null
            },
            {
                "id": "887",
                "wilaya_id": "24",
                "dayra": "Medjez Amar\n",
                "status": "1",
                "created": null
            },
            {
                "id": "888",
                "wilaya_id": "24",
                "dayra": "Medjez Sfa\n",
                "status": "1",
                "created": null
            },
            {
                "id": "889",
                "wilaya_id": "24",
                "dayra": "Nechmaya\n",
                "status": "1",
                "created": null
            },
            {
                "id": "890",
                "wilaya_id": "24",
                "dayra": "Oued Cheham\n",
                "status": "1",
                "created": null
            },
            {
                "id": "891",
                "wilaya_id": "24",
                "dayra": "Oued Fragha\n",
                "status": "1",
                "created": null
            },
            {
                "id": "892",
                "wilaya_id": "24",
                "dayra": "Oued Zenati\n",
                "status": "1",
                "created": null
            },
            {
                "id": "893",
                "wilaya_id": "24",
                "dayra": "Ras El Agba\n",
                "status": "1",
                "created": null
            },
            {
                "id": "894",
                "wilaya_id": "24",
                "dayra": "Roknia\n",
                "status": "1",
                "created": null
            },
            {
                "id": "895",
                "wilaya_id": "24",
                "dayra": "Sellaoua Announa\n",
                "status": "1",
                "created": null
            },
            {
                "id": "896",
                "wilaya_id": "24",
                "dayra": "Tamlouka\n",
                "status": "1",
                "created": null
            },
            {
                "id": "897",
                "wilaya_id": "25",
                "dayra": "Aïn Abid\n",
                "status": "1",
                "created": null
            },
            {
                "id": "898",
                "wilaya_id": "25",
                "dayra": "Aïn Smara\n",
                "status": "1",
                "created": null
            },
            {
                "id": "899",
                "wilaya_id": "25",
                "dayra": "Beni Hamiden\n",
                "status": "1",
                "created": null
            },
            {
                "id": "900",
                "wilaya_id": "25",
                "dayra": "Constantine\n",
                "status": "1",
                "created": null
            },
            {
                "id": "901",
                "wilaya_id": "25",
                "dayra": "Didouche Mourad\n",
                "status": "1",
                "created": null
            },
            {
                "id": "902",
                "wilaya_id": "25",
                "dayra": "El Khroub\n",
                "status": "1",
                "created": null
            },
            {
                "id": "903",
                "wilaya_id": "25",
                "dayra": "Hamma Bouziane\n",
                "status": "1",
                "created": null
            },
            {
                "id": "904",
                "wilaya_id": "25",
                "dayra": "Ibn Badis\n",
                "status": "1",
                "created": null
            },
            {
                "id": "905",
                "wilaya_id": "25",
                "dayra": "Ibn Ziad\n",
                "status": "1",
                "created": null
            },
            {
                "id": "906",
                "wilaya_id": "25",
                "dayra": "Messaoud Boudjriou\n",
                "status": "1",
                "created": null
            },
            {
                "id": "907",
                "wilaya_id": "25",
                "dayra": "Ouled Rahmoune\n",
                "status": "1",
                "created": null
            },
            {
                "id": "908",
                "wilaya_id": "25",
                "dayra": "Zighoud Youcef\n",
                "status": "1",
                "created": null
            },
            {
                "id": "909",
                "wilaya_id": "26",
                "dayra": "Aïn Boucif\n",
                "status": "1",
                "created": null
            },
            {
                "id": "910",
                "wilaya_id": "26",
                "dayra": "Aïn Ouksir\n",
                "status": "1",
                "created": null
            },
            {
                "id": "911",
                "wilaya_id": "26",
                "dayra": "Aissaouia\n",
                "status": "1",
                "created": null
            },
            {
                "id": "912",
                "wilaya_id": "26",
                "dayra": "Aziz\n",
                "status": "1",
                "created": null
            },
            {
                "id": "913",
                "wilaya_id": "26",
                "dayra": "Baata\n",
                "status": "1",
                "created": null
            },
            {
                "id": "914",
                "wilaya_id": "26",
                "dayra": "Benchicao\n",
                "status": "1",
                "created": null
            },
            {
                "id": "915",
                "wilaya_id": "26",
                "dayra": "Beni Slimane\n",
                "status": "1",
                "created": null
            },
            {
                "id": "916",
                "wilaya_id": "26",
                "dayra": "Berrouaghia\n",
                "status": "1",
                "created": null
            },
            {
                "id": "917",
                "wilaya_id": "26",
                "dayra": "Bir Ben Laabed\n",
                "status": "1",
                "created": null
            },
            {
                "id": "918",
                "wilaya_id": "26",
                "dayra": "Boghar\n",
                "status": "1",
                "created": null
            },
            {
                "id": "919",
                "wilaya_id": "26",
                "dayra": "Bou Aiche\n",
                "status": "1",
                "created": null
            },
            {
                "id": "920",
                "wilaya_id": "26",
                "dayra": "Bouaichoune\n",
                "status": "1",
                "created": null
            },
            {
                "id": "921",
                "wilaya_id": "26",
                "dayra": "Bouchrahil\n",
                "status": "1",
                "created": null
            },
            {
                "id": "922",
                "wilaya_id": "26",
                "dayra": "Boughezoul\n",
                "status": "1",
                "created": null
            },
            {
                "id": "923",
                "wilaya_id": "26",
                "dayra": "Bouskene\n",
                "status": "1",
                "created": null
            },
            {
                "id": "924",
                "wilaya_id": "26",
                "dayra": "Chahbounia\n",
                "status": "1",
                "created": null
            },
            {
                "id": "925",
                "wilaya_id": "26",
                "dayra": "Chellalet El Adhaoura\n",
                "status": "1",
                "created": null
            },
            {
                "id": "926",
                "wilaya_id": "26",
                "dayra": "Cheniguel\n",
                "status": "1",
                "created": null
            },
            {
                "id": "927",
                "wilaya_id": "26",
                "dayra": "Derrag\n",
                "status": "1",
                "created": null
            },
            {
                "id": "928",
                "wilaya_id": "26",
                "dayra": "Deux Bassins\n",
                "status": "1",
                "created": null
            },
            {
                "id": "929",
                "wilaya_id": "26",
                "dayra": "Djouab\n",
                "status": "1",
                "created": null
            },
            {
                "id": "930",
                "wilaya_id": "26",
                "dayra": "Draa Essamar\n",
                "status": "1",
                "created": null
            },
            {
                "id": "931",
                "wilaya_id": "26",
                "dayra": "El Azizia\n",
                "status": "1",
                "created": null
            },
            {
                "id": "932",
                "wilaya_id": "26",
                "dayra": "El Guelb El Kebir\n",
                "status": "1",
                "created": null
            },
            {
                "id": "933",
                "wilaya_id": "26",
                "dayra": "El Hamdania\n",
                "status": "1",
                "created": null
            },
            {
                "id": "934",
                "wilaya_id": "26",
                "dayra": "El Omaria\n",
                "status": "1",
                "created": null
            },
            {
                "id": "935",
                "wilaya_id": "26",
                "dayra": "El Ouinet\n",
                "status": "1",
                "created": null
            },
            {
                "id": "936",
                "wilaya_id": "26",
                "dayra": "Hannacha\n",
                "status": "1",
                "created": null
            },
            {
                "id": "937",
                "wilaya_id": "26",
                "dayra": "Kef Lakhdar\n",
                "status": "1",
                "created": null
            },
            {
                "id": "938",
                "wilaya_id": "26",
                "dayra": "Khams Djouamaa\n",
                "status": "1",
                "created": null
            },
            {
                "id": "939",
                "wilaya_id": "26",
                "dayra": "Ksar Boukhari\n",
                "status": "1",
                "created": null
            },
            {
                "id": "940",
                "wilaya_id": "26",
                "dayra": "Meghraoua\n",
                "status": "1",
                "created": null
            },
            {
                "id": "941",
                "wilaya_id": "26",
                "dayra": "Médéa\n",
                "status": "1",
                "created": null
            },
            {
                "id": "942",
                "wilaya_id": "26",
                "dayra": "Moudjbar\n",
                "status": "1",
                "created": null
            },
            {
                "id": "943",
                "wilaya_id": "26",
                "dayra": "Meftaha\n",
                "status": "1",
                "created": null
            },
            {
                "id": "944",
                "wilaya_id": "26",
                "dayra": "Mezerana\n",
                "status": "1",
                "created": null
            },
            {
                "id": "945",
                "wilaya_id": "26",
                "dayra": "Mihoub\n",
                "status": "1",
                "created": null
            },
            {
                "id": "946",
                "wilaya_id": "26",
                "dayra": "Ouamri\n",
                "status": "1",
                "created": null
            },
            {
                "id": "947",
                "wilaya_id": "26",
                "dayra": "Oued Harbil\n",
                "status": "1",
                "created": null
            },
            {
                "id": "948",
                "wilaya_id": "26",
                "dayra": "Ouled Antar\n",
                "status": "1",
                "created": null
            },
            {
                "id": "949",
                "wilaya_id": "26",
                "dayra": "Ouled Bouachra\n",
                "status": "1",
                "created": null
            },
            {
                "id": "950",
                "wilaya_id": "26",
                "dayra": "Ouled Brahim\n",
                "status": "1",
                "created": null
            },
            {
                "id": "951",
                "wilaya_id": "26",
                "dayra": "Ouled Deide\n",
                "status": "1",
                "created": null
            },
            {
                "id": "952",
                "wilaya_id": "26",
                "dayra": "Ouled Hellal\n",
                "status": "1",
                "created": null
            },
            {
                "id": "953",
                "wilaya_id": "26",
                "dayra": "Ouled Maaref\n",
                "status": "1",
                "created": null
            },
            {
                "id": "954",
                "wilaya_id": "26",
                "dayra": "Oum El Djalil\n",
                "status": "1",
                "created": null
            },
            {
                "id": "955",
                "wilaya_id": "26",
                "dayra": "Ouzera\n",
                "status": "1",
                "created": null
            },
            {
                "id": "956",
                "wilaya_id": "26",
                "dayra": "Rebaia\n",
                "status": "1",
                "created": null
            },
            {
                "id": "957",
                "wilaya_id": "26",
                "dayra": "Saneg\n",
                "status": "1",
                "created": null
            },
            {
                "id": "958",
                "wilaya_id": "26",
                "dayra": "Sedraia\n",
                "status": "1",
                "created": null
            },
            {
                "id": "959",
                "wilaya_id": "26",
                "dayra": "Seghouane\n",
                "status": "1",
                "created": null
            },
            {
                "id": "960",
                "wilaya_id": "26",
                "dayra": "Si Mahdjoub\n",
                "status": "1",
                "created": null
            },
            {
                "id": "961",
                "wilaya_id": "26",
                "dayra": "Sidi Damed\n",
                "status": "1",
                "created": null
            },
            {
                "id": "962",
                "wilaya_id": "26",
                "dayra": "Sidi Errabia\n",
                "status": "1",
                "created": null
            },
            {
                "id": "963",
                "wilaya_id": "26",
                "dayra": "Sidi Naamane\n",
                "status": "1",
                "created": null
            },
            {
                "id": "964",
                "wilaya_id": "26",
                "dayra": "Sidi Zahar\n",
                "status": "1",
                "created": null
            },
            {
                "id": "965",
                "wilaya_id": "26",
                "dayra": "Sidi Ziane\n",
                "status": "1",
                "created": null
            },
            {
                "id": "966",
                "wilaya_id": "26",
                "dayra": "Souagui\n",
                "status": "1",
                "created": null
            },
            {
                "id": "967",
                "wilaya_id": "26",
                "dayra": "Tablat\n",
                "status": "1",
                "created": null
            },
            {
                "id": "968",
                "wilaya_id": "26",
                "dayra": "Tafraout\n",
                "status": "1",
                "created": null
            },
            {
                "id": "969",
                "wilaya_id": "26",
                "dayra": "Tamesguida\n",
                "status": "1",
                "created": null
            },
            {
                "id": "970",
                "wilaya_id": "26",
                "dayra": "Tizi Mahdi\n",
                "status": "1",
                "created": null
            },
            {
                "id": "971",
                "wilaya_id": "26",
                "dayra": "Tlatet Eddouar\n",
                "status": "1",
                "created": null
            },
            {
                "id": "972",
                "wilaya_id": "26",
                "dayra": "Zoubiria",
                "status": "1",
                "created": null
            },
            {
                "id": "973",
                "wilaya_id": "27",
                "dayra": "Abdelmalek Ramdane\n",
                "status": "1",
                "created": null
            },
            {
                "id": "974",
                "wilaya_id": "27",
                "dayra": "Achaacha\n",
                "status": "1",
                "created": null
            },
            {
                "id": "975",
                "wilaya_id": "27",
                "dayra": "Aïn Boudinar\n",
                "status": "1",
                "created": null
            },
            {
                "id": "976",
                "wilaya_id": "27",
                "dayra": "Aïn Nouissy\n",
                "status": "1",
                "created": null
            },
            {
                "id": "977",
                "wilaya_id": "27",
                "dayra": "Aïn Sidi Cherif\n",
                "status": "1",
                "created": null
            },
            {
                "id": "978",
                "wilaya_id": "27",
                "dayra": "Aïn Tedles\n",
                "status": "1",
                "created": null
            },
            {
                "id": "979",
                "wilaya_id": "27",
                "dayra": "Blad Touahria\n",
                "status": "1",
                "created": null
            },
            {
                "id": "980",
                "wilaya_id": "27",
                "dayra": "Bouguirat\n",
                "status": "1",
                "created": null
            },
            {
                "id": "981",
                "wilaya_id": "27",
                "dayra": "El Hassiane\n",
                "status": "1",
                "created": null
            },
            {
                "id": "982",
                "wilaya_id": "27",
                "dayra": "Fornaka\n",
                "status": "1",
                "created": null
            },
            {
                "id": "983",
                "wilaya_id": "27",
                "dayra": "Hadjadj\n",
                "status": "1",
                "created": null
            },
            {
                "id": "984",
                "wilaya_id": "27",
                "dayra": "Hassi Mameche\n",
                "status": "1",
                "created": null
            },
            {
                "id": "985",
                "wilaya_id": "27",
                "dayra": "Khadra\n",
                "status": "1",
                "created": null
            },
            {
                "id": "986",
                "wilaya_id": "27",
                "dayra": "Kheireddine\n",
                "status": "1",
                "created": null
            },
            {
                "id": "987",
                "wilaya_id": "27",
                "dayra": "Mansourah\n",
                "status": "1",
                "created": null
            },
            {
                "id": "988",
                "wilaya_id": "27",
                "dayra": "Mesra\n",
                "status": "1",
                "created": null
            },
            {
                "id": "989",
                "wilaya_id": "27",
                "dayra": "Mazagran\n",
                "status": "1",
                "created": null
            },
            {
                "id": "990",
                "wilaya_id": "27",
                "dayra": "Mostaganem\n",
                "status": "1",
                "created": null
            },
            {
                "id": "991",
                "wilaya_id": "27",
                "dayra": "Nekmaria\n",
                "status": "1",
                "created": null
            },
            {
                "id": "992",
                "wilaya_id": "27",
                "dayra": "Oued El Kheir\n",
                "status": "1",
                "created": null
            },
            {
                "id": "993",
                "wilaya_id": "27",
                "dayra": "Ouled Boughalem\n",
                "status": "1",
                "created": null
            },
            {
                "id": "994",
                "wilaya_id": "27",
                "dayra": "Ouled Maallah\n",
                "status": "1",
                "created": null
            },
            {
                "id": "995",
                "wilaya_id": "27",
                "dayra": "Safsaf\n",
                "status": "1",
                "created": null
            },
            {
                "id": "996",
                "wilaya_id": "27",
                "dayra": "Sayada\n",
                "status": "1",
                "created": null
            },
            {
                "id": "997",
                "wilaya_id": "27",
                "dayra": "Sidi Ali\n",
                "status": "1",
                "created": null
            },
            {
                "id": "998",
                "wilaya_id": "27",
                "dayra": "Sidi Belattar\n",
                "status": "1",
                "created": null
            },
            {
                "id": "999",
                "wilaya_id": "27",
                "dayra": "Sidi Lakhdar\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1000",
                "wilaya_id": "27",
                "dayra": "Sirat\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1001",
                "wilaya_id": "27",
                "dayra": "Souaflia\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1002",
                "wilaya_id": "27",
                "dayra": "Sour\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1003",
                "wilaya_id": "27",
                "dayra": "Stidia\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1004",
                "wilaya_id": "27",
                "dayra": "Tazgait\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1005",
                "wilaya_id": "28",
                "dayra": "Aïn El Hadjel\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1006",
                "wilaya_id": "28",
                "dayra": "Aïn El Melh\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1007",
                "wilaya_id": "28",
                "dayra": "Aïn Errich\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1008",
                "wilaya_id": "28",
                "dayra": "Aïn Fares\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1009",
                "wilaya_id": "28",
                "dayra": "Aïn Khadra\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1010",
                "wilaya_id": "28",
                "dayra": "Belaiba\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1011",
                "wilaya_id": "28",
                "dayra": "Ben Srour\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1012",
                "wilaya_id": "28",
                "dayra": "Beni Ilmane\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1013",
                "wilaya_id": "28",
                "dayra": "Benzouh\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1014",
                "wilaya_id": "28",
                "dayra": "Berhoum\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1015",
                "wilaya_id": "28",
                "dayra": "Bir Foda\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1016",
                "wilaya_id": "28",
                "dayra": "Bou Saâda\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1017",
                "wilaya_id": "28",
                "dayra": "Bouti Sayah\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1018",
                "wilaya_id": "28",
                "dayra": "Chellal\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1019",
                "wilaya_id": "28",
                "dayra": "Dehahna\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1020",
                "wilaya_id": "28",
                "dayra": "Djebel Messaad\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1021",
                "wilaya_id": "28",
                "dayra": "El Hamel\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1022",
                "wilaya_id": "28",
                "dayra": "El Houamed\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1023",
                "wilaya_id": "28",
                "dayra": "Hammam Dhalaa\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1024",
                "wilaya_id": "28",
                "dayra": "Khettouti Sed El Djir\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1025",
                "wilaya_id": "28",
                "dayra": "Khoubana\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1026",
                "wilaya_id": "28",
                "dayra": "Maadid\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1027",
                "wilaya_id": "28",
                "dayra": "Maarif\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1028",
                "wilaya_id": "28",
                "dayra": "Magra\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1029",
                "wilaya_id": "28",
                "dayra": "M'Cif\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1030",
                "wilaya_id": "28",
                "dayra": "Medjedel\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1031",
                "wilaya_id": "28",
                "dayra": "M'Sila\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1032",
                "wilaya_id": "28",
                "dayra": "M'Tarfa\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1033",
                "wilaya_id": "28",
                "dayra": "Ouanougha\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1034",
                "wilaya_id": "28",
                "dayra": "Ouled Addi Guebala\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1035",
                "wilaya_id": "28",
                "dayra": "Ouled Atia\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1036",
                "wilaya_id": "28",
                "dayra": "Mohammed Boudiaf\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1037",
                "wilaya_id": "28",
                "dayra": "Ouled Derradj\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1038",
                "wilaya_id": "28",
                "dayra": "Ouled Madhi\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1039",
                "wilaya_id": "28",
                "dayra": "Ouled Mansour\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1040",
                "wilaya_id": "28",
                "dayra": "Ouled Sidi Brahim\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1041",
                "wilaya_id": "28",
                "dayra": "Ouled Slimane\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1042",
                "wilaya_id": "28",
                "dayra": "Oultem\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1043",
                "wilaya_id": "28",
                "dayra": "Sidi Aïssa\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1044",
                "wilaya_id": "28",
                "dayra": "Sidi Ameur\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1045",
                "wilaya_id": "28",
                "dayra": "Sidi Hadjeres\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1046",
                "wilaya_id": "28",
                "dayra": "Sidi M'Hamed\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1047",
                "wilaya_id": "28",
                "dayra": "Slim\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1048",
                "wilaya_id": "28",
                "dayra": "Souamaa\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1049",
                "wilaya_id": "28",
                "dayra": "Tamsa\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1050",
                "wilaya_id": "28",
                "dayra": "Tarmount\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1051",
                "wilaya_id": "28",
                "dayra": "Zarzour",
                "status": "1",
                "created": null
            },
            {
                "id": "1052",
                "wilaya_id": "29",
                "dayra": "Aïn Fares\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1053",
                "wilaya_id": "29",
                "dayra": "Aïn Fekan\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1054",
                "wilaya_id": "29",
                "dayra": "Aïn Ferah\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1055",
                "wilaya_id": "29",
                "dayra": "Aïn Fras\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1056",
                "wilaya_id": "29",
                "dayra": "Alaïmia\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1057",
                "wilaya_id": "29",
                "dayra": "Aouf\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1058",
                "wilaya_id": "29",
                "dayra": "Beniane\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1059",
                "wilaya_id": "29",
                "dayra": "Bou Hanifia\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1060",
                "wilaya_id": "29",
                "dayra": "Bou Henni\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1061",
                "wilaya_id": "29",
                "dayra": "Chorfa\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1062",
                "wilaya_id": "29",
                "dayra": "El Bordj\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1063",
                "wilaya_id": "29",
                "dayra": "El Gaada\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1064",
                "wilaya_id": "29",
                "dayra": "El Ghomri\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1065",
                "wilaya_id": "29",
                "dayra": "El Guettana\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1066",
                "wilaya_id": "29",
                "dayra": "El Keurt\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1067",
                "wilaya_id": "29",
                "dayra": "El Menaouer\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1068",
                "wilaya_id": "29",
                "dayra": "Ferraguig\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1069",
                "wilaya_id": "29",
                "dayra": "Froha\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1070",
                "wilaya_id": "29",
                "dayra": "Gharrous\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1071",
                "wilaya_id": "29",
                "dayra": "Guerdjoum\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1072",
                "wilaya_id": "29",
                "dayra": "Ghriss\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1073",
                "wilaya_id": "29",
                "dayra": "Hachem\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1074",
                "wilaya_id": "29",
                "dayra": "Hacine\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1075",
                "wilaya_id": "29",
                "dayra": "Khalouia\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1076",
                "wilaya_id": "29",
                "dayra": "Makdha\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1077",
                "wilaya_id": "29",
                "dayra": "Mamounia\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1078",
                "wilaya_id": "29",
                "dayra": "Maoussa\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1079",
                "wilaya_id": "29",
                "dayra": "Mascara\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1080",
                "wilaya_id": "29",
                "dayra": "Matemore\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1081",
                "wilaya_id": "29",
                "dayra": "Mocta Douz\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1082",
                "wilaya_id": "29",
                "dayra": "Mohammadia\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1083",
                "wilaya_id": "29",
                "dayra": "Nesmoth\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1084",
                "wilaya_id": "29",
                "dayra": "Oggaz\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1085",
                "wilaya_id": "29",
                "dayra": "Oued El Abtal\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1086",
                "wilaya_id": "29",
                "dayra": "Oued Taria\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1087",
                "wilaya_id": "29",
                "dayra": "Ras El Aïn Amirouche\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1088",
                "wilaya_id": "29",
                "dayra": "Sedjerara\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1089",
                "wilaya_id": "29",
                "dayra": "Sehailia\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1090",
                "wilaya_id": "29",
                "dayra": "Sidi Abdeldjebar\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1091",
                "wilaya_id": "29",
                "dayra": "Sidi Abdelmoumen\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1092",
                "wilaya_id": "29",
                "dayra": "Sidi Kada\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1093",
                "wilaya_id": "29",
                "dayra": "Sidi Boussaid\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1094",
                "wilaya_id": "29",
                "dayra": "Sig\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1095",
                "wilaya_id": "29",
                "dayra": "Tighennif\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1096",
                "wilaya_id": "29",
                "dayra": "Tizi\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1097",
                "wilaya_id": "29",
                "dayra": "Zahana\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1098",
                "wilaya_id": "29",
                "dayra": "Zelmata\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1099",
                "wilaya_id": "30",
                "dayra": "Aïn Beida\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1100",
                "wilaya_id": "30",
                "dayra": "El Borma\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1101",
                "wilaya_id": "30",
                "dayra": "Hassi Ben Abdellah\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1102",
                "wilaya_id": "30",
                "dayra": "Hassi Messaoud\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1103",
                "wilaya_id": "30",
                "dayra": "N'Goussa\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1104",
                "wilaya_id": "30",
                "dayra": "Ouargla\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1105",
                "wilaya_id": "30",
                "dayra": "Rouissat\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1106",
                "wilaya_id": "30",
                "dayra": "Sidi Khouiled\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1107",
                "wilaya_id": "31",
                "dayra": "Oran\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1108",
                "wilaya_id": "31",
                "dayra": "Gdyel\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1109",
                "wilaya_id": "31",
                "dayra": "Bir El Djir\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1110",
                "wilaya_id": "31",
                "dayra": "Hassi Bounif\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1111",
                "wilaya_id": "31",
                "dayra": "Es Senia\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1112",
                "wilaya_id": "31",
                "dayra": "Arzew\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1113",
                "wilaya_id": "31",
                "dayra": "Bethioua\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1114",
                "wilaya_id": "31",
                "dayra": "Marsat El Hadjadj\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1115",
                "wilaya_id": "31",
                "dayra": "Aïn El Turk\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1116",
                "wilaya_id": "31",
                "dayra": "El Ançor\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1117",
                "wilaya_id": "31",
                "dayra": "Oued Tlelat\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1118",
                "wilaya_id": "31",
                "dayra": "Tafraoui\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1119",
                "wilaya_id": "31",
                "dayra": "Sidi Chami\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1120",
                "wilaya_id": "31",
                "dayra": "Boufatis\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1121",
                "wilaya_id": "31",
                "dayra": "Mers El Kébir\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1122",
                "wilaya_id": "31",
                "dayra": "Bousfer\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1123",
                "wilaya_id": "31",
                "dayra": "El Kerma\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1124",
                "wilaya_id": "31",
                "dayra": "El Braya\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1125",
                "wilaya_id": "31",
                "dayra": "Hassi Ben Okba\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1126",
                "wilaya_id": "31",
                "dayra": "Ben Freha\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1127",
                "wilaya_id": "31",
                "dayra": "Hassi Mefsoukh\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1128",
                "wilaya_id": "31",
                "dayra": "Sidi Benyebka\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1129",
                "wilaya_id": "31",
                "dayra": "Misserghin\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1130",
                "wilaya_id": "31",
                "dayra": "Boutlelis\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1131",
                "wilaya_id": "31",
                "dayra": "Aïn El Kerma\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1132",
                "wilaya_id": "31",
                "dayra": "Aïn El Bia\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1133",
                "wilaya_id": "32",
                "dayra": "El Bayadh\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1134",
                "wilaya_id": "32",
                "dayra": "Rogassa\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1135",
                "wilaya_id": "32",
                "dayra": "Stitten\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1136",
                "wilaya_id": "32",
                "dayra": "Brezina\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1137",
                "wilaya_id": "32",
                "dayra": "Ghassoul\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1138",
                "wilaya_id": "32",
                "dayra": "Boualem\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1139",
                "wilaya_id": "32",
                "dayra": "El Abiodh Sidi Cheikh\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1140",
                "wilaya_id": "32",
                "dayra": "Aïn El Orak\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1141",
                "wilaya_id": "32",
                "dayra": "Arbaouat\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1142",
                "wilaya_id": "32",
                "dayra": "Bougtoub\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1143",
                "wilaya_id": "32",
                "dayra": "El Kheiter\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1144",
                "wilaya_id": "32",
                "dayra": "Kef El Ahmar\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1145",
                "wilaya_id": "32",
                "dayra": "Boussemghoun\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1146",
                "wilaya_id": "32",
                "dayra": "Chellala\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1147",
                "wilaya_id": "32",
                "dayra": "Kraakda\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1148",
                "wilaya_id": "32",
                "dayra": "El Bnoud\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1149",
                "wilaya_id": "32",
                "dayra": "Cheguig\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1150",
                "wilaya_id": "32",
                "dayra": "Sidi Ameur\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1151",
                "wilaya_id": "32",
                "dayra": "El Mehara\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1152",
                "wilaya_id": "32",
                "dayra": "Tousmouline\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1153",
                "wilaya_id": "32",
                "dayra": "Sidi Slimane\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1154",
                "wilaya_id": "32",
                "dayra": "Sidi Tifour\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1155",
                "wilaya_id": "33",
                "dayra": "Aïn Taghrout\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1156",
                "wilaya_id": "33",
                "dayra": "Aïn Tesra\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1157",
                "wilaya_id": "33",
                "dayra": "Belimour\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1158",
                "wilaya_id": "33",
                "dayra": "Ben Daoud\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1159",
                "wilaya_id": "33",
                "dayra": "Bir Kasdali\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1160",
                "wilaya_id": "33",
                "dayra": "Bordj Bou Arreridj\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1161",
                "wilaya_id": "33",
                "dayra": "Bordj Ghédir\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1162",
                "wilaya_id": "33",
                "dayra": "Bordj Zemoura\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1163",
                "wilaya_id": "33",
                "dayra": "Colla\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1164",
                "wilaya_id": "33",
                "dayra": "Djaafra\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1165",
                "wilaya_id": "33",
                "dayra": "El Ach\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1166",
                "wilaya_id": "33",
                "dayra": "El Achir\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1167",
                "wilaya_id": "33",
                "dayra": "El Anseur\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1168",
                "wilaya_id": "33",
                "dayra": "El Hamadia\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1169",
                "wilaya_id": "33",
                "dayra": "El Main\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1170",
                "wilaya_id": "33",
                "dayra": "El M'hir\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1171",
                "wilaya_id": "33",
                "dayra": "Ghilassa\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1172",
                "wilaya_id": "33",
                "dayra": "Haraza\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1173",
                "wilaya_id": "33",
                "dayra": "Hasnaoua\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1174",
                "wilaya_id": "33",
                "dayra": "Khelil\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1175",
                "wilaya_id": "33",
                "dayra": "Ksour\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1176",
                "wilaya_id": "33",
                "dayra": "Mansoura\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1177",
                "wilaya_id": "33",
                "dayra": "Medjana\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1178",
                "wilaya_id": "33",
                "dayra": "Ouled Brahem\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1179",
                "wilaya_id": "33",
                "dayra": "Ouled Dahmane\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1180",
                "wilaya_id": "33",
                "dayra": "Ouled Sidi Brahim\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1181",
                "wilaya_id": "33",
                "dayra": "Rabta\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1182",
                "wilaya_id": "33",
                "dayra": "Ras El Oued\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1183",
                "wilaya_id": "33",
                "dayra": "Sidi Embarek\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1184",
                "wilaya_id": "33",
                "dayra": "Tefreg\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1185",
                "wilaya_id": "33",
                "dayra": "Taglait\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1186",
                "wilaya_id": "33",
                "dayra": "Teniet En Nasr\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1187",
                "wilaya_id": "33",
                "dayra": "Tassameurt\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1188",
                "wilaya_id": "33",
                "dayra": "Tixter\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1189",
                "wilaya_id": "34",
                "dayra": "Afir\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1190",
                "wilaya_id": "34",
                "dayra": "Ammal\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1191",
                "wilaya_id": "34",
                "dayra": "Baghlia\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1192",
                "wilaya_id": "34",
                "dayra": "Ben Choud\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1193",
                "wilaya_id": "34",
                "dayra": "Beni Amrane\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1194",
                "wilaya_id": "34",
                "dayra": "Bordj Menaïel\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1195",
                "wilaya_id": "34",
                "dayra": "Boudouaou\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1196",
                "wilaya_id": "34",
                "dayra": "Boudouaou-El-Bahri\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1197",
                "wilaya_id": "34",
                "dayra": "Boumerdes\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1198",
                "wilaya_id": "34",
                "dayra": "Bouzegza Keddara\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1199",
                "wilaya_id": "34",
                "dayra": "Chabet el Ameur\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1200",
                "wilaya_id": "34",
                "dayra": "Corso\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1201",
                "wilaya_id": "34",
                "dayra": "Dellys\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1202",
                "wilaya_id": "34",
                "dayra": "Djinet\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1203",
                "wilaya_id": "34",
                "dayra": "El Kharrouba\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1204",
                "wilaya_id": "34",
                "dayra": "Hammedi\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1205",
                "wilaya_id": "34",
                "dayra": "Issers\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1206",
                "wilaya_id": "34",
                "dayra": "Khemis El-Khechna\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1207",
                "wilaya_id": "34",
                "dayra": "Larbatache\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1208",
                "wilaya_id": "34",
                "dayra": "Leghata\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1209",
                "wilaya_id": "34",
                "dayra": "Naciria\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1210",
                "wilaya_id": "34",
                "dayra": "Ouled Aïssa\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1211",
                "wilaya_id": "34",
                "dayra": "Ouled Hedadj\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1212",
                "wilaya_id": "34",
                "dayra": "Ouled Moussa\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1213",
                "wilaya_id": "34",
                "dayra": "Si Mustapha\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1214",
                "wilaya_id": "34",
                "dayra": "Sidi Daoud\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1215",
                "wilaya_id": "34",
                "dayra": "Souk El Had\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1216",
                "wilaya_id": "34",
                "dayra": "Taourga\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1217",
                "wilaya_id": "34",
                "dayra": "Thenia\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1218",
                "wilaya_id": "34",
                "dayra": "Tidjelabine\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1219",
                "wilaya_id": "34",
                "dayra": "Timezrit\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1220",
                "wilaya_id": "34",
                "dayra": "Zemmouri\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1221",
                "wilaya_id": "35",
                "dayra": "Aïn El Assel\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1222",
                "wilaya_id": "35",
                "dayra": "Aïn Kerma\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1223",
                "wilaya_id": "35",
                "dayra": "Asfour\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1224",
                "wilaya_id": "35",
                "dayra": "Ben Mehidi\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1225",
                "wilaya_id": "35",
                "dayra": "Berrihane\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1226",
                "wilaya_id": "35",
                "dayra": "Besbes\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1227",
                "wilaya_id": "35",
                "dayra": "Bougous\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1228",
                "wilaya_id": "35",
                "dayra": "Bouhadjar\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1229",
                "wilaya_id": "35",
                "dayra": "Bouteldja\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1230",
                "wilaya_id": "35",
                "dayra": "Chebaita Mokhtar\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1231",
                "wilaya_id": "35",
                "dayra": "Chefia\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1232",
                "wilaya_id": "35",
                "dayra": "Chihani\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1233",
                "wilaya_id": "35",
                "dayra": "Dréan\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1234",
                "wilaya_id": "35",
                "dayra": "Echatt\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1235",
                "wilaya_id": "35",
                "dayra": "El Aioun\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1236",
                "wilaya_id": "35",
                "dayra": "El Kala\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1237",
                "wilaya_id": "35",
                "dayra": "El Tarf\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1238",
                "wilaya_id": "35",
                "dayra": "Hammam Beni Salah\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1239",
                "wilaya_id": "35",
                "dayra": "Lac des Oiseaux\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1240",
                "wilaya_id": "35",
                "dayra": "Oued Zitoun\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1241",
                "wilaya_id": "35",
                "dayra": "Raml Souk\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1242",
                "wilaya_id": "35",
                "dayra": "Souarekh\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1243",
                "wilaya_id": "35",
                "dayra": "Zerizer\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1244",
                "wilaya_id": "35",
                "dayra": "Zitouna\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1245",
                "wilaya_id": "36",
                "dayra": "Ammari\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1246",
                "wilaya_id": "36",
                "dayra": "Beni Chaib\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1247",
                "wilaya_id": "36",
                "dayra": "Beni Lahcene\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1248",
                "wilaya_id": "36",
                "dayra": "Boucaid\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1249",
                "wilaya_id": "36",
                "dayra": "Bordj Bou Naama\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1250",
                "wilaya_id": "36",
                "dayra": "Bordj El Emir Abdelkader\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1251",
                "wilaya_id": "36",
                "dayra": "Khemisti\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1252",
                "wilaya_id": "36",
                "dayra": "Larbaa\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1253",
                "wilaya_id": "36",
                "dayra": "Lardjem\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1254",
                "wilaya_id": "36",
                "dayra": "Layoune\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1255",
                "wilaya_id": "36",
                "dayra": "Lazharia\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1256",
                "wilaya_id": "36",
                "dayra": "Maacem\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1257",
                "wilaya_id": "36",
                "dayra": "Melaab\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1258",
                "wilaya_id": "36",
                "dayra": "Ouled Bessem\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1259",
                "wilaya_id": "36",
                "dayra": "Sidi Abed\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1260",
                "wilaya_id": "36",
                "dayra": "Sidi Boutouchent\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1261",
                "wilaya_id": "36",
                "dayra": "Sidi Lantri\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1262",
                "wilaya_id": "36",
                "dayra": "Sidi Slimane\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1263",
                "wilaya_id": "36",
                "dayra": "Tamalaht\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1264",
                "wilaya_id": "36",
                "dayra": "Theniet El Had\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1265",
                "wilaya_id": "36",
                "dayra": "Tissemsilt\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1266",
                "wilaya_id": "36",
                "dayra": "Youssoufia\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1267",
                "wilaya_id": "37",
                "dayra": "El Oued\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1268",
                "wilaya_id": "37",
                "dayra": "Robbah\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1269",
                "wilaya_id": "37",
                "dayra": "Oued El Alenda\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1270",
                "wilaya_id": "37",
                "dayra": "Bayadha\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1271",
                "wilaya_id": "37",
                "dayra": "Nakhla\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1272",
                "wilaya_id": "37",
                "dayra": "Guemar\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1273",
                "wilaya_id": "37",
                "dayra": "Kouinine\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1274",
                "wilaya_id": "37",
                "dayra": "Reguiba\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1275",
                "wilaya_id": "37",
                "dayra": "Hamraia\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1276",
                "wilaya_id": "37",
                "dayra": "Taghzout\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1277",
                "wilaya_id": "37",
                "dayra": "Debila\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1278",
                "wilaya_id": "37",
                "dayra": "Hassani Abdelkrim\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1279",
                "wilaya_id": "37",
                "dayra": "Hassi Khalifa\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1280",
                "wilaya_id": "37",
                "dayra": "Taleb Larbi\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1281",
                "wilaya_id": "37",
                "dayra": "Douar El Ma\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1282",
                "wilaya_id": "37",
                "dayra": "Sidi Aoun\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1283",
                "wilaya_id": "37",
                "dayra": "Trifaoui\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1284",
                "wilaya_id": "37",
                "dayra": "Magrane\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1285",
                "wilaya_id": "37",
                "dayra": "Beni Guecha\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1286",
                "wilaya_id": "37",
                "dayra": "Ourmas\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1287",
                "wilaya_id": "37",
                "dayra": "El Ogla\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1288",
                "wilaya_id": "37",
                "dayra": "Mih Ouansa\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1289",
                "wilaya_id": "38",
                "dayra": "Aïn Touila\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1290",
                "wilaya_id": "38",
                "dayra": "Babar\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1291",
                "wilaya_id": "38",
                "dayra": "Baghai\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1292",
                "wilaya_id": "38",
                "dayra": "Bouhmama\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1293",
                "wilaya_id": "38",
                "dayra": "Chechar\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1294",
                "wilaya_id": "38",
                "dayra": "Chelia\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1295",
                "wilaya_id": "38",
                "dayra": "Djellal\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1296",
                "wilaya_id": "38",
                "dayra": "El Hamma\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1297",
                "wilaya_id": "38",
                "dayra": "El Mahmal\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1298",
                "wilaya_id": "38",
                "dayra": "El Oueldja\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1299",
                "wilaya_id": "38",
                "dayra": "Ensigha\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1300",
                "wilaya_id": "38",
                "dayra": "Kais\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1301",
                "wilaya_id": "38",
                "dayra": "Khenchela\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1302",
                "wilaya_id": "38",
                "dayra": "Khirane\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1303",
                "wilaya_id": "38",
                "dayra": "M'Sara\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1304",
                "wilaya_id": "38",
                "dayra": "M'Toussa\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1305",
                "wilaya_id": "38",
                "dayra": "Ouled Rechache\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1306",
                "wilaya_id": "38",
                "dayra": "Remila\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1307",
                "wilaya_id": "38",
                "dayra": "Tamza\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1308",
                "wilaya_id": "38",
                "dayra": "Taouzient\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1309",
                "wilaya_id": "38",
                "dayra": "Yabous\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1310",
                "wilaya_id": "39",
                "dayra": "Souk Ahras\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1311",
                "wilaya_id": "39",
                "dayra": "Sedrata\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1312",
                "wilaya_id": "39",
                "dayra": "Hanancha\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1313",
                "wilaya_id": "39",
                "dayra": "Mechroha\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1314",
                "wilaya_id": "39",
                "dayra": "Ouled Driss\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1315",
                "wilaya_id": "39",
                "dayra": "Tiffech\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1316",
                "wilaya_id": "39",
                "dayra": "Zaarouria\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1317",
                "wilaya_id": "39",
                "dayra": "Taoura\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1318",
                "wilaya_id": "39",
                "dayra": "Dréa\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1319",
                "wilaya_id": "39",
                "dayra": "Heddada\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1320",
                "wilaya_id": "39",
                "dayra": "Khedara\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1321",
                "wilaya_id": "39",
                "dayra": "Merahna\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1322",
                "wilaya_id": "39",
                "dayra": "Ouled Moumene\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1323",
                "wilaya_id": "39",
                "dayra": "Bir Bou Haouch\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1324",
                "wilaya_id": "39",
                "dayra": "M'daourouch\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1325",
                "wilaya_id": "39",
                "dayra": "Oum El Adhaim\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1326",
                "wilaya_id": "39",
                "dayra": "Aïn Zana\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1327",
                "wilaya_id": "39",
                "dayra": "Aïn Soltane\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1328",
                "wilaya_id": "39",
                "dayra": "Ouillen\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1329",
                "wilaya_id": "39",
                "dayra": "Sidi Fredj\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1330",
                "wilaya_id": "39",
                "dayra": "Safel El Ouiden\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1331",
                "wilaya_id": "39",
                "dayra": "Ragouba\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1332",
                "wilaya_id": "39",
                "dayra": "Khemissa\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1333",
                "wilaya_id": "39",
                "dayra": "Oued Keberit\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1334",
                "wilaya_id": "39",
                "dayra": "Terraguelt\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1335",
                "wilaya_id": "39",
                "dayra": "Zouabi\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1336",
                "wilaya_id": "40",
                "dayra": "Tipaza\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1337",
                "wilaya_id": "40",
                "dayra": "Menaceur\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1338",
                "wilaya_id": "40",
                "dayra": "Larhat\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1339",
                "wilaya_id": "40",
                "dayra": "Douaouda\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1340",
                "wilaya_id": "40",
                "dayra": "Bourkika\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1341",
                "wilaya_id": "40",
                "dayra": "Khemisti\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1342",
                "wilaya_id": "40",
                "dayra": "Aghbal\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1343",
                "wilaya_id": "40",
                "dayra": "Hadjout\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1344",
                "wilaya_id": "40",
                "dayra": "Sidi Amar\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1345",
                "wilaya_id": "40",
                "dayra": "Gouraya\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1346",
                "wilaya_id": "40",
                "dayra": "Nador\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1347",
                "wilaya_id": "40",
                "dayra": "Chaiba\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1348",
                "wilaya_id": "40",
                "dayra": "Aïn Tagourait\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1349",
                "wilaya_id": "40",
                "dayra": "Cherchell\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1350",
                "wilaya_id": "40",
                "dayra": "Damous\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1351",
                "wilaya_id": "40",
                "dayra": "Merad\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1352",
                "wilaya_id": "40",
                "dayra": "Fouka\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1353",
                "wilaya_id": "40",
                "dayra": "Bou Ismaïl\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1354",
                "wilaya_id": "40",
                "dayra": "Ahmar El Aïn\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1355",
                "wilaya_id": "40",
                "dayra": "Bouharoun\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1356",
                "wilaya_id": "40",
                "dayra": "Sidi Ghiles\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1357",
                "wilaya_id": "40",
                "dayra": "Messelmoun\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1358",
                "wilaya_id": "40",
                "dayra": "Sidi Rached\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1359",
                "wilaya_id": "40",
                "dayra": "Koléa\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1360",
                "wilaya_id": "40",
                "dayra": "Attatba\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1361",
                "wilaya_id": "40",
                "dayra": "Sidi Semiane\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1362",
                "wilaya_id": "40",
                "dayra": "Beni Milleuk\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1363",
                "wilaya_id": "40",
                "dayra": "Hadjeret Ennous\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1364",
                "wilaya_id": "41",
                "dayra": "Ahmed Rachedi\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1365",
                "wilaya_id": "41",
                "dayra": "Aïn Beida Harriche\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1366",
                "wilaya_id": "41",
                "dayra": "Aïn Mellouk\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1367",
                "wilaya_id": "41",
                "dayra": "Aïn Tine\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1368",
                "wilaya_id": "41",
                "dayra": "Amira Arrès\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1369",
                "wilaya_id": "41",
                "dayra": "Benyahia Abderrahmane\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1370",
                "wilaya_id": "41",
                "dayra": "Bouhatem\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1371",
                "wilaya_id": "41",
                "dayra": "Chelghoum Laid\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1372",
                "wilaya_id": "41",
                "dayra": "Chigara\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1373",
                "wilaya_id": "41",
                "dayra": "Derradji Bousselah\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1374",
                "wilaya_id": "41",
                "dayra": "El Mechira\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1375",
                "wilaya_id": "41",
                "dayra": "Elayadi Barbes\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1376",
                "wilaya_id": "41",
                "dayra": "Ferdjioua\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1377",
                "wilaya_id": "41",
                "dayra": "Grarem Gouga\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1378",
                "wilaya_id": "41",
                "dayra": "Hamala\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1379",
                "wilaya_id": "41",
                "dayra": "Mila\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1380",
                "wilaya_id": "41",
                "dayra": "Minar Zarza\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1381",
                "wilaya_id": "41",
                "dayra": "Oued Athmania\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1382",
                "wilaya_id": "41",
                "dayra": "Oued Endja\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1383",
                "wilaya_id": "41",
                "dayra": "Oued Seguen\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1384",
                "wilaya_id": "41",
                "dayra": "Ouled Khalouf\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1385",
                "wilaya_id": "41",
                "dayra": "Rouached\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1386",
                "wilaya_id": "41",
                "dayra": "Sidi Khelifa\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1387",
                "wilaya_id": "41",
                "dayra": "Sidi Merouane\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1388",
                "wilaya_id": "41",
                "dayra": "Tadjenanet\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1389",
                "wilaya_id": "41",
                "dayra": "Tassadane Haddada\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1390",
                "wilaya_id": "41",
                "dayra": "Teleghma\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1391",
                "wilaya_id": "41",
                "dayra": "Terrai Bainen\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1392",
                "wilaya_id": "41",
                "dayra": "Tessala Lemtaï\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1393",
                "wilaya_id": "41",
                "dayra": "Tiberguent\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1394",
                "wilaya_id": "41",
                "dayra": "Yahia Beni Guecha\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1395",
                "wilaya_id": "41",
                "dayra": "Zeghaia\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1396",
                "wilaya_id": "42",
                "dayra": "Aïn Bouyahia\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1397",
                "wilaya_id": "42",
                "dayra": "Aïn Defla\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1398",
                "wilaya_id": "42",
                "dayra": "Aïn Lechiekh\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1399",
                "wilaya_id": "42",
                "dayra": "Aïn Soltane\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1400",
                "wilaya_id": "42",
                "dayra": "Aïn Torki\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1401",
                "wilaya_id": "42",
                "dayra": "Arib\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1402",
                "wilaya_id": "42",
                "dayra": "Bathia\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1403",
                "wilaya_id": "42",
                "dayra": "Belaas\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1404",
                "wilaya_id": "42",
                "dayra": "Ben Allal\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1405",
                "wilaya_id": "42",
                "dayra": "Birbouche\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1406",
                "wilaya_id": "42",
                "dayra": "Bir Ould Khelifa\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1407",
                "wilaya_id": "42",
                "dayra": "Bordj Emir Khaled\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1408",
                "wilaya_id": "42",
                "dayra": "Boumedfaa\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1409",
                "wilaya_id": "42",
                "dayra": "Bourached\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1410",
                "wilaya_id": "42",
                "dayra": "Djelida\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1411",
                "wilaya_id": "42",
                "dayra": "Djemaa Ouled Cheikh\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1412",
                "wilaya_id": "42",
                "dayra": "Djendel\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1413",
                "wilaya_id": "42",
                "dayra": "El Abadia\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1414",
                "wilaya_id": "42",
                "dayra": "El Amra\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1415",
                "wilaya_id": "42",
                "dayra": "El Attaf\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1416",
                "wilaya_id": "42",
                "dayra": "El Hassania\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1417",
                "wilaya_id": "42",
                "dayra": "El Maine\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1418",
                "wilaya_id": "42",
                "dayra": "Hammam Righa\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1419",
                "wilaya_id": "42",
                "dayra": "Hoceinia\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1420",
                "wilaya_id": "42",
                "dayra": "Khemis Miliana\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1421",
                "wilaya_id": "42",
                "dayra": "Mekhatria\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1422",
                "wilaya_id": "42",
                "dayra": "Miliana\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1423",
                "wilaya_id": "42",
                "dayra": "Oued Chorfa\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1424",
                "wilaya_id": "42",
                "dayra": "Oued Djemaa\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1425",
                "wilaya_id": "42",
                "dayra": "Rouina\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1426",
                "wilaya_id": "42",
                "dayra": "Sidi Lakhdar\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1427",
                "wilaya_id": "42",
                "dayra": "Tacheta Zougagha\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1428",
                "wilaya_id": "42",
                "dayra": "Tarik Ibn Ziad\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1429",
                "wilaya_id": "42",
                "dayra": "Tiberkanine\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1430",
                "wilaya_id": "42",
                "dayra": "Zeddine\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1431",
                "wilaya_id": "43",
                "dayra": "Naâma\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1432",
                "wilaya_id": "43",
                "dayra": "Mecheria\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1433",
                "wilaya_id": "43",
                "dayra": "Aïn Sefra\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1434",
                "wilaya_id": "43",
                "dayra": "Tiout\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1435",
                "wilaya_id": "43",
                "dayra": "Sfissifa\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1436",
                "wilaya_id": "43",
                "dayra": "Moghrar\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1437",
                "wilaya_id": "43",
                "dayra": "Assela\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1438",
                "wilaya_id": "43",
                "dayra": "Djeniene Bourezg\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1439",
                "wilaya_id": "43",
                "dayra": "Aïn Ben Khelil\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1440",
                "wilaya_id": "43",
                "dayra": "Makman Ben Amer\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1441",
                "wilaya_id": "43",
                "dayra": "Kasdir\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1442",
                "wilaya_id": "43",
                "dayra": "El Biod\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1443",
                "wilaya_id": "44",
                "dayra": "Aghlal\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1444",
                "wilaya_id": "44",
                "dayra": "Aïn El Arbaa\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1445",
                "wilaya_id": "44",
                "dayra": "Aïn Kihal\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1446",
                "wilaya_id": "44",
                "dayra": "Aïn Témouchent\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1447",
                "wilaya_id": "44",
                "dayra": "Aïn Tolba\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1448",
                "wilaya_id": "44",
                "dayra": "Aoubellil\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1449",
                "wilaya_id": "44",
                "dayra": "Beni Saf\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1450",
                "wilaya_id": "44",
                "dayra": "Bouzedjar\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1451",
                "wilaya_id": "44",
                "dayra": "Chaabat El Leham\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1452",
                "wilaya_id": "44",
                "dayra": "Chentouf\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1453",
                "wilaya_id": "44",
                "dayra": "El Amria\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1454",
                "wilaya_id": "44",
                "dayra": "El Emir Abdelkader\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1455",
                "wilaya_id": "44",
                "dayra": "El Malah\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1456",
                "wilaya_id": "44",
                "dayra": "El Messaid\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1457",
                "wilaya_id": "44",
                "dayra": "Hammam Bouhadjar\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1458",
                "wilaya_id": "44",
                "dayra": "Hassasna\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1459",
                "wilaya_id": "44",
                "dayra": "Hassi El Ghella\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1460",
                "wilaya_id": "44",
                "dayra": "Oued Berkeche\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1461",
                "wilaya_id": "44",
                "dayra": "Oued Sabah\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1462",
                "wilaya_id": "44",
                "dayra": "Ouled Boudjemaa\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1463",
                "wilaya_id": "44",
                "dayra": "Ouled Kihal\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1464",
                "wilaya_id": "44",
                "dayra": "Oulhaça El Gheraba\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1465",
                "wilaya_id": "44",
                "dayra": "Sidi Ben Adda\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1466",
                "wilaya_id": "44",
                "dayra": "Sidi Boumedienne\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1467",
                "wilaya_id": "44",
                "dayra": "Sidi Ouriache\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1468",
                "wilaya_id": "44",
                "dayra": "Sidi Safi\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1469",
                "wilaya_id": "44",
                "dayra": "Tamzoura\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1470",
                "wilaya_id": "44",
                "dayra": "Terga\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1471",
                "wilaya_id": "45",
                "dayra": "Berriane\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1472",
                "wilaya_id": "45",
                "dayra": "Bounoura\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1473",
                "wilaya_id": "45",
                "dayra": "Dhayet Bendhahoua\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1474",
                "wilaya_id": "45",
                "dayra": "El Atteuf\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1475",
                "wilaya_id": "45",
                "dayra": "El Guerrara\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1476",
                "wilaya_id": "45",
                "dayra": "Ghardaïa\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1477",
                "wilaya_id": "45",
                "dayra": "Mansoura\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1478",
                "wilaya_id": "45",
                "dayra": "Metlili\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1479",
                "wilaya_id": "45",
                "dayra": "Sebseb\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1480",
                "wilaya_id": "45",
                "dayra": "Zelfana\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1481",
                "wilaya_id": "46",
                "dayra": "Aïn Rahma\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1482",
                "wilaya_id": "46",
                "dayra": "Aïn Tarek\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1483",
                "wilaya_id": "46",
                "dayra": "Ammi Moussa\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1484",
                "wilaya_id": "46",
                "dayra": "Belassel Bouzegza\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1485",
                "wilaya_id": "46",
                "dayra": "Bendaoud\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1486",
                "wilaya_id": "46",
                "dayra": "Beni Dergoun\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1487",
                "wilaya_id": "46",
                "dayra": "Beni Zentis\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1488",
                "wilaya_id": "46",
                "dayra": "Dar Ben Abdellah\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1489",
                "wilaya_id": "46",
                "dayra": "Djidioua\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1490",
                "wilaya_id": "46",
                "dayra": "El Guettar\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1491",
                "wilaya_id": "46",
                "dayra": "El Hamadna\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1492",
                "wilaya_id": "46",
                "dayra": "El Hassi\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1493",
                "wilaya_id": "46",
                "dayra": "El Matmar\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1494",
                "wilaya_id": "46",
                "dayra": "El Ouldja\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1495",
                "wilaya_id": "46",
                "dayra": "Had Echkalla\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1496",
                "wilaya_id": "46",
                "dayra": "Hamri\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1497",
                "wilaya_id": "46",
                "dayra": "Kalaa\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1498",
                "wilaya_id": "46",
                "dayra": "Lahlef\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1499",
                "wilaya_id": "46",
                "dayra": "Mazouna\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1500",
                "wilaya_id": "46",
                "dayra": "Mediouna\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1501",
                "wilaya_id": "46",
                "dayra": "Mendes\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1502",
                "wilaya_id": "46",
                "dayra": "Merdja Sidi Abed\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1503",
                "wilaya_id": "46",
                "dayra": "Ouarizane\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1504",
                "wilaya_id": "46",
                "dayra": "Oued Essalem\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1505",
                "wilaya_id": "46",
                "dayra": "Oued Rhiou\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1506",
                "wilaya_id": "46",
                "dayra": "Ouled Aiche\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1507",
                "wilaya_id": "46",
                "dayra": "Oued El Djemaa\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1508",
                "wilaya_id": "46",
                "dayra": "Ouled Sidi Mihoub\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1509",
                "wilaya_id": "46",
                "dayra": "Ramka\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1510",
                "wilaya_id": "46",
                "dayra": "Relizane\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1511",
                "wilaya_id": "46",
                "dayra": "Sidi Khettab\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1512",
                "wilaya_id": "46",
                "dayra": "Sidi Lazreg\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1513",
                "wilaya_id": "46",
                "dayra": "Sidi M'Hamed Ben Ali\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1514",
                "wilaya_id": "46",
                "dayra": "Sidi M'Hamed Benaouda\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1515",
                "wilaya_id": "46",
                "dayra": "Sidi Saada\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1516",
                "wilaya_id": "46",
                "dayra": "Souk El Had\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1517",
                "wilaya_id": "46",
                "dayra": "Yellel\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1518",
                "wilaya_id": "46",
                "dayra": "Zemmora\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1519",
                "wilaya_id": "47",
                "dayra": "Tamanrasset\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1520",
                "wilaya_id": "47",
                "dayra": "Abalessa\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1521",
                "wilaya_id": "47",
                "dayra": "Idles\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1522",
                "wilaya_id": "47",
                "dayra": "Tazrouk\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1523",
                "wilaya_id": "47",
                "dayra": "In Amguel\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1524",
                "wilaya_id": "48",
                "dayra": "Illizi\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1525",
                "wilaya_id": "48",
                "dayra": "Debdeb\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1526",
                "wilaya_id": "48",
                "dayra": "Bordj Omar Driss\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1527",
                "wilaya_id": "48",
                "dayra": "In Amenas\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1528",
                "wilaya_id": "49",
                "dayra": "Oum el Assel\n",
                "status": "1",
                "created": null
            },
            {
                "id": "1529",
                "wilaya_id": "49",
                "dayra": "Tindouf\n",
                "status": "1",
                "created": null
            }
        ]



        $(document).ready(function() {


        $('.wilayas').on('change', function(x) {
            $('.dayras').find('option')
                .remove()
                .end()



            $('.dayras').append(`
                     <option value="-">-</option>
                `);
            dayras.map(dd => {


                if (dd.wilaya_id == this.value) {
                    
                    
                    $('.dayras').append(`
                     <option value="${dd.id}">${dd.dayra}</option>
                `);

                }


            })
        });
        });
    
    </script>
@endpush
