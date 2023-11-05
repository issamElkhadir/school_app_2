export default [
  // Permission Routes
  // {
  //   name: 'admin.permissions',
  //   path: 'permissions',
  //   component: () => import('@base/views/permissions/PermissionsIndex.vue'),

  //   children: [
  //     {
  //       name: 'admin.permissions.table',
  //       path: '',
  //       component: () => import('@base/views/permissions/PermissionsTable.vue')
  //     }
  //   ]
  // },

  {
    name: 'admin.permissions.manage',
    path: 'permissions/manage',
    component: () => import('@base/views/permissions/RolePermissionManager.vue')
  },

  // {
  //   name: 'admin.schools.update',
  //   path: 'schools/:id/update',
  //   component: () => import('@base/views/schools/UpdateSchoolForm.vue'),
  //   props: true
  // }
];
