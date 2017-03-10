@extends('admin::layouts.layouts')

@section('title', '菜单管理')

@section('right_button')
    <div class="pull-right">
        @permission('admin.system.menu.add')
        <button type="button" data-url="{{ route('admin.system.menu.add') }}"
                class="btn btn-default" title="添加菜单"  @click="createMenu">
            <span class="fa fa-plus"></span> 添加菜单
        </button>
        @endpermission
    </div>
@endsection

@section('content')
    <div class="box">
        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
                <tr>
                    <th>ID</th>
                    <th class="col-sm-3">标题</th>
                    <th class="col-sm-3">名称</th>
                    <th>菜单</th>
                    <th>图标</th>
                    <th>排序</th>
                    <th class="col-sm-2">操作</th>
                </tr>
                @foreach ($menus as $menu)
                    <tr>
                        <td>{{ $menu->id }}</td>
                        <td>{{ $menu->spacer }}{{ $menu->display_name }}</td>
                        <td>{{ $menu->name }}</td>
                        <td>{!! $menu->is_menu ? '<span class="label label-success">是</span>' : '<span class="label label-default">否</span>' !!}</td>
                        <td>{!! $menu->icon ? '<i class="fa ' . $menu->icon . '"></i>' : '' !!}</td>
                        <td>{{ $menu->sort }}</td>
                        <td>
                            <button type="button" data-url="{{ route('admin.system.menu.edit', ['id' => $menu->id]) }}"
                               class="btn btn-default btn-xs" @click="editMenu"><i class="fa fa-pencil"></i> 编辑</button>
                            <a class="btn btn-danger btn-xs ajax-get"
                               href="{{ route('admin.system.menu.delete', ['id' => $menu->id]) }}"
                               data-confirm="确定要删除？">
                                <i class="fa fa-trash-o"></i> 删除</a>
                        </td>
                    </tr>
                @endforeach

            </table>
        </div>
        <!-- /.box-body -->

        <div class="box-footer clearfix">
        </div>

    </div>
    @include('admin::system.menu.dialog')
@endsection

@section('script')
    <script src="{{ asset('js/admin/system/menu.js') }}"></script>

    <script></script>
@endsection