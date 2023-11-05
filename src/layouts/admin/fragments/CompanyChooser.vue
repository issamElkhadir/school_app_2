<template>
  <PlfSelect :loading="loading"
             :options="companies"
             hide-options-header
             v-model="activeCompanies"
             option-label="name"
             option-value="id"
             multiselect
             emit-value
             style="min-width: 50%"
             square>
    <template #option="{ option }">
      <div class="d-flex align-items-center gap-2"
           :class="{ 'bg-indigo-lt': option.id === activeCompanies[0] }"
           @click="onCompanyClicked(option, true)">
        <PlfCheckbox :model-value="activeCompanies"
                     @update:modelValue="onCompanyClicked(option, false)"
                     @click.stop
                     class="p-2 pe-0 border-end"
                     square
                     :value="option.id" />

        <div class="pe-2">
          {{ option.name }}
        </div>
      </div>
    </template>
  </PlfSelect>
</template>

<script setup>
import { watch, computed } from 'vue';
import PlfCheckbox from '@/components/shared/checkbox/PlfCheckbox.vue';
import PlfSelect from '@/components/shared/select/PlfSelect.vue';

const props = defineProps({
  companies: {
    type: Array,
  },

  loading: {
    type: Boolean,
  }
});

const activeCompanies = computed({
  get: () => {
    if (props.companies.length === 0) return [];

    return [];
  },
  set: (val) => {
    localStorage.setItem('active-companies', JSON.stringify(val), new Date().setMonth(12), '/');
  }
});

let companyChooserTimeout;

// Switch the companies order
const onCompanyClicked = (company, prepend = false) => {
  const value = company.id;

  if (prepend) {
    activeCompanies.value = [value, ...activeCompanies.value.filter(e => e !== value)];
  } else if (activeCompanies.value.includes(value)) {
    activeCompanies.value = activeCompanies.value.filter(e => e !== value);
  } else {
    activeCompanies.value = [...activeCompanies.value, value];
  }

  clearTimeout(companyChooserTimeout);

  companyChooserTimeout = setTimeout(() => {
    location.reload();
  }, 1000);
}

watch(() => props.companies, (val) => {
  if (activeCompanies.value.length === 0) {
    activeCompanies.value = [val[0]?.id];
  } else {
    activeCompanies.value = activeCompanies.value.filter(e => val.map(s => s.id).includes(e));

    if (activeCompanies.value.length === 0) {
      activeCompanies.value = [val[0]?.id];
    }
  }
}, { deep: true });
</script>