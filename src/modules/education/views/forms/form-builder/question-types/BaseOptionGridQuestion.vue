<template>
  <div>
    <label class="mb-2 form-label"
           :class="{ required: question.is_required }">
      {{ question.title }}
    </label>
    <table class="table table-borderless table-vcenter">
      <caption v-if="question.description">
        <small>
          {{ question.description }}
        </small>
      </caption>

      <thead>
        <tr>
          <th></th>

          <th v-for="option in question.options.cols"
              :key="option.id">
            {{ option.label }}
          </th>
        </tr>
      </thead>

      <tbody>
        <tr v-for="row in question.options.rows"
            :key="row.value">
          <th>{{ row.label }}</th>

          <td v-for="col in question.options.cols"
              :key="col.value">
            <slot name="option"
                  :col="col"
                  :row="row"
                  :value="value"
                  :onInput="val => value[row.value] = val" />
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue';

const emit = defineEmits([
  'update:modelValue',
]);

const props = defineProps({
  question: {
    type: Object,
    required: true
  },

  modelValue: {
    type: Object
  }
});

const value = ref({});

watch(() => props.modelValue, val => {
  if (val && typeof val === 'object') {
    value.value = val;
  }
}, { immediate: true });

watch(value, val => {
  emit('update:modelValue', val);
}, { deep: true });
</script>

<style scoped>
.table {
  border-spacing: 0em .3em;
  border-collapse: separate;
  table-layout: fixed;
}

.table tbody tr td,
.table tbody tr th {
  background-color: var(--tblr-gray-100);
  padding-block: 1.3em;
}

.table tbody th:first-child {
  border-start-start-radius: var(--tblr-border-radius);
  border-end-start-radius: var(--tblr-border-radius);
}

.table tbody td:last-child {
  border-end-end-radius: var(--tblr-border-radius);
  border-start-end-radius: var(--tblr-border-radius);
}

.table thead th {
  font-size: .8em;
}
</style>