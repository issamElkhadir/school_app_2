import { ref } from 'vue'
import { api } from '../../../boot/axios'

export function useApiStore(resource) {
  const validation = ref({})
  const error = ref(null)

  const storing = ref(false)

  const store = async (payload, { onSuccess = () => {}, onError = () => {} } = {}) => {
    storing.value = true
    error.value = null
    validation.value = {}

    return await api
      .post(resource, payload)
      .then((response) => {
        onSuccess && onSuccess(response.data)
        return response.data
      })
      .catch((e) => {
        if (e.response.status === 422) {
          validation.value = e.response.data.errors
          error.value = e.response.data.message
        }

        onError && onError(e.response.data)
      })
      .finally(() => {
        storing.value = false
      })
  }

  return {
    validation,
    storing,
    error,

    store
  }
}
