export default [
  {
    path: '/login',
    name: 'login',
    component: () => import('../views/LoginView.vue')
  } ,
  {
    path : '/pre-inscription/:slug' ,
    name : 'pre-inscription',
    component : () => import('../views/pre-inscription/PreInscriptionView.vue')
  }
];