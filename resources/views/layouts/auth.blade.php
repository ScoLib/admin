<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    @include('admin::layouts.partials.htmlheader')
</head>
<body class="hold-transition login-page">
@yield('body')
@include('admin::layouts.partials.script')

</body>
</html>
