<div id="headerMain" class="d-none">
    <header id="header" style="background-color: #F7F8FA"
        class="navbar navbar-expand-lg navbar-fixed navbar-height navbar-flush navbar-container navbar-bordered">
        <div class="navbar-nav-wrap">
            <div class="navbar-brand-wrapper">
                <!-- Logo -->
                @php($e_commerce_logo = \App\Model\BusinessSetting::where(['type' => 'company_web_logo'])->first()->value)
                <a class="navbar-brand" href="{{ route('admin.dashboard.index') }}" aria-label="">
                    <img class="navbar-brand-logo" style="max-height: 42px;"
                        onerror="this.src='{{ asset('public/assets/front-end/img/image-place-holder.png') }}'"
                        src="{{ asset("storage/app/public/company/$e_commerce_logo") }}" alt="Logo">
                    <img class="navbar-brand-logo-mini" style="max-height: 42px;"
                        onerror="this.src='{{ asset('public/assets/front-end/img/image-place-holder.png') }}'"
                        src="{{ asset("storage/app/public/company/$e_commerce_logo") }}" alt="Logo">

                </a>
                <!-- End Logo -->
            </div>

            <div class="navbar-nav-wrap-content-left">
                <!-- Navbar Vertical Toggle -->
                <button type="button" class="js-navbar-vertical-aside-toggle-invoker close mr-3">
                    <i class="tio-first-page navbar-vertical-aside-toggle-short-align" data-toggle="tooltip"
                        data-placement="right" title="Collapse"></i>
                    <i class="tio-last-page navbar-vertical-aside-toggle-full-align"
                        data-template='<div class="tooltip d-none d-sm-block" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
                        data-toggle="tooltip" data-placement="right" title="Expand"></i>
                </button>
                <!-- End Navbar Vertical Toggle -->
                <div class="d-none d-md-block">
                    <form class="position-relative">
                        <!-- Input Group -->
                        <div
                            class="input-group input-group-merge input-group-borderless input-group-hover-light navbar-input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="tio-search"></i>
                                </div>
                            </div>
                            <input type="search" class="js-form-search form-control" id="search-bar-input"
                                placeholder="Search" aria-label="Search in front" data-hs-form-search-options="{
                                 &quot;clearIcon&quot;: &quot;#clearSearchResultsIcon&quot;,
                                 &quot;dropMenuElement&quot;: &quot;#searchDropdownMenu&quot;,
                                 &quot;dropMenuOffset&quot;: 20,
                                 &quot;toggleIconOnFocus&quot;: true,
                                 &quot;activeClass&quot;: &quot;focus&quot;
                               }">
                            <div class='mr-2'></div>
                            <a href='https://worketplace.com/admin/orders/list/all' class="btn btn-primary mr-2"><i
                                    class="tio-shopping-cart-outlined nav-icon"></i></a>
                            <a href='https://worketplace.com/admin/product/list/in_house' class="btn btn-info mr-2"><i
                                    class="tio-airdrop nav-icon"></i></a>
                            <a href='https://worketplace.com/admin/sellers/withdraw_list'
                                class="btn btn-success mr-2"><i class="tio-atm-outlined nav-icon"></i></a>
                            <a href='https://worketplace.com/admin/business-settings/language'
                                class="btn btn-warning mr-2"><i class="tio-book-opened nav-icon"></i></a>
                            <a href='https://worketplace.com/admin/customer/seller' class="btn btn-danger mr-2"><i
                                    class="tio-users-switch nav-icon"></i></a>
                            <a href='https://worketplace.com/admin/customer/list' class="btn btn-secondary mr-2"><i
                                    class="tio-poi-user nav-icon"></i></a>

                            <div class="input-group">
                                <diV class="card" id="search-card"
                                    style="position: absolute;background: white;z-index: 999;width: 100%;display: none">
                                    <div class="card-body" id="search-result-box"
                                        style="overflow:scroll; height:400px;overflow-x: hidden">

                                    </div>
                                </diV>
                            </div>
                        </div>
                        <!-- End Input Group -->


                        <!-- End Card Search Content -->
                    </form>
                </div>
            </div>



            <!-- Secondary Content -->
            <div class="navbar-nav-wrap-content-right">
                <!-- Navbar -->
                <ul class="navbar-nav align-items-center flex-row">

                    <li class="nav-item d-none d-sm-inline-block">
                        <div class="hs-unfold">
                            <a title="Website home"
                                class="js-hs-unfold-invoker btn btn-icon btn-ghost-secondary rounded-circle"
                                href="{{ route('home') }}" target="_blank">
                                <i class="tio-globe"></i>
                                {{-- <span class="btn-status btn-sm-status btn-status-danger"></span> --}}
                            </a>
                        </div>
                    </li>

                    <li class="nav-item d-none d-sm-inline-block">
                        <!-- Example single danger button -->
                        <div class="btn-group">
                            <button type="button" class="btn btn-danger " data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="tio-notifications-alert nav-icon"></i>
                            </button>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated dropdown-menu-lg py-0 "
                                    style="width: 300px; right: -100px;"
                                    x-placement="top-end">
                                    <div class="p-3 bg-light border-bottom">
                                        <h6 class="mb-0">Notifications</h6>
                                    </div>
                                    <div class="px-3 c-scrollbar-light overflow-auto " style="max-height:300px;">
                                        <?php  $notif = DB::table('notifications_jdidas')->where('forwho', 'admin')->get(); ?>
                                        <ul class="list-group list-group-flush">
                                            @foreach($notif as $key=>$not)
                                            
                                            <li
                                                class="list-group-item d-flex justify-content-between align-items- py-3">
                                                <div class="media text-inherit">
                                                    <div class="media-body">
                                                        <p class="mb-1 text-truncate-2">
                                                            {{$not->type}}: {{$not->num}} {{$not->message}}
                                                        </p>
                                                        <small class="text-muted">
                                                            {{$not->created_at}}
                                                        </small>
                                                    </div>
                                                </div>
                                            </li>
                                        

                                            @endforeach
                                          
                                        </ul>
                                    </div>
                                    <div class="text-center border-top">
                                        <a href="/admin/notification/list"
                                            class="text-reset d-block py-2">
                                            View All Notifications
                                        </a>
                                    </div>
                            </div>
                        </div>
                    </li>

                    <li class="nav-item d-none d-sm-inline-block">
                        <!-- Notification -->
                        <div class="hs-unfold">
                            <a class="js-hs-unfold-invoker btn btn-icon btn-ghost-secondary rounded-circle"
                                href="{{ route('admin.contact.list') }}">
                                <i class="tio-email"></i>
                                @php($message = \App\Model\Contact::where('seen', 0)->count())
                                @if ($message != 0)
                                    <span class="btn-status btn-status btn-status-danger">{{ $message }}</span>
                                @endif
                            </a>
                        </div>
                        <!-- End Notification -->
                    </li>

                    <li class="nav-item d-none d-sm-inline-block">
                        <!-- Notification -->
                        <div class="hs-unfold">
                            <a class="js-hs-unfold-invoker btn btn-icon btn-ghost-secondary rounded-circle"
                                href="{{ route('admin.orders.list', ['status' => 'pending']) }}">
                                <i class="tio-shopping-cart-outlined"></i>
                                {{-- <span class="btn-status btn-sm-status btn-status-danger"></span> --}}
                            </a>
                        </div>
                        <!-- End Notification -->
                    </li>


                    <li class="nav-item">
                        <!-- Account -->
                        <div class="hs-unfold">
                            <a class="js-hs-unfold-invoker navbar-dropdown-account-wrapper" href="javascript:;"
                                data-hs-unfold-options='{
                                     "target": "#accountNavbarDropdown",
                                     "type": "css-animation"
                                   }'>
                                <div class="avatar avatar-sm avatar-circle">
                                    <img class="avatar-img"
                                        onerror="this.src='{{ asset('public/assets/front-end/img/image-place-holder.png') }}'"
                                        src="{{ asset('storage/app/public/admin') }}/{{ auth('admin')->user()->image }}"
                                        alt="Image Description">
                                    <span class="avatar-status avatar-sm-status avatar-status-success"></span>
                                </div>
                            </a>

                            <div id="accountNavbarDropdown"
                                class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right navbar-dropdown-menu navbar-dropdown-account"
                                style="width: 16rem;">
                                <div class="dropdown-item-text">
                                    <div class="media align-items-center">
                                        <div class="avatar avatar-sm avatar-circle mr-2">
                                            <img class="avatar-img"
                                                onerror="this.src='{{ asset('public/assets/front-end/img/image-place-holder.png') }}'"
                                                src="{{ asset('storage/app/public/admin') }}/{{ auth('admin')->user()->image }}"
                                                alt="Image Description">
                                        </div>
                                        <div class="media-body">
                                            <span class="card-title h5">{{ auth('admin')->user()->f_name }}</span>
                                            <span class="card-text">{{ auth('admin')->user()->email }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="dropdown-divider"></div>

                                <a class="dropdown-item"
                                    href="{{ route('admin.profile.update', auth('admin')->user()->id) }}">
                                    <span class="text-truncate pr-2" title="Settings">Settings</span>
                                </a>

                                <div class="dropdown-divider"></div>

                                <a class="dropdown-item" href="javascript:" onclick="Swal.fire({
                                    title: 'Do you want to logout?',
                                    showDenyButton: true,
                                    showCancelButton: true,
                                    confirmButtonColor: '#377dff',
                                    cancelButtonColor: '#363636',
                                    confirmButtonText: `Yes`,
                                    denyButtonText: `Don't Logout`,
                                    }).then((result) => {
                                    if (result.value) {
                                    location.href='{{ route('admin.auth.logout') }}';
                                    } else{
                                    Swal.fire('Canceled', '', 'info')
                                    }
                                    })">
                                    <span class="text-truncate pr-2" title="Sign out">Sign out</span>
                                </a>
                            </div>
                        </div>
                        <!-- End Account -->
                    </li>
                </ul>
                <!-- End Navbar -->
            </div>
            <!-- End Secondary Content -->
        </div>
    </header>
</div>
<div id="headerFluid" class="d-none"></div>
<div id="headerDouble" class="d-none"></div>
