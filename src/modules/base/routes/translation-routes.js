export default [
  // Translations Routes
  {
    name: 'admin.translations',
    path: 'translations',
    component: () => import('@base/views/translations/TranslationsIndex.vue'),
    children: [
      {
        name: 'admin.translations.table',
        path: '',
        component: () => import('@base/views/translations/TranslationsTable.vue')
      }
    ]
  },

  {
    name: 'admin.translations.create',
    path: 'translations/create',
    component: () => import('@base/views/translations/CreateTranslationForm.vue')
  },

  {
    name: 'admin.translations.update',
    path: 'translations/:id/update',
    component: () => import('@base/views/translations/UpdateTranslationForm.vue'),
    props: true
  },
];