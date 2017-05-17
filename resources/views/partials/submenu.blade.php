<ul class="{{ $ulClass }}">
    @if ($isTop)
        <li class="header">MAIN NAVIGATION</li>
    @endif

    @foreach ($childs as $child)
        <li class="{{ $child->child->isEmpty() ? '' : 'treeview' }} {{ request()->attributes->get('admin.menu.position')->pluck('id')->contains($child->id) ? 'active' : '' }}">
            <a href="{{ $child->name == '#' ? '#' : route($child->name) }}">
                <i class="fa {{ $child->icon ?: 'fa-circle-o' }}"></i>
                @if ($isTop)
                    <span> {{ $child->display_name }} </span>
                @else
                    {{ $child->display_name }}
                @endif

                @if (!$child->child->isEmpty())
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                @endif
            </a>

            @if (!$child->child->isEmpty())
                @include('admin::partials.submenu', [
                    'isTop' => false,
                    'childs' => $child->child,
                    'ulClass' => "treeview-menu"
                ])
            @endif
        </li>
    @endforeach
</ul>