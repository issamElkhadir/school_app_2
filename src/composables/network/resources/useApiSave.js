import { ref } from 'vue';
import { api } from '../../../boot/axios';

export function useApiSave(resource) {
  const validation = ref({});
  const error = ref(null);

  const saving = ref(false);

  const save = async ({
    id = null,
    payload = {},
    onSuccess = () => {},
    onError = () => {},
    url = null
  } = {}) => {
    error.value = null
    saving.value = true;
    validation.value = {};
    
    url ??= `${resource}/${id}`;

    return await api
      .put(url, payload)
      .then((response) => {
        onSuccess && onSuccess(response.data);

        return response.data;
      })
      .catch((e) => {
        if (e.response.status === 422) {
          validation.value = e.response.data.errors;
          error.value = e.response.data.message;
        }

        onError && onError(e.response.data);
      })
      .finally(() => {
        saving.value = false;
      });
  };

  return {
    validation,
    saving,
    error,

    save
  };
}
