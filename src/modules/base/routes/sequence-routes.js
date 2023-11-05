export default [
  // Sequence Routes
  {
    name: 'admin.sequences',
    path: 'sequences',
    component: () => import('@base/views/sequences/SequencesIndex.vue'),
    children: [
      {
        name: 'admin.sequences.table',
        path: '',
        component: () => import('@base/views/sequences/SequencesTable.vue')
      }
    ]
  },

  {
    name: 'admin.sequences.create',
    path: 'sequences/create',
    component: () => import('@base/views/sequences/CreateSequenceForm.vue')
  },

  {
    name: 'admin.sequences.update',
    path: 'sequences/:id/update',
    component: () => import('@base/views/sequences/UpdateSequenceForm.vue'),
    props: true
  },
];