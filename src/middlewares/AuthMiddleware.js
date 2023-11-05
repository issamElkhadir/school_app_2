import { useAuthStore } from '@/modules/base/stores/auth';

export async function AuthMiddleware({ next, redirect }) {
  const auth = useAuthStore();

  const response = await auth.check();
  
  if (response) {
    next();
  } else {
    redirect({ name: 'login' });
  }
}
