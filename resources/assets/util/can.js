import store from '../store'

const can = function (route) {
    let permissions = store.state.permissions
    if (permissions.length > 0 && permissions.indexOf(route) > -1) {
        return true;
    }
    return false;
}

export default can