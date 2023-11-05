import { ref } from 'vue';
import { api } from '../../../boot/axios';

export function useApiDestroy(resource) {
  const destroying = ref(false);

  const error = ref(null);

  const destroy = async (id, {
    url = resource,
    onSuccess = () => {},
    onError = () => {}
  }) => {
    destroying.value = true;
    error.value = null;

    return await api
      .delete(`${url}/${id}`)
      .then((response) => {
        onSuccess && onSuccess(response.data);
        
        return response.data;
      })
      .catch((e) => {
        if (e.response.status === 422) {
          error.value = e.response.data.message;
        }

        onError && onError(e.response.data);
      })
      .finally(() => {
        destroying.value = false;
      });
  };

  return {
    destroying,
    error,
    destroy
  };
}
