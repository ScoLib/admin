<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<title>Sco Admin</title>
<meta name="description" content="" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
<meta name="csrf-token" content="{{ csrf_token() }}">
@yield('meta')

<link rel="stylesheet" href="{{ mix('css/admin.css') }}">
@yield('css')

<script>
    window.Lang = "{{ config('app.locale') }}"

@if (Auth::user())
    window.LoggedUser = {
        id: '{{Auth::user()->id}}',
        name: '{{Auth::user()->name}}',
        role: {!! Auth::user()->roles->makeHidden(['description', 'created_at', 'updated_at', 'pivot'])->first(null, collect()) !!}
    }
@endif

    window.Permissions = {!! request()->attributes->get('admin.permissions', collect()) !!};
</script>
