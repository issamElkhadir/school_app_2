import { ref } from 'vue';
import { QueryBuilder } from './QueryBuilder';

export function useApiFetch(resource, options = {}) {
  // Query builder instance to build the query string
  const builder = new QueryBuilder(resource);

  // Loading state
  const loading = ref(false);

  // Applied filters
  const filters = ref({});

  // Applied sort
  const sort = ref(null);

  // Fields to be loaded
  const fields = ref(options.fields ?? null);

  // Search query
  const search = ref('');

  // Data fetched
  const data = ref('data' in options ? options.data : []);

  // Selected items
  const selected = ref([]);

  // Pagination state
  const pagination = ref({
    page: options.pagination?.page || 1,
    rowsPerPage: options.pagination?.rowsPerPage || 10,
    rowsNumber: 0,
    from: 1,
    to: 0,
    sort: options.sort ?? null
  });

  // Fetch data from the API
  const fetch = async () => {
    loading.value = true;

    builder.reset();

    const { page, rowsPerPage } = pagination.value;

    return await builder
      .when(sort.value, (qb) => qb.sort(sort.value))
      .when(rowsPerPage, (qb) => qb.limit(rowsPerPage))
      .when(page, (qb) => qb.page(page))
      .when(filters.value, (qb) => qb.filter(filters.value))
      .when(fields.value, (qb) => qb.fields(fields.value))
      .when(search.value, (qb) => qb.param('search', search.value))
      .get()
      .then((response) => {
        data.value = response.data.data;

        if (response.data.meta) {
          pagination.value.page = response.data.meta.current_page;
          pagination.value.rowsPerPage = response.data.meta.per_page;
          pagination.value.rowsNumber = response.data.meta.total;
          pagination.value.from = response.data.meta.from ?? 0;
          pagination.value.to = response.data.meta.to ?? 0;
        }
        return response;
      })
      .catch((err) => {
        console.error(err);
      })
      .finally(() => {
        loading.value = false;
      });
  };

  return {
    loading,
    filters,
    sort,
    pagination,
    fields,
    search,
    data,
    selected,
    builder,

    fetch
  };
}
