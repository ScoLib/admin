<div id="menu-dialog" class="hide">
    <div class="box-solid">
        <!-- form start -->
        <form role="form">
            <div class="box-body">
                <div class="form-group">
                    <label for="pid">父级菜单</label>
                    <select id="pid" class="form-control" name="pid" v-model="selected">
                        <option value="0">顶级菜单</option>
                        <option v-for="vo in menus"  v-bind:value="vo.id">@{{ vo.spacer }}@{{ vo.display_name }}</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="display_name">显示名称</label>
                    <input type="text" name="display_name" class="form-control" id="display_name"
                           placeholder="用户管理" v-model="info.display_name">
                </div>

            </div>
            <!-- /.box-body -->

        </form>


    </div>
</div>
