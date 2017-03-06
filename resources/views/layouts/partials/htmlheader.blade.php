<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>@yield('title') - ScoCMF管理平台</title>
<!-- Tell the browser to be responsive to screen width -->
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta name="csrf-token" content="{{ csrf_token() }}">
@yield('meta')

<!-- Bootstrap 3.3.6 -->
<link rel="stylesheet" href="{{ mix('css/bootstrap.css') }}">
<!-- Font Awesome -->
<link rel="stylesheet" href="{{ mix('css/font-awesome.css') }}">
<!-- Theme style -->
<link rel="stylesheet" href="{{ mix('css/admin.css') }}">
<link rel="stylesheet" href="{{ mix('css/skin-green.css') }}">
@yield('css')
