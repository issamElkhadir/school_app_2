export default [
  // Mail Servers Routes
  {
    name: 'admin.mail-servers',
    path: 'mail-servers',
    component: () => import('@base/views/mail-servers/MailServersIndex.vue'),
    children: [
      {
        name: 'admin.mail-servers.table',
        path: '',
        component: () => import('@base/views/mail-servers/MailServersTable.vue')
      }
    ]
  },

  {
    name: 'admin.mail-servers.create',
    path: 'mail-servers/create',
    component: () => import('@base/views/mail-servers/CreateMailServerForm.vue')
  },

  {
    name: 'admin.mail-servers.update',
    path: 'mail-servers/:id/update',
    component: () => import('@base/views/mail-servers/UpdateMailServerForm.vue'),
    props: true
  }
];
