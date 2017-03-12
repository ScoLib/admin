<ul class="treeview-menu">

</ul>



<ul class="submenu">
    @foreach ($childs as $child)
        @permission($child->name)
        @if ($child->child->isEmpty())
            <li class="{{ request()->get('currentMenuIds')->contains($child->id) ? 'active' : '' }}">
                <a href="{{ $child->name == '#' ? '#' : route($child->name) }}">
                    <i class="menu-icon fa {{ $child->icon ?: 'fa-circle-o' }}"></i>
                    {{ $child->display_name }}
                </a>

                <b class="arrow"></b>
            </li>
        @else
            <li class="{{ request()->get('currentMenuIds')->contains($child->id) ? 'active' : '' }}">
                <a href="{{ $child->name == '#' ? '#' : route($child->name) }}" class="dropdown-toggle">
                    <i class="menu-icon fa {{ $child->icon ?: 'fa-circle-o' }}"></i>
                    {{ $child->display_name }}
                    <b class="arrow fa fa-angle-down"></b>
                </a>

                <b class="arrow"></b>

                @include('admin::layouts.partials.submenu', ['childs' => $child->child])
            </li>
        @endif
        @endpermission
    @endforeach
</ul>