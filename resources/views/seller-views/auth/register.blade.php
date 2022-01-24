@extends('layouts.front-end.app')

@section('title', 'Seller Apply')

@push('css_or_js')
    <link href="{{ asset('public/assets/back-end') }}/css/select2.min.css" rel="stylesheet" />
    <link href="{{ asset('public/assets/back-end/css/croppie.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Custom styles for this page -->

    <style>
        .black {
            color: black;
        }

        .main-card {
            padding: 3rem;
        }

        @media(max-width:800px) {
            .main-card {
                padding: 0 !important;
            }
        }

        @media(max-width:375px) {
            #image-modal .modal-content {
                width: 367px !important;
                margin-left: 0 !important;
            }

            #logo-modal .modal-content {
                width: 367px !important;
                margin-left: 0 !important;
            }

            #popup-banner-image-modal .modal-content {
                width: 367px !important;
                margin-left: 0 !important;
            }

            .main-card {
                padding: 0 !important;
            }

        }

        @media(max-width:500px) {
            #image-modal .modal-content {
                width: 400px !important;
                margin-left: 0 !important;
            }

            #logo-modal .modal-content {
                width: 400px !important;
                margin-left: 0 !important;
            }

            #popup-banner-image-modal .modal-content {
                width: 400px !important;
                margin-left: 0 !important;
            }

            .main-card {
                padding: 0 !important;
            }


        }
        }

    </style>

@endpush


@section('content')

    <div class="container main-card">

        <div class="card o-hidden border-0 shadow-lg my-4">
            <div class="card-body ">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="p-5">
                            <div class="text-center mb-2 ">
                                <h3 class=""> {{ trans('messages.Shop_application') }}
                                </h3>
                                <hr>
                            </div>
                            <form class="user" action="{{ route('shop.apply') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf

                                <h5 class="black">{{ trans('messages.Shop_name') }}</h5>
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-12 mb-sm-0 ">
                                        <input type="text" class="form-control form-control-user" id="shop_name"
                                            name="shop_name" placeholder="{{ trans('messages.Shop') }}" value="{{ old('shop_name') }}"
                                            required>
                                    </div>
                                    <div class="col-sm-6" hidden>
                                        <textarea name="shop_address" class="form-control" id="shop_address" rows="1"
                                            placeholder="shop address" value="NULL">{{ old('shop_address') }}</textarea>
                                    </div>
                                </div>

                                <h5 class="black">{{ trans('messages.rules') }}</h5>

                                <div class="figure-pre-class text-right" style="overflow: scroll; height: 600px; font-weight: bold;" dir="rtl">

                                    شروط استعمال متجر WORKETPLACE    <br>

