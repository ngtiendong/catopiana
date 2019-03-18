<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel">
        <div class="pull-left image">
            <img src="" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
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
            <p>{{$user->fullname}} ({{$user->username}})</p>
            <!-- Status -->
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
    </div>

    <!-- search form (Optional) -->
    <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="Tìm kiếm...">
            <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
        </div>
    </form>
    <!-- /.search form -->

    <!-- Sidebar Menu -->
    <ul class="sidebar-menu" data-widget="tree">
        <?php $userPermissions = \Illuminate\Support\Facades\Auth::user()->getListPermissions();?>
    @if (isset($backend_menus) && !empty($backend_menus))
        @php
            $currentRouteName = request()->route()->getName();
        @endphp
        @foreach($backend_menus as $menu)
            @if (isset($menu['sub']) && !empty($menu['sub']))
                <?php
                    $subHtml = '';
                    $active = false;
                    foreach ($menu['sub'] as $submenu) {
                        if (empty($submenu['permission']) || !empty(array_intersect($userPermissions, $submenu['permission']))) {
                            $class = '';
                            if ($currentRouteName == $submenu['route']) {
                                $class = 'active';
                                $active = true;
                            }

                            $subHtml .= '<li class="' . $class . '"><a href="' . route($submenu['route']) . '">' . trans($submenu['text']) . '</a></li>';
                        }
                    }
                ?>
                @if (empty($menu['permission']) || !empty(array_intersect($userPermissions, $menu['permission'])))
                    <li class="{{ $active ? 'active ' : '' }}{{ $menu['class'] }} @if (!empty($subHtml)) treeview @endif">
                        <a href="{{ isset($menu['route']) ? route($menu['route']) : '#' }}"><i class="{{ isset($menu['icon']) ? $menu['icon'] : '' }}"></i> <span>{{ isset($menu['text']) ? trans($menu['text']) : '' }}</span></a>
                        @if (!empty($subHtml))
                        <ul class="treeview-menu">
                            {!! $subHtml !!}
                        </ul>
                        @endif
                    </li>
                @endif
            @else
                @if (empty($menu['permission']) || !empty(array_intersect($userPermissions, $menu['permission'])))
                    <li class="@if(request()->route()->getName() == $menu['route'])active @endif{{ isset($menu['class']) ? $menu['class'] : '' }}">
                        <a href="{{ isset($menu['route']) ? route($menu['route']) : '#' }}"><i class="{{ isset($menu['icon']) ? $menu['icon'] : '' }}"></i> <span>{{ isset($menu['text']) ? trans($menu['text']) : '' }}</span></a>
                    </li>
                @endif
            @endif
        @endforeach
    @endif
    </ul>
    <!-- /.sidebar-menu -->
</section>
<!-- /.sidebar -->
