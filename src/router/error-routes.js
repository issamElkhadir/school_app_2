export default [
  // 404 Page
  {
    name: '404',
    path: ':pathMatch(.*)*',
    component: () => import('../views/errors/PageNotFound.vue'),
    
    meta: {
      type: 'error'
    },
  },
]