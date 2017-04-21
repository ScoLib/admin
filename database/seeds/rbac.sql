-- ----------------------------
-- Records of sco_role_user
-- ----------------------------
INSERT INTO `sco_role_user` VALUES ('1', '1');

-- ----------------------------
-- Records of sco_roles
-- ----------------------------
INSERT INTO `sco_roles` VALUES ('1', 'admin', '超级管理员', '', '2016-08-05 16:50:19', '2016-08-05 16:50:19');
INSERT INTO `sco_roles` VALUES ('2', 'test', '测试组', '', '2016-08-05 16:50:19', '2016-08-05 16:50:19');

-- ----------------------------
-- Records of sco_permission_role
-- ----------------------------
INSERT INTO `sco_permission_role` VALUES ('1', '1');
INSERT INTO `sco_permission_role` VALUES ('2', '1');
INSERT INTO `sco_permission_role` VALUES ('3', '1');
INSERT INTO `sco_permission_role` VALUES ('4', '1');
INSERT INTO `sco_permission_role` VALUES ('5', '1');
INSERT INTO `sco_permission_role` VALUES ('6', '1');
INSERT INTO `sco_permission_role` VALUES ('7', '1');
INSERT INTO `sco_permission_role` VALUES ('8', '1');
INSERT INTO `sco_permission_role` VALUES ('9', '1');
INSERT INTO `sco_permission_role` VALUES ('10', '1');
INSERT INTO `sco_permission_role` VALUES ('11', '1');
INSERT INTO `sco_permission_role` VALUES ('12', '1');
INSERT INTO `sco_permission_role` VALUES ('13', '1');
INSERT INTO `sco_permission_role` VALUES ('14', '1');
INSERT INTO `sco_permission_role` VALUES ('15', '1');
INSERT INTO `sco_permission_role` VALUES ('16', '1');
INSERT INTO `sco_permission_role` VALUES ('17', '1');
INSERT INTO `sco_permission_role` VALUES ('18', '1');
INSERT INTO `sco_permission_role` VALUES ('19', '1');
INSERT INTO `sco_permission_role` VALUES ('20', '1');
INSERT INTO `sco_permission_role` VALUES ('21', '1');
INSERT INTO `sco_permission_role` VALUES ('22', '1');
INSERT INTO `sco_permission_role` VALUES ('23', '1');
INSERT INTO `sco_permission_role` VALUES ('24', '1');
INSERT INTO `sco_permission_role` VALUES ('25', '1');
INSERT INTO `sco_permission_role` VALUES ('26', '1');
INSERT INTO `sco_permission_role` VALUES ('27', '1');
INSERT INTO `sco_permission_role` VALUES ('28', '1');
INSERT INTO `sco_permission_role` VALUES ('29', '1');
INSERT INTO `sco_permission_role` VALUES ('30', '1');
INSERT INTO `sco_permission_role` VALUES ('31', '1');
INSERT INTO `sco_permission_role` VALUES ('32', '1');
INSERT INTO `sco_permission_role` VALUES ('33', '1');
INSERT INTO `sco_permission_role` VALUES ('34', '1');


