import { api } from '@/boot/axios'
import { ref } from 'vue'

export function useApiGetPreInscriptionBySlug(path) {
  
  const error = ref(null)

  const loading = ref(false)

  const load = async ({ onSuccess = () => {}, onError = () => {} } = {}) => {
    loading.value = true

    return await api
      .get(path)
      .then((response) => {
        onSuccess && onSuccess(response.data)
        return response.data
      })
      .catch((e) => {
        if (e.response.status === 404 || e.response.status === 400) {
          error.value = e.response.data.message
        }

        onError && onError(e.response.data)
      })
      .finally(() => {
        loading.value = false
      })
  }

  return {
    loading,
    error,

    load
  }
}
