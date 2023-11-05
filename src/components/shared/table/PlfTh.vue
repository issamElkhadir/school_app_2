<template>
  <th :key="`${column?.field}`"
      dir="auto"
      :class="{ 'cursor-pointer': column.sortable }"
      @click="sort">
    <slot name="default"
          :column="column">
      <div class="d-flex justify-content-between align-items-center gap-2">
        <div>
          {{ column?.label }}
        </div>

        <div>
          <template v-if="'sort' in filters && filters.sort.field === column.name">
            <PlfIcon name="mdi.IconChevronUp"
                     v-if="filters.sort.direction === 'asc'" />
            <PlfIcon name="mdi.IconChevronDown"
                     v-else-if="filters.sort.direction === 'desc'" />
          </template>

          <PlfIcon name="mdi.IconUnfoldMoreHorizontal"
                   v-else-if="column.sortable" />
        </div>
      </div>
    </slot>
  </th>
</template>

<script setup>
import PlfIcon from '../icon/PlfIcon.vue';

const emit = defineEmits(['sort']);

const props = defineProps({
  column: {
    type: Object,
    required: true,
  },

  filters: {
    type: Object,
    required: true
  }
});

const sort = () => emit('sort', props.column);
</script>

<style scoped></style>
