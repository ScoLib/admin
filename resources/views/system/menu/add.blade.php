@extends('admin::layouts.layouts')

@section('title', '新增菜单')

@section('content')

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">新增菜单</h3>
    </div>
    @include('admin::system.menu.form', ['url' => route('admin.system.menu.postAdd')])
</div>

@endsection