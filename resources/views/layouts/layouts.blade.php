<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    @include('admin::layouts.partials.htmlheader')

    <style>
        .tooltip {
            font-size: 13px;
        }
        .tooltip-inner {
            min-width: 50px;
            max-width: 300px;
            text-align:left;
        }
        .margin-r-0 {
            margin-right: 0px !important;
        }
        .margin-l-0 {
            margin-left: 0px !important;
        }
        .margin-offset-5 {
            margin-left: 5%;
        }

    </style>
</head>
<!-- ADD THE CLASS fixed TO GET A FIXED HEADER AND SIDEBAR LAYOUT -->
<!-- the fixed layout is not compatible with sidebar-mini -->
<body class="hold-transition skin-green fixed sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="{{ route('admin.index') }}" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>S</b>co</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>Sco</b>CMF</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>

            <div class="navbar-custom-menu">
                @include('admin::layouts.partials.navbar')
            </div>
        </nav>
    </header>

    <!-- =============================================== -->

    @include('admin::layouts.partials.leftside')

    <!-- =============================================== -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            @yield('right_button')

            <h1>
                @yield('title')
                <small>@yield('small_title')</small>
            </h1>
            @if(isset($breadcrumb))
                <ol class="breadcrumb">
                    @foreach($breadcrumb as $entry)
                        <li><a href="{{ $entry['url'] }}">{{ $entry['label'] }}</a></li>
                    @endforeach
                    <li class="active">{{ $title }}</li>
                </ol>
            @endif
        </section>

        <!-- Main content -->
        <section class="content">
            @yield('content')

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 1.0.0
        </div>
        <strong>Copyright &copy; 2015-{{ date('Y') }} <a href="http://www.scophp.com" target="_blank">ScoCMF</a>.</strong> All rights reserved.
    </footer>

</div>
<!-- ./wrapper -->

@include('admin::layouts.partials.script')

<!-- SlimScroll -->
<script src="{{ asset('sco-admin/js/jquery.slimscroll-1.3.8.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('sco-admin/js/admin.js') }}"></script>

<script src="{{ asset('sco-admin/layer-v3.0.1/layer.js') }}"></script>
@yield('script')
</body>
</html>
