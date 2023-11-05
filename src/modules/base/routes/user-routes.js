export default [
  // Users Routes
  {
    name: 'admin.users',
    path: 'users',
    component: () => import('@base/views/users/UsersIndex.vue'),

    children: [
      {
        name: 'admin.users.table',
        path: '',
        component: () => import('@base/views/users/UsersTable.vue')
      },

      {
        name: 'admin.users.kanban',
        path: 'kanban',
        component: () => import('@base/views/users/UsersKanban.vue')
      }
    ]
  },

  {
    name: 'admin.users.create',
    path: 'users/create',
    component: () => import('@base/views/users/CreateUserForm.vue')
  },

  {
    name: 'admin.users.update',
    path: 'users/:id/update',
    component: () => import('@base/views/users/UpdateUserForm.vue')
  },
];