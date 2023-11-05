export default [
  // Measure Unit Categories Routes
  {
    name: 'admin.measure-unit-categories',
    path: 'measure-unit-categories',
    component: () => import('@base/views/measure-unit-categories/MeasureUnitCategoriesIndex.vue'),
    children: [
      {
        name: 'admin.measure-unit-categories.table',
        path: '',
        component: () =>
          import('@base/views/measure-unit-categories/MeasureUnitCategoriesTable.vue')
      }
    ]
  },

  {
    name: 'admin.measure-unit-categories.create',
    path: 'measure-unit-categories/create',
    component: () =>
      import('@base/views/measure-unit-categories/CreateMeasureUnitCategoryForm.vue')
  },

  {
    name: 'admin.measure-unit-categories.update',
    path: 'measure-unit-categories/:id/update',
    component: () =>
      import('@base/views/measure-unit-categories/UpdateMeasureUnitCategoryForm.vue'),
    props: true
  },
];