الموضوع: <br>
الغرض من هذه الشروط العامة هو تحديد شروط وأحكام استعمال متجر Worketplace, البائع المستقل لـ worketplace (فيما يلفظ: «البائع المستقل»)، موقع أو تطبيق worketplace (فيما يلفظ: «المتجر») وتحديد حقوق الأطراف والالتزامات في هذا الإطار.
هذه الشروط متوفرة في المتجر ويمكن طبعها في أي وقت.
يمكن تعديل هذه الشروط أو تكملتها، ويتوصل البائع المستقل بإشعار التعديل على المتجر.
<br>
قبول الشروط العامة:<br>
قبول شروط الاستعمال يتجسد بالضغط على عبارة «قبول» في استمارة التسجيل على المتجر وهذا القبول يجب أن يكون على جميع شروط الاستعمال الحالية.
<br>
طريقة العمل:<br>
بدأت رحلتنا من منطلق توفير رفاهية التسوق المنزلي بأفضل المنتجات، و ليستمتع الزبون ببساطة التسوق المنزلي من خلال طلب احتياجاته المنزلية من خلال التسوق على الإنترنت، سواء كانت منتجات مادية أم رقمية, مما أدى إلى توليد العديد من فرص العمل للراغبين في كسب الكثير من المال.
يتيح متجر Worketplace لمستخدميه فرصة العمل كبائع مستقل للشركة سواء كان في عمله أو بيته أو أي مكان، من خلال جلب فرص شراء للزبائن.
طريقة العمل سهلة وواضحة، عند الولوج لمتجر Worketplace في الواجهة الامامية نجد المنتجات المتوفرة بهدف ببيعها، يقوم البائع المستقل بنشرها في وسائل التواصل الاجتماعي أو أي مكان يريد، عند جلب فرص شراء لزبائن محتملين لمنتج ما, يقوم بطلب شراء ذلك المنتج على المتجر بعدها نتولى الباقي من تأكيد وارسال المنتج بأعلى جودة وتحصيل ثمن المنتج, يربح البائع المستقل عمولة مقابل اي عملية بيع منتج ناجحة, فكل ما يحتاجه الزبون في مكان واحد وبأسعار جيدة.
لكن قبل أن نبدأ بالحديث مباشرة عن المزايا الخمسة التي يقدمها لك Worketplace، دعنا نعرف معنى العمل كبائع مستقل أو كيف تبدأ عملياً بهذا المجال.
برنامج التسويق بالعمولة هو نظام يجمع بين مصانع او محلات بالجملة وبين اشخاص يعتبرون بائعين مستقلين من خلال وجود منصة رقمية (متجر worketplace) لاستضافة المنتجات، وكذلك يشترك فيها الأشخاص المهتمون جلب فرص ببيع لهذه المنتجات وربح عمولة ممتازة.
عندها يبدأ البائع المستقل بالترويج والتسويق لهذا المنتَج المحدد عبر قنواته التسويقية ووسائل التواصل الاجتماعي، منها الموقع الخاص به، أو الفيسبوك، استفرام، تويتر، أو حتى من خلال الاعتماد فقط على متجر ماركت بلايس في الفايسبوك, يقوم الزبائن بطلبات الشراء، يحصل هذا الأخير على عمولة حسب المنتِج و الكمية وهكذا يكسب الكثير المال.
<br>
عند الانضمام لفريق البائع المستقل Worketplace سوف تتمتع بما يلي:<br>
-  أولا يمكنك الاشتراك به مجاناً.<br>
- كل يوم تضاف منتجات جديدة ومتنوعة للمتجر مما يعني ربح غير محدود.<br>
- التحكم الكامل في وقت العمل وفي مكان العمل ايضا.<br>
- منصة رقمية مزودة بالحماية والتحكم اللازمين لضمان كل معلومات المستخدمين وحساباتهم.<br>
- تتمتع بالدعم والمساعدة خلال 24 ساعة.<br>

