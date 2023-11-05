export default {
  path: 'dev',
  name: 'dev',

  component: () => import('@/views/DevView.vue'),
  children: [
    { 
      path: 'execute',
      name: 'dev.execute',
      component: () => import('@/views/dev/ArtisanCommanderView.vue')
    }
  ]
};
