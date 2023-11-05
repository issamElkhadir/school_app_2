export default [
  {
    name: 'admin.accounting.cash-registers',
    path: 'cash-registers',
    component: () => import('@accounting/views/cash-registers/CashRegistersIndex.vue'),

    children: [
      {
        name: 'admin.accounting.cash-registers.table',
        path: '',
        component: () => import('@accounting/views/cash-registers/CashRegistersTable.vue')
      }
    ]
  },

  {
    name: 'admin.accounting.cash-registers.create',
    path: 'cash-registers/create',
    component: () => import('@accounting/views/cash-registers/CreateCashRegisterForm.vue')
  },

  {
    name: 'admin.accounting.cash-registers.update',
    path: 'cash-registers/:id/update',
    component: () => import('@accounting/views/cash-registers/UpdateCashRegisterForm.vue'),
    props: true
  },
]