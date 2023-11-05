export default [
  // Cities Routes
  {
    name: 'admin.cities',
    path: 'cities',
    component: () => import('@base/views/cities/CitiesIndex.vue'),

    children: [
      {
        name: 'admin.cities.table',
        path: '',
        component: () => import('@base/views/cities/CitiesTable.vue')
      }
    ]
  },

  {
    name: 'admin.cities.create',
    path: 'cities/create',
    component: () => import('@base/views/cities/CreateCityForm.vue')
  },

  {
    name: 'admin.cities.update',
    path: 'cities/:id/update',
    component: () => import('@base/views/cities/UpdateCityForm.vue'),
    props: true
  },
];