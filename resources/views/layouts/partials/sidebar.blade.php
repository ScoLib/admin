<div id="sidebar" class="sidebar responsive ace-save-state sidebar-fixed display">

    <div class="sidebar-shortcuts" id="sidebar-shortcuts">
        <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
            <button class="btn btn-success">
                <i class="ace-icon fa fa-signal"></i>
            </button>

            <button class="btn btn-info">
                <i class="ace-icon fa fa-pencil"></i>
            </button>

            <!-- #section:basics/sidebar.layout.shortcuts -->
            <button class="btn btn-warning">
                <i class="ace-icon fa fa-users"></i>
            </button>

            <button class="btn btn-danger">
                <i class="ace-icon fa fa-cogs"></i>
            </button>

            <!-- /section:basics/sidebar.layout.shortcuts -->
        </div>

        <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
            <span class="btn btn-success"></span>

            <span class="btn btn-info"></span>

            <span class="btn btn-warning"></span>

            <span class="btn btn-danger"></span>
        </div>
    </div><!-- /.sidebar-shortcuts -->

    <ul class="nav nav-list">
        @foreach (request()->get('admin.menu') as $menu)
            @permission($menu->name)
            @if ($menu->child->isEmpty())
                <li class="{{ request()->get('currentMenuIds')->contains($menu->id) ? 'active' : '' }}">
                    <a href="{{ $menu->name == '#' ? '#' : route($menu->name) }}">
                        <i class="menu-icon fa {{ $menu->icon ?: 'fa-folder' }}"></i>
                        <span class="menu-text"> {{ $menu->display_name }} </span>
                    </a>

                    <b class="arrow"></b>
                </li>
            @else
                <li class="{{ request()->get('currentMenuIds')->contains($menu->id) ? 'active open' : '' }}">
                    <a href="{{ $menu->name == '#' ? '#' : route($menu->name) }}" class="dropdown-toggle">
                        <i class="menu-icon fa {{ $menu->icon ?: 'fa-folder' }}"></i>
                        <span class="menu-text"> {{ $menu->display_name }} </span>

                        <b class="arrow fa fa-angle-down"></b>
                    </a>

                    <b class="arrow"></b>
                    @include('admin::layouts.partials.submenu', ['childs' => $menu->child])
                </li>
            @endif
            @endpermission
        @endforeach
    </ul><!-- /.nav-list -->

    <!-- #section:basics/sidebar.layout.minimize -->
    <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
        <i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
    </div>

    <!-- /section:basics/sidebar.layout.minimize -->
</div>