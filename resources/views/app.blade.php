<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    @include('admin::partials.head')
</head>

<!-- ADD THE CLASS fixed TO GET A FIXED HEADER AND SIDEBAR LAYOUT -->
<!-- the fixed layout is not compatible with sidebar-mini -->
<body class="hold-transition skin-blue fixed sidebar-mini">
<div id="app"></div>

@include('admin::partials.script')

</body>
</html>
