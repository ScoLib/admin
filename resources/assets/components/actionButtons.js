const actionButtons = (h, vm, row) => {
    var buttons = [];
    if  (vm.config.permissions.edit) {
        var link = {
            name:'admin.model.edit',
            params:{
                model:vm.$route.params.model,
                id:row[vm.config.primaryKey]
            }
        };
        buttons.push(
            <router-link class="btn btn-xs btn-info"
                         to={link}
                         title="编辑">
                <i class="fa fa-pencil bigger-120"></i>
            </router-link>
        );
    }
    if (vm.config.permissions.delete) {
        let deleteFnc = () => {
            vm.delete(row[vm.config.primaryKey])
        };
        buttons.push(
            <button class="btn btn-xs btn-danger"
                    onClick={deleteFnc} title="删除">
                <i class="fa fa-trash-o bigger-120"></i>
            </button>
        );
    }

    /*if (vm.config.permissions.delete) {
        let destroy = () => {
            vm.destroy(row[vm.config.primaryKey])
        };
        buttons.push(
            <button class="btn btn-xs btn-danger"
                    onClick={destroy} title="彻底删除">
                <i class="fa fa-trash-o bigger-120"></i>
            </button>
        );
    }*/

    return buttons;
}
export default actionButtons;