import { useApiStore } from './useApiStore'
import { useApiFetch } from './useApiFetch'
import { useApiShow } from './useApiShow'
import { useApiSave } from './useApiSave'
import { useApiDestroy } from './useApiDestroy'
import { reactive } from 'vue'

export function useResource(resource) {
  const store = useApiStore(resource)

  const save = useApiSave(resource)

  const fetch = useApiFetch(resource)

  const show = useApiShow(resource)

  const destroy = useApiDestroy(resource)

  return reactive({
    store,
    save,
    fetch,
    destroy,
    show,
  });
}
