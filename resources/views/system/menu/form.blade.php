<!-- form start -->
<form method="post" id="form-menu" action="{{ $url }}" class="form-horizontal">
    <div class="box-body">
        <div class="form-group margin-l-0 margin-r-0">
            <label class="col-sm-3 control-label">父级菜单</label>
            <div class="col-sm-6">
                <select class="form-control" name="pid">
                    <option value="0">顶级菜单</option>
                    @foreach ($menus as $vo)
                        <option value="{{ $vo->id }}">{{ $vo->spacer }}{{ $vo->display_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group margin-l-0 margin-r-0">
            <label for="display_name" class="col-sm-3 control-label">显示名称</label>
            <div class="col-sm-6">
                <input type="text" name="display_name" class="form-control" id="display_name"
                       placeholder="用户管理" value="{{ $menu->display_name or '' }}">
            </div>
        </div>
        <div class="form-group margin-l-0 margin-r-0">
            <label for="name" class="col-sm-3 control-label">名称</label>
            <div class="col-sm-6">
                <input type="text" data-toggle="tooltip"
                       data-original-title="必须是路由的别名，如不是链接，则填“#”" name="name" class="form-control tooltips"
                       id="name" placeholder="admin.system.menu" value="{{ $menu->name or '' }}">
            </div>
        </div>

        <div class="form-group margin-l-0 margin-r-0">
            <label for="icon" class="col-sm-3 control-label">图标</label>
            <div class="col-sm-2">
                <input type="text" name="icon" class="form-control" id="icon"
                       placeholder="fa-" value="{{ $menu->icon or '' }}">
            </div>
        </div>

        <div class="form-group margin-l-0 margin-r-0">
            <label for="icon" class="col-sm-3 control-label">菜单</label>
            <div class="col-sm-6">
                <div class="switch">
                    <input type="radio" class="switch-input" name="is_menu" value="1" id="is_menu_on" checked>
                    <label for="is_menu_on" class="switch-label switch-label-on">是</label>
                    <input type="radio" class="switch-input" name="is_menu" value="0" id="is_menu_off">
                    <label for="is_menu_off" class="switch-label switch-label-off">否</label>
                    <span class="switch-selection"></span>

                </div>
            </div>
        </div>

        <div class="form-group margin-l-0 margin-r-0">
            <label for="sort" class="col-sm-3 control-label">排序</label>
            <div class="col-sm-2">
                <input type="text" name="sort" data-toggle="tooltip"
                       data-original-title="数字：0~255" class="form-control tooltips" id="sort"  value="{{ $menu->sort or '255' }}">
            </div>
        </div>

        <div class="form-group margin-l-0 margin-r-0">
            <label for="description" class="col-sm-3 control-label">描述</label>
            <div class="col-sm-6">
                <textarea id="description" class="form-control" rows="3" name="description">{{ $menu->description or '' }}</textarea>
            </div>
        </div>


    </div>
    <!-- /.box-body -->

    <div class="box-footer">
        <button type="submit" class="btn btn-primary">
            <i class="ace-icon fa fa-check bigger-110"></i>
            保存</button>
    </div>
</form>

@section('script')
    <script src="{{ asset('js/jquery.validate.min.js') }}"></script>
    <script>
        $(function () {
            $(':input[name="pid"]').val('{{ $menu->pid or '0' }}');
            $(':input[name="is_menu"][value="{{ $menu->is_menu or '1' }}"]').prop('checked', true);

            $('#form-menu').validate({
                rules: {
                    'name' : {
                        required : true
                    },
                    'display_name' : {
                        required : true
                    }
                },
                messages : {
                    'name': {
                        required : '{{ trans('admin.system.menu.name_required') }}'
                    },
                    'display_name' : {
                        required : '{{ trans('admin.system.menu.display_name_required') }}'
                    }
                }
            });
        })
    </script>
@endsection