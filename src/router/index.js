import { createRouter, createWebHistory } from 'vue-router'
import publicRoutes from './public-routes'
import privateRoutes from './private-routes'
import { middlewarePipeline } from '@/middlewares/middlewarePipeline';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [privateRoutes, ...publicRoutes]
});

router.beforeEach((to, from, next) => {
  const redirect = (location) => {
    next(location);
  };

  const context = { to, from, next, redirect };
  const middlewares = [];

  // Get the middleware for all the matched components and
  // their parents (because they are all executed)
  for (const route of to.matched) {
    if (route.meta.middleware && route.meta.middleware.length > 0) {
      middlewares.push(...route.meta.middleware);
    }
  }

  // No middlewares, just go to next
  if (middlewares.length === 0) {
    next();
    return;
  }

  middlewares[0]({
    ...context,
    next: middlewarePipeline(context, middlewares, 1)
  });
});

export default router;
