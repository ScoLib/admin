<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    @include('admin::layouts.partials.head')
</head>

<body class="no-skin">
@include('admin::layouts.partials.navbar')

<!-- /section:basics/navbar.layout -->
<div class="main-container ace-save-state" id="main-container">

    <!-- #section:basics/sidebar -->
@include('admin::layouts.partials.sidebar')

<!-- /section:basics/sidebar -->
    <div class="main-content">
        <div class="main-content-inner">
            <!-- #section:basics/content.breadcrumbs -->
            <div class="breadcrumbs ace-save-state" id="breadcrumbs">
                <ul class="breadcrumb">
                    <li>
                        <i class="ace-icon fa fa-home home-icon"></i>
                        <a href="{{ route('admin.index') }}">首页</a>
                    </li>

                    @if(isset($breadcrumb))
                        @foreach($breadcrumb as $entry)
                            <li>
                                <a href="{{ $entry['url'] }}">{{ $entry['label'] }}</a>
                            </li>
                        @endforeach
                        <li class="active">{{ $title }}</li>
                    @endif
                </ul><!-- /.breadcrumb -->

                <!-- #section:basics/content.searchbox -->
                <div class="nav-search" id="nav-search">
                    <form class="form-search">
                                <span class="input-icon">
                                    <input type="text" placeholder="Search ..."
                                           class="nav-search-input"
                                           id="nav-search-input"
                                           autocomplete="off"/>
                                    <i class="ace-icon fa fa-search nav-search-icon"></i>
                                </span>
                    </form>
                </div><!-- /.nav-search -->

                <!-- /section:basics/content.searchbox -->
            </div>

            <!-- /section:basics/content.breadcrumbs -->
            <div class="page-content">
                <div class="row">
                    <div class="col-xs-12">
                        <!-- PAGE CONTENT BEGINS -->
                        <router-view></router-view>
                        <!-- PAGE CONTENT ENDS -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.page-content -->
        </div>
    </div><!-- /.main-content -->

    <div class="footer">
        <div class="footer-inner">
            <!-- #section:basics/footer -->
            <div class="footer-content">
                <span class="bigger-120">
                    <span class="blue bolder">Sco</span> &copy; 2016-{{ date('Y') }}
                </span>
            </div>

            <!-- /section:basics/footer -->
        </div>
    </div>

    <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
        <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
    </a>
</div><!-- /.main-container -->

@include('admin::layouts.partials.script')
@yield('script')

</body>
</html>
