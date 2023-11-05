<template>
  <div class="row">
    <div class="col d-flex flex-column">
      <h4>{{ $t('Rows') }}</h4>

      <ol class="d-flex flex-column gap-2">
        <li v-for="(row, index) in rows"
            :key="`row-${row.value}`">
          <PlfInput borderless
                    :disabled="disabled"
                    v-model="rows[index].label"
                    input-classes="rounded-bottom-0 border-bottom">
            <template v-if="rows.length > 1"
                      #suffix>
              <PlfButton class="btn-action rounded-circle"
                         @click="handleRemoveRow(index)"
                         :disabled="disabled"
                         icon="mdi.IconRemove" />
            </template>
          </PlfInput>
        </li>
      </ol>

      <PlfButton class="btn-action align-self-end"
                 @click="addRow"
                 :disabled="disabled"
                 icon="mdi.IconPlus" />
    </div>

    <div class="col d-flex flex-column">
      <h4>{{ $t('Columns') }}</h4>

      <ul class="list-unstyled d-flex flex-column gap-2">
        <li v-for="(col, index) in cols"
            :key="`col-${col.value}`">
          <PlfInput borderless
                    :disabled="disabled"
                    v-model="cols[index].label"
                    input-classes="rounded-bottom-0 border-bottom">
            <template #prefix>
              <slot name="column-icon"></slot>
            </template>
            <template v-if="cols.length > 1"
                      #suffix>
              <PlfButton class="btn-action rounded-circle"
                         @click="handleRemoveColumn(index)"
                         :disabled="disabled"
                         icon="mdi.IconRemove" />
            </template>
          </PlfInput>
        </li>
      </ul>

      <PlfButton class="btn-action align-self-end"
                 @click="addColumn"
                 :disabled="disabled"
                 icon="mdi.IconPlus" />
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import PlfInput from '../../shared/forms/PlfInput.vue';
import PlfButton from '../../shared/button/PlfButton.vue';

const emit = defineEmits(['update:modelValue']);

const props = defineProps({
  disabled: {
    type: Boolean,
    default: false
  },

  modelValue: {
    type: Object,
    default: () => ({})
  }
});

const rows = ref([
  {
    label: 'Row 1',
    value: 'row-1'
  }
]);

const cols = ref([
  {
    label: 'Column 1',
    value: 'column-1'
  }
]);

const addRow = () => {
  rows.value.push({
    label: `Row ${rows.value.length + 1}`,
    value: `row-${rows.value.length + 1}`
  });
};

const addColumn = () => {
  cols.value.push({
    label: `Column ${cols.value.length + 1}`,
    value: `column-${cols.value.length + 1}`
  });
};

const handleRemoveColumn = (index) => {
  cols.value = cols.value.filter((_, i) => i !== index);
};

const handleRemoveRow = (index) => {
  rows.value = rows.value.filter((_, i) => i !== index);
};

watch([rows, cols], () => {
  emit('update:modelValue', {
    ...props.modelValue,
    options: {
      rows: rows.value,
      cols: cols.value
    }
  });
}, { deep: true });

watch(() => props.modelValue, (newVal) => {
  if (newVal?.options?.rows) {
    rows.value = newVal.options.rows;
  }

  if (newVal?.options?.cols) {
    cols.value = newVal.options.cols;
  }
}, { immediate: true });
</script>