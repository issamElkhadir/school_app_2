<template>
  <td :key="`${row.id}-${column?.field}`"
      :data-label="column?.label"
      class="text-nowrap text-truncate">
    <slot name="default"
          :column="column"
          :columns="columns"
          :filters="row.filters"
          :row-key="rowKey"
          :row-index="rowIndex"
          :row="row">
      {{ columnValue(row, column) }}
    </slot>
  </td>
</template>

<script setup>
import {get} from 'lodash';

defineProps({
  row: Object,

  column: {
    type: Object,
    required: true,
  },

  rowIndex: Number,
  rowKey: {
    required: true
  },

  columns: {
    type: [Object, Array],
  }
});

const columnValue = (row, column) => {
  if (column.field && typeof column.field === 'function') {
    return column.field(row);
  } else if (column.field) {
    return get(row, column.field);
  } else {
    return 'Opla';
  }
}
</script>

<style scoped>

</style>