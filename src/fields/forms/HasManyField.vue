<template>
  <div>
    <PlfTable :rows="rows"
              :title="label"
              hide-bottom
              height="auto"
              v-bind="$attrs"
              :hoverable="false"
              :columns="internalColumns">
      <template v-for="column in columns"
                :key="`column-${column.name}`"
                #[`body-cell-${column.name}`]="props">
        <slot :name="`body-cell-${column.name}`"
              :invalid="`${attribute}.${props.rowIndex}.${column.field}` in validation"
              :errors="validation[`${attribute}.${props.rowIndex}.${column.field}`]"
              v-bind="props">

        </slot>
      </template>

      <template #body-cell-__actions="{ row, rowIndex }">
        <slot name="body-cell-__actions"
              :row="row"
              :rowIndex="rowIndex"
              :disabled="disabled"
              :removeRow="removeRow">
          <PlfButton class="btn-action text-danger w-auto px-2"
                     :disabled="disabled"
                     icon="mdi.IconDeleteOutline"
                     @click="removeRow(row, rowIndex)"/>
        </slot>
      </template>

      <template #top-right>
        <slot name="top-right">
          <PlfButton class="ms-2 btn-action w-auto px-2"
                     :disabled="disabled"
                     :label="$t('general.btn-add')"
                     icon="mdi.IconPlus"
                     @click="addRow"/>
        </slot>
      </template>
    </PlfTable>
  </div>
</template>

<script setup>
import PlfButton from '@/components/shared/button/PlfButton.vue';
import PlfTable from '@/components/shared/table/PlfTable.vue';
import {useVModel} from '@vueuse/core';
import {computed} from 'vue';

const emit = defineEmits(['update:modelValue']);

const props = defineProps({
  columns: {
    type: Array,
    required: true
  },

  modelValue: {
    type: Array,
    required: true
  },

  disabled: {
    type: Boolean,
    default: false
  },

  label: {
    type: String,
  },

  attribute: {
    type: String,
    required: true
  },

  validation: {
    type: Object,
    required: true
  }
});

const rows = useVModel(props, 'modelValue', emit, {passive: true, defaultValue: []});

const addRow = () => {
  rows.value = [...rows.value, {}];
}

const removeRow = (row, rowIndex) => {
  rows.value = rows.value.filter((_, index) => index !== rowIndex);
}

const internalColumns = computed(() => {
  return props.columns.concat({
    name: '__actions',
    required: true,
    classes: "text-end w-1",
  });
});
</script>