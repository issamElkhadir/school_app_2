import { api } from '@/boot/axios'
import { ref } from 'vue'

export function useApiPreInscriptionAuth(path) {
  const error = ref(null)

  const  checking = ref(false)

  const check = async (payload, { onSuccess = () => {}, onError = () => {} } = {}) => {
     checking.value = true
    error.value = null
    return await api
      .post(path, payload)
      .then((response) => {
        onSuccess && onSuccess(response.data)
        return response.data
      })
      .catch((e) => {
        if (e.response.status === 422) {
          error.value = e.response.data.message
        }
        onError && onError(e.response.data)
      })
      .finally(() => {
         checking.value = false
      })
  }

  return {
    checking,
    error,
    check ,
  }
}
