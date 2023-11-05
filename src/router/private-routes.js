import { LocaleMiddleware } from '@/middlewares/LocaleMiddleware';
import { AuthMiddleware } from '@/middlewares/AuthMiddleware';
import { ModuleMiddleware } from '@/middlewares/ModuleMiddleware';
import baseRoutes from '@/modules/base/routes';
import educationRoutes from '@/modules/education/routes';
import accountingRoutes from '@/modules/accounting/routes';
import errorRoutes from './error-routes';
import demoRoutes from './dev-routes';

const children = [
  baseRoutes,
  educationRoutes,
  accountingRoutes,
  ...errorRoutes
];

// If we are in development, add the demo routes
if (import.meta.env.DEV) {
  children.unshift(demoRoutes);
}

export default {
  name: 'admin',
  path: '/admin',
  meta: {
    middleware: [AuthMiddleware, ModuleMiddleware(), LocaleMiddleware]
  },

  component: () => import('@/views/AdminView.vue'),

  children: children
};