الأرباح:<br>
طريقة حساب الأرباح واضحة، عند طلب منتج لزبونك يجب ملئ كل المعلومات اللازمة وعمولة الربح تضاف الى محفظة الأرباح فور وصول المنتج للزبون بنجاح, كل منتج لديه عمولته الخاصة, وتبدأ من 250 دج, وحبذا التأكيد مع الزبون هاتفيا لتأكيد طلب شراء المنتج و تفادي رجوع المنتج.
يجوز للشركة مراجعة الاسعار في اي وقت وحسب تقديرها، وسيبلغ البائع بهذه التغيرات بإشعار في المتجر بعدها تصبح التعديلات الجديدة مطبقة وغير قابلة للتفاوض، اذا لم يقبل البائع تغييرات الاسعار الجديدة يجب عليه انهاء الخدمة، والا فانه يعتبر قد قبل التعديلات الجديدة.
يستلم البائع أرباحه عن طريق طلب الدفع في التطبيق عند مجموع عمولة على الأقل 2000 دج و ترسل الأرباح الى الحساب الجاري CCP الخاص بالبائع.
تتم عملية الدفع يوم الثلاثاء صباحا من كل أسبوع.
<br>
التسجيل في المتجر:<br>
إن استعمال الخدمة يستوجب من المستخدم أن يسجل في متجرworketplace عن طريق ملأ استمارة معلومات موضوعة لهذا الغرض.
<br>
التحفيزات والمخالفات:<br>
الشركة تقدم عدة تحفيزات أهمها الحصول على منتج مجاني من منتجات الشركة عند تخطي قيمة 20000 دج، دون فقدان أرباحك الخاصة بك.
يتم تجميد حساب البائع اوتوماتيكيا عند عدم جلب اي طلبية لمدة 6 أشهر.
تتعهد شركة Worketplace من جهة والبائع من جهة أخرى باحترام محتوى هذه الشروط، وألا تنتهك الآداب العامة، وأي شكوى تقدم عن طريق المتجر والاجابة تقدم في أجل أقصاه 48 ساعة.
                                </div>

                                {{-- <div class="">
                                <div class="pb-1">
                                    <center>
                                        <img style="width: auto;border: 1px solid; border-radius: 10px; max-height:200px;" id="viewerLogo"
                                            src="{{asset('public\assets\back-end\img\400x400\img2.jpg')}}" alt="banner image"/>
                                    </center>
                                </div>

                                <div class="form-group">
                                    <div class="custom-file">
                                        <input type="file" name="logo" id="LogoUpload" class="custom-file-input"
                                            accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                        <label class="custom-file-label" for="LogoUpload">{{trans('messages.Upload')}} {{trans('messages.logo')}}</label>
                                    </div>
                                </div>
                            </div> --}}
                                {{-- <div class="">
                                <div class="pb-1">
                                    <center>
                                        <img style="width: auto;border: 1px solid; border-radius: 10px; max-height:200px;" id="viewerBanner"
                                             src="{{asset('public\assets\back-end\img\400x400\img2.jpg')}}" alt="banner image"/>
                                    </center>
                                </div>

                                <div class="form-group">
                                    <div class="custom-file">
                                        <input type="file" name="banner" id="BannerUpload" class="custom-file-input"
                                               accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" style="overflow: hidden; padding: 2%">
                                        <label class="custom-file-label" for="BannerUpload">{{trans('messages.Upload')}} {{trans('messages.Banner')}}</label>
                                    </div>
                                </div>
                            </div> --}}

                            <div class="form-group mb-1">
                                <strong>
                                    <input type="checkbox" class="mr-1"
                                           name="remember" id="inputCheckd">
                                </strong>
                                <label class="" for="remember">{{trans('messages.i_agree_to_Your_terms')}}<a
                                        class="font-size-sm" target="_blank" href="{{route('terms')}}">
                                        {{trans('messages.terms_and_condition')}}
                                    </a></label>
                            </div>

            
                                <button type="submit" class="btn btn-primary btn-user btn-block"
                                    id="apply">{{ trans('messages.Become_seller_worketplace') }} </button>
                            </form>
                            <hr>
                            {{-- <div class="text-center">
                            <a class="small"  href="{{route('seller.auth.login')}}">Already have an account? Login!</a>
                        </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('shared-partials.image-process._image-crop-modal',['modal_id'=>'image-modal'])
    @include('shared-partials.image-process._image-crop-modal',['modal_id'=>'logo-modal'])
@endsection
@push('script')


    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('public/assets/back-end') }}/vendor/jquery/jquery.min.js"></script>
    <script src="{{ asset('public/assets/back-end') }}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('public/assets/back-end') }}/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('public/assets/back-end') }}/js/sb-admin-2.min.js"></script>

    {{-- Toastr --}}
    <script src={{ asset('public/assets/back-end/js/toastr.js') }}></script>
    {!! Toastr::message() !!}

    @if ($errors->any())
        <script>
            @foreach ($errors->all() as $error)
                toastr.error('{{ $error }}', Error, {
                CloseButton: true,
                ProgressBar: true
                });
            @endforeach
        </script>
    @endif
    <script>
        $('#exampleInputPassword ,#exampleRepeatPassword').on('keyup', function() {
            var pass = $("#exampleInputPassword").val();
            var passRepeat = $("#exampleRepeatPassword").val();
            if (pass == passRepeat) {
                $('.pass').hide();
            } else {
                $('.pass').show();
            }
        });
        $('#apply').on('click', function() {

            var image = $("#image-set").val();
            if (image == "") {
                $('.image').show();
                return false;
            }
            var pass = $("#exampleInputPassword").val();
            var passRepeat = $("#exampleRepeatPassword").val();
            if (pass != passRepeat) {
                $('.pass').show();
                return false;
            }


        });

        function Validate(file) {
            var x;
            var le = file.length;
            var poin = file.lastIndexOf(".");
            var accu1 = file.substring(poin, le);
            var accu = accu1.toLowerCase();
            if ((accu != '.png') && (accu != '.jpg') && (accu != '.jpeg')) {
                x = 1;
                return x;
            } else {
                x = 0;
                return x;
            }
        }

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#viewer').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileUpload").change(function() {
            readURL(this);
        });

        function readlogoURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#viewerLogo').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        function readBannerURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#viewerBanner').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#LogoUpload").change(function() {
            readlogoURL(this);
        });
        $("#BannerUpload").change(function() {
            readBannerURL(this);
        });
    </script>

    @include('shared-partials.image-process._script',[
    'id'=>'image-modal',
    'height'=>200,
    'width'=>200,
    'multi_image'=>false,
    'route'=>route('image-upload')
    ])

    @include('shared-partials.image-process._script',[
    'id'=>'logo-modal',
    'height'=>200,
    'width'=>200,
    'multi_image'=>false,
    'route'=>route('image-upload')
    ])



@endpush
