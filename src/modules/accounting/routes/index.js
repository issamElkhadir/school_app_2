import cashRegisterRoutes from './cash-register-routes';

export default {
  name: 'accounting',
  path: 'accounting',
  meta: {
    module: 'accounting'
  },
  component: () => import('../layouts/AccountingLayout.vue'),
  children: [
    ...cashRegisterRoutes
  ]
}