-- ----------------------------
-- Records of sco_permissions
-- ----------------------------
INSERT INTO `sco_permissions` VALUES ('1', '0', 'fa-dashboard', '控制台', 'admin.index', '1', '1', '控制台', '2016-08-05 16:50:19', '2016-08-05 16:50:19');
INSERT INTO `sco_permissions` VALUES ('2', '0', 'fa-edit', '系统管理', '#', '1', '1', '系统管理', '2016-08-05 16:50:19', '2016-08-05 16:50:19');
INSERT INTO `sco_permissions` VALUES ('3', '0', '', '左侧菜单数据', 'admin.menu', '0', '1', '', '2016-08-05 16:50:19', '2016-08-05 16:50:19');
-- INSERT INTO `sco_permissions` VALUES ('3', '2', 'fa-gear', '站点设置', 'admin.system.config', '1', '1', '站点设置', '2016-08-05 16:50:19', '2016-08-05 16:50:19');
-- INSERT INTO `sco_permissions` VALUES ('4', '3', '', '保存设置', 'admin.system.config.save', '0', '1', '保存设置', '2016-08-05 16:50:19', '2016-08-05 16:50:19');
INSERT INTO `sco_permissions` VALUES ('5', '2', 'fa-link', '后台菜单', 'admin.system.menu', '1', '1', '', '2016-08-05 16:50:19', '2016-08-05 16:50:19');
INSERT INTO `sco_permissions` VALUES ('6', '5', '', '菜单列表数据', 'admin.system.menu.list', '0', '1', '', '2016-08-05 16:50:19', '2016-08-05 16:50:19');
INSERT INTO `sco_permissions` VALUES ('7', '5', ' ', '保存菜单', 'admin.system.menu.save', '0', '1', '', '2016-08-05 16:50:19', '2016-08-05 16:50:19');
INSERT INTO `sco_permissions` VALUES ('8', '5', '', '批量删除菜单', 'admin.system.menu.batch.delete', '0', '1', '', '2016-08-05 16:50:19', '2016-08-05 16:50:19');
-- INSERT INTO `sco_permissions` VALUES ('9', '5', '', '保存编辑菜单', 'admin.system.menu.postEdit', '0', '1', '', '2016-08-05 16:50:19', '2016-08-05 16:50:19');
INSERT INTO `sco_permissions` VALUES ('10', '5', '', '删除菜单', 'admin.system.menu.delete', '0', '0', '', '2016-08-18 15:22:22', '2016-08-18 15:22:22');
INSERT INTO `sco_permissions` VALUES ('11', '0', '', '管理组', '#', '1', '1', '用户管理', '2016-08-05 16:50:19', '2016-08-05 16:50:19');
INSERT INTO `sco_permissions` VALUES ('12', '11', 'fa-user', '管理员', 'admin.manager.user', '1', '1', '管理员', '2016-08-05 16:50:19', '2016-08-05 16:50:19');
INSERT INTO `sco_permissions` VALUES ('13', '12', '', '管理员列表数据', 'admin.manager.user.list', '0', '1', '', '2016-08-11 15:19:32', '2016-08-11 15:19:32');
INSERT INTO `sco_permissions` VALUES ('14', '12', '', '保存管理员', 'admin.manager.user.save', '0', '1', '', '2016-08-11 16:05:06', '2016-08-11 16:05:06');
INSERT INTO `sco_permissions` VALUES ('15', '12', '', '设置角色', 'admin.manager.user.save.role', '0', '1', '', '2016-08-11 16:39:43', '2016-08-11 16:39:43');
-- INSERT INTO `sco_permissions` VALUES ('16', '12', '', '保存编辑用户', 'admin.manager.user.postEdit', '0', '1', '', '2016-08-11 16:39:43', '2016-08-11 16:39:43');
INSERT INTO `sco_permissions` VALUES ('17', '12', '', '删除管理员', 'admin.manager.user.delete', '0', '1', '', '2016-08-18 14:43:03', '2016-08-18 14:43:03');
INSERT INTO `sco_permissions` VALUES ('18', '11', 'fa-users', '角色管理', 'admin.manager.role', '1', '1', '用户列表', '2016-08-05 16:50:19', '2016-08-05 16:50:19');
INSERT INTO `sco_permissions` VALUES ('19', '18', '', '角色列表数据', 'admin.manager.role.list', '0', '0', '', '2016-08-19 17:20:39', '2016-08-19 17:20:39');
INSERT INTO `sco_permissions` VALUES ('20', '18', '', '保存角色', 'admin.manager.role.save', '0', '0', '', '2016-08-19 17:20:39', '2016-08-19 17:20:39');
INSERT INTO `sco_permissions` VALUES ('21', '18', '', '获取所有角色', 'admin.manager.role.all', '0', '0', '', '2016-08-19 17:20:39', '2016-08-19 17:20:39');
INSERT INTO `sco_permissions` VALUES ('22', '18', '', 'ajax获取权限列表', 'admin.manager.role.perms.list', '0', '0', '', '2016-08-19 17:20:39', '2016-08-19 17:20:39');
-- INSERT INTO `sco_permissions` VALUES ('23', '18', '', '角色授权', 'admin.manager.role.authorize', '0', '0', '', '2016-08-19 17:20:39', '2016-08-19 17:20:39');
INSERT INTO `sco_permissions` VALUES ('24', '18', '', '删除角色', 'admin.manager.role.delete', '0', '0', '', '2016-08-19 17:20:39', '2016-08-19 17:20:39');
-- INSERT INTO `sco_permissions` VALUES ('25', '18', '', '保存角色授权', 'admin.manager.role.postAuthorize', '0', '0', '', '2016-08-23 11:18:46', '2016-08-23 11:18:49');
