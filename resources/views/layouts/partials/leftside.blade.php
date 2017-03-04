<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
    {{--<div class="user-panel">
        <div class="pull-left image">
            <img src="../../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
            <p>Alexander Pierce</p>
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
    </div>--}}
    <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i
                            class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            @foreach (request()->get('admin.menu') as $menu)
                @permission($menu->name)
                @if ($menu->child->isEmpty())
                    <li class="{{ request()->get('currentMenuIds')->contains($menu->id) ? 'active' : '' }}">
                        <a href="{{ $menu->name == '#' ? '#' : route($menu->name) }}">
                            <i class="fa {{ $menu->icon ?: 'fa-folder' }}"></i>
                            <span>{{ $menu->display_name }}</span>
                        </a>
                    </li>
                @else
                    <li class="treeview {{ request()->get('currentMenuIds')->contains($menu->id) ? 'active' : '' }}">
                        <a href="{{ $menu->name == '#' ? '#' : route($menu->name) }}">
                            <i class="fa {{ $menu->icon ?: 'fa-folder' }}"></i>
                            <span>{{ $menu->display_name }}</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        @include('admin::layouts.partials.leftmenuchild', ['childs' => $menu->child])
                    </li>
                @endif
                @endpermission
            @endforeach
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>