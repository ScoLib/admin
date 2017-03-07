@extends('admin::layouts.layouts')

@section('title', '编辑菜单')

@section('content')

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">编辑菜单</h3>
    </div>
    @include('admin::system.menu.form', ['url' => route('admin.system.menu.postEdit', ['id' => $menu->id])])
</div>

@endsection