import { ModuleMiddleware } from '@/middlewares/ModuleMiddleware';

export default [
  // Settings Routes
  {
    name: 'admin.settings',
    path: 'settings',
    component: () => import('@base/views/settings/SettingsIndex.vue'),
    children: [
      {
        name: 'admin.settings.base',
        path: 'base',
        component: () => import('@base/views/settings/BaseSettings.vue'),
        alias: '',
        meta: {
          middleware: [ModuleMiddleware('base')]
        }
      },

      {
        name: 'admin.settings.education',
        path: 'education',
        component: () => import('@base/views/settings/EducationSettings.vue'),
        meta: {
          middleware: [ModuleMiddleware('education')]
        }
      },

      {
        name: 'admin.settings.billing',
        path: 'billing',
        component: () => import('@base/views/settings/BillingSettings.vue'),
        meta: {
          middleware: [ModuleMiddleware('billing')]
        }
      }
    ]
  },
];