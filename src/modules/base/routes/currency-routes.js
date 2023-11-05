export default [
  // Currencies Routes
  {
    name: 'admin.currencies',
    path: 'currencies',
    component: () => import('@base/views/currencies/CurrenciesIndex.vue'),

    children: [
      {
        name: 'admin.currencies.table',
        path: '',
        component: () => import('@base/views/currencies/CurrenciesTable.vue')
      }
    ]
  },

  {
    name: 'admin.currencies.create',
    path: 'currencies/create',
    component: () => import('@base/views/currencies/CreateCurrencyForm.vue')
  },

  {
    name: 'admin.currencies.update',
    path: 'currencies/:id/update',
    component: () => import('@base/views/currencies/UpdateCurrencyForm.vue'),
    props: true
  },
];