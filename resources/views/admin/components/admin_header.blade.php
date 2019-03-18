<!-- Logo -->
<a href="{{ route('admin_home') }}" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><b>{{env('APP_NAME_SMALL')}}</b></span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><b>{{env('APP_NAME')}}</b></span>
</a>

<!-- Header Navbar -->
<nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
    </a>
    <!-- Navbar Right Menu -->
    <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
            <!-- Messages: style can be found in dropdown.less-->

            <?php
            $user = auth()->user();
            $avatar = $user->avatar;
            if ($user->sex == 0) {
                $customerAvatar = asset('/img/icon_female.png');
            } else {
                $customerAvatar = asset('/img/icon_male.png');
            }
            if (!empty($avatar)) {
                $avatarArray = json_decode($avatar, true);
                $customerAvatar = $avatarArray['medium_url'];
            }
            ?>
            <!-- User Account Menu -->
            <li class="dropdown user user-menu">
                <!-- Menu Toggle Button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <!-- The user image in the navbar-->
                    <img src="{{$customerAvatar}}" class="user-image" alt="User Image">
                    <!-- hidden-xs hides the username on small devices so only the image appears. -->
                    <span class="hidden-xs">{{ $user->fullname }} ({{ $user->username }})</span>
                </a>
                <ul class="dropdown-menu">
                    <!-- The user image in the menu -->
                    <li class="user-header">
                        @if (auth()->user())
                        <span id="user_id" style="display: none;">{{$user->id}}</span>
                        <img src="{{ $customerAvatar }}" class="img-circle" id="change-avatar-user" alt="User Image">
                        <p>
                            {{ $user->email }}
                            <small>Tham gia {{ date('m/Y', strtotime($user->created_at)) }}</small>
                        </p>
                        @endif
                    </li>
                    <!-- Menu Footer-->
                    <li class="user-footer">
                        <div class="pull-left">
                            <a href="#" class="btn btn-default btn-flat" id="change-user-password">Thay đổi mật khẩu</a>
                        </div>
                        <div class="pull-right">
                            <a href="{{ route('admin_logout') }}" class="btn btn-default btn-flat">Thoát</a>
                        </div>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>

@if(\Illuminate\Support\Facades\Session::has('header_message'))
<div class="alert {{ \Illuminate\Support\Facades\Session::get('alert-class', 'alert-success') }} alert-dismissible auto-hide-alert">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4 class="text-center"><i class="icon fa fa-check"></i> {{ \Illuminate\Support\Facades\Session::get('header_message') }}</h4>
</div>
@endif
