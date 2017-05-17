<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<title>{{ request()->attributes->get('admin.menu.position')->last()->display_name }} - Sco Admin</title>
<meta name="description" content="" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
<meta name="csrf-token" content="{{ csrf_token() }}">
@yield('meta')

<link rel="stylesheet" href="{{ mix('css/admin.css') }}">
@yield('css')

