<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>@yield('title') - ScoCMF管理平台</title>
<!-- Tell the browser to be responsive to screen width -->
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta name="csrf-token" content="{{ csrf_token() }}">
@yield('meta')

<!-- Bootstrap 3.3.6 -->
<link rel="stylesheet" href="{{ asset('sco-admin/css/bootstrap.min.css') }}">
<!-- Font Awesome -->
<link rel="stylesheet" href="{{ asset('sco-admin/css/font-awesome.min.css') }}">
<!-- Theme style -->
<link rel="stylesheet" href="{{ asset('sco-admin/css/admin.css') }}">
@yield('css')

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="{{ asset('sco-admin/js/html5shiv-3.7.3.min.js') }}"></script>
<script src="{{ asset('sco-admin/js/respond-1.4.2.min.js') }}"></script>
<![endif]-->