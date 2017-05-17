<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ request()->attributes->get('admin.menu.position')->last()->display_name }}
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <i class="fa fa-dashboard"></i> 首页
                </a>
            </li>
            @foreach (request()->attributes->get('admin.menu.position') as $position)
                @if ($loop->last)
                    <li class="active">{{ $position->display_name }}</li>
                @else
                    <li>
                        <a href="{{ $position->name == '#' ? '@' : route($position->name) }}">
                            {{ $position->display_name }}
                        </a>
                    </li>
                @endif
            @endforeach
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        @yield('content')
    </section>
    <!-- /.content -->
</div>