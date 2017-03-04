<ul class="treeview-menu">
    @foreach ($childs as $child)
        @permission($child->name)
        @if ($child->child->isEmpty())
            <li class="{{ request()->get('currentMenuIds')->contains($child->id) ? 'active' : '' }}">
                <a href="{{ $child->name == '#' ? '#' : route($child->name) }}">
                    <i class="fa  {{ $child->icon ?: 'fa-circle-o' }}"></i>
                    {{ $child->display_name }}
                </a>
            </li>
        @else
            <li class="{{ request()->get('currentMenuIds')->contains($child->id) ? 'active' : '' }}">
                <a href="{{ $child->name == '#' ? '#' : route($child->name) }}">
                    <i class="fa {{ $child->icon ?: 'fa-circle-o' }}"></i>
                    {{ $child->display_name }}
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                @include('admin::layouts.partials.leftmenuchild', ['childs' => $child->child])
            </li>
        @endif
        @endpermission
    @endforeach
</ul>