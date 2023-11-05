export default [
  // Measure Units Routes
  {
    name: 'admin.measure-units.update',
    path: 'measure-units/:id/update',
    component: () => import('@base/views/measure-units/UpdateMeasureUnitForm.vue'),
    props: true
  },

  {
    name: 'admin.measure-units',
    path: 'measure-units',
    component: () => import('@base/views/measure-units/MeasureUnitsIndex.vue'),
    children: [
      {
        name: 'admin.measure-units.table',
        path: '',
        component: () => import('@base/views/measure-units/MeasureUnitsTable.vue')
      }
    ]
  },

  {
    name: 'admin.measure-units.create',
    path: 'measure-units/create',
    component: () => import('@base/views/measure-units/CreateMeasureUnitForm.vue')
  },

  {
    name: 'admin.measure-units.update',
    path: 'measure-units/:id/update',
    component: () => import('@base/views/measure-units/UpdateMeasureUnitForm.vue'),
    props: true
  }
];
