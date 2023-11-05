<template>
  <PlfTooltip :z-index="3000"
              square
              trigger="click">
    <template #content>
      <div class="px-3 py-2"
           style="width: 300px">
        <PlfSelect :z-index="5000"
                   square
                   :loading="loading"
                   option-label="name"
                   option-value="id"
                   v-model="activeFiscalYearId"
                   :label="$t('Active Fiscal Year')"
                   :placeholder="$t('Select an fiscal year')"
                   :options="fiscalYears">
          <template #option="{ option: { name, id } }">
            <div class="d-flex align-items-center gap-2"
                 @click="activeFiscalYearId = id"
                 :class="{ 'bg-indigo-lt': activeFiscalYearId === id }">
              <PlfCheckbox class="p-2 pe-0 border-end"
                           square
                           @click.stop
                           v-model="activeFiscalYearId"
                           :true-value="id" />

              <div class="pe-2">
                {{ name }}
              </div>
            </div>
          </template>
        </PlfSelect>
      </div>
    </template>

    <template #default>
      <PlfListItem nav
                   prepend-icon="mdi.IconCalendarMonthOutline" />
    </template>
  </PlfTooltip>
</template>

<script setup>
import { computed } from 'vue';
import PlfTooltip from '@/components/shared/tooltip/PlfTooltip.vue';
import PlfSelect from '@/components/shared/select/PlfSelect.vue';
import PlfCheckbox from '@/components/shared/checkbox/PlfCheckbox.vue';
import PlfListItem from '@/components/shared/list/PlfListItem.vue';
import { useAcademicYearsStore } from '@base/stores/academic-years';

defineProps({
  loading: {
    type: Boolean,
  },

  fiscalYears: {
    type: Array,
  }
});

const fiscalYearStore = useAcademicYearsStore();

let timer;

const activeFiscalYearId = computed({
  get: () => fiscalYearStore.activeFiscalYear,
  set: (newVal) => {
    if (newVal) {
      fiscalYearStore.activeFiscalYear = newVal;
    } else {
      fiscalYearStore.activeFiscalYear = null;
    }

    if (timer) clearTimeout(timer);

    timer = setTimeout(() => {
      localStorage.setItem('active-fiscal-year-id', JSON.stringify(newVal));

      location.reload();
    }, 1000);
  }
});
</script>