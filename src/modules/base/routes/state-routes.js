export default [
  // States Routes
  {
    name: 'admin.states',
    path: 'states',
    component: () => import('@base/views/states/StatesIndex.vue'),

    children: [
      {
        name: 'admin.states.table',
        path: '',
        component: () => import('@base/views/states/StatesTable.vue')
      }
    ]
  },

  {
    name: 'admin.states.create',
    path: 'states/create',
    component: () => import('@base/views/states/CreateStateForm.vue')
  },

  {
    name: 'admin.states.update',
    path: 'states/:id/update',
    component: () => import('@base/views/states/UpdateStateForm.vue'),
    props: true
  },
];