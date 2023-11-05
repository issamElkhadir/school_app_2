export default [
  // Countries Routes
  {
    name: 'admin.countries',
    path: 'countries',
    component: () => import('@base/views/countries/CountriesIndex.vue'),
    children: [
      {
        name: 'admin.countries.table',
        path: '',
        component: () => import('@base/views/countries/CountriesTable.vue')
      },

      {
        name: 'admin.countries.show',
        path: 'countries/:id',
        component: () => import('@base/views/countries/ShowCountry.vue')
      }
    ]
  },

  {
    name: 'admin.countries.create',
    path: 'countries/create',
    component: () => import('@base/views/countries/CreateCountryForm.vue')
  },

  {
    name: 'admin.countries.update',
    path: 'countries/:id/update',
    component: () => import('@base/views/countries/UpdateCountryForm.vue'),
    props: true
  }
];
