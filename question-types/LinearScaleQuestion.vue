<template>
  <div class="d-flex flex-column gap-2">
    <div class="d-flex align-items-center gap-3">
      <PlfTooltip :z-index="2000"
                  trigger="click"
                  :show-arrow="false"
                  popper-classes="shadow"
                  :disabled="disabled"
                  placement="right">
        <PlfButton class="p-2 border-0"
                   :disabled="disabled">
          <div class="d-flex gap-3 justify-content-between">
            <span>{{ options.from.value }}</span>
            <PlfIcon name="mdi.IconMenuDown"
                     class="m-0" />
          </div>
        </PlfButton>

        <template #content>
          <PlfList class="gap-0"
                   v-model:selected="options.from.value">
            <PlfListItem v-for="i in 10"
                         :key="`option-${i}`"
                         :value="i"
                         :title="i"
                         class="mt-0 ps-3 pe-4" />
          </PlfList>
        </template>
      </PlfTooltip>

      {{ $t('to') }}

      <PlfTooltip :z-index="2000"
                  trigger="click"
                  :show-arrow="false"
                  :disabled="disabled"
                  popper-classes="shadow"
                  placement="right">
        <PlfButton class="p-2 border-0"
                   :disabled="disabled">
          <div class="d-flex gap-3 justify-content-between">
            <span>{{ options.to.value }}</span>
            <PlfIcon name="mdi.IconMenuDown"
                     class="m-0" />
          </div>
        </PlfButton>

        <template #content>
          <PlfList v-model:selected="options.to.value">
            <PlfListItem v-for="i in 10"
                         :key="`option-${i}`"
                         :value="i"
                         :title="i"
                         class="mt-0 ps-3 pe-4" />
          </PlfList>
        </template>
      </PlfTooltip>
    </div>

    <div class="w-50">
      <PlfInput borderless
                :disabled="disabled"
                placeholder="Label (optional)"
                v-model="options.from.label"
                input-classes="rounded-bottom-0 border-bottom">
        <template #prefix>
          <span class="w-4">
            {{ options.from.value }}
          </span>
        </template>
      </PlfInput>

    </div>

    <div class="w-50">
      <PlfInput borderless
                :disabled="disabled"
                placeholder="Label (optional)"
                v-model="options.to.label"
                input-classes="rounded-bottom-0 border-bottom">
        <template #prefix>
          <span class="w-4">
            {{ options.to.value }}
          </span>
        </template>
      </PlfInput>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import PlfIcon from '../../shared/icon/PlfIcon.vue';
import PlfTooltip from '../../shared/tooltip/PlfTooltip.vue';
import PlfList from '../../shared/list/PlfList.vue';
import PlfListItem from '../../shared/list/PlfListItem.vue';
import PlfButton from '../../shared/button/PlfButton.vue';
import PlfInput from '../../shared/forms/PlfInput.vue';

const emit = defineEmits(['update:modelValue']);

const props = defineProps({
  modelValue: {
    type: Object,
    default: () => ({})
  },

  disabled: {
    type: Boolean,
    default: false
  }
});

const options = ref({
  from: {
    value: 1,
    label: ''
  },
  to: {
    value: 10,
    label: ''
  },
});

watch(() => props.modelValue, (newVal) => {

  if (newVal?.options && typeof newVal.options === 'object') {
    options.value.from = newVal.options.from || { label: '', value: 1 };
    options.value.to = newVal.options.to || { label: '', value: 10 };
  }
}, { immediate: true });

watch(options, (newVal) => {
  emit('update:modelValue', {
    ...props.modelValue,
    options: newVal
  });
}, { deep: true });
</script>