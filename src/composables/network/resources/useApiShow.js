import { ref } from 'vue'
import { api } from '../../../boot/axios'

export function useApiShow(resource) {
  
  const error = ref(null)

  const loading = ref(false)

  const load = async (id, { onSuccess = () => {}, onError = () => {} } = {}) => {
    loading.value = true

    return await api
      .get(`${resource}/${id}`)
      .then((response) => {
        onSuccess && onSuccess(response.data)

        return response.data
      })
      .catch((e) => {
        if (e.response.status === 404) {
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
