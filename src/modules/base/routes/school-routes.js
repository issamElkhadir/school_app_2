export default [
  // School Routes
  {
    name: 'admin.schools',
    path: 'schools',
    component: () => import('@base/views/schools/SchoolsIndex.vue'),

    children: [
      {
        name: 'admin.schools.table',
        path: '',
        component: () => import('@base/views/schools/SchoolTable.vue')
      }
    ]
  },

  {
    name: 'admin.schools.create',
    path: 'schools/create',
    component: () => import('@base/views/schools/CreateSchoolForm.vue')
  },

  {
    name: 'admin.schools.update',
    path: 'schools/:id/update',
    component: () => import('@base/views/schools/UpdateSchoolForm.vue'),
    props: true
  }
];