<template>
  <div class="form-group"
       v-outside-click="onOutsideClick"
       :class="{ row: inline }">
    <label v-if="!hideLabel && label"
           :class="{ 'col-md-3 col-form-label': inline, required }"
           class="form-label">
      {{ label }}
    </label>

    <div :class="{ 'col-md-9': inline && !hideLabel }">
      <div class="d-flex flex-column">
        <div class="w-100 d-flex gap-2">
          <div class="d-flex flex-column overflow-hidden flex-grow-1 plf-select-wrapper"
               tabindex="0"
               @focus="onFocus"
               @blur="onBlur"
               @click="onToggle"
               :style="style"
               :class="selectClasses">
            <div class="plf-select">
              <div ref="trigger"
                   class="d-flex gap-2 justify-content-between align-items-center"
                   :class="{
                     'lh-sm p-2': size === 'md',
                     'lh-md py-03 px-1': size === 'sm',
                     'py-03 px-1': size === 'xs',
                     'cursor-pointer': !disabled,
                   }">
                <slot name="select-header"
                      :selected="modelValue"
                      :option="getOption(modelValue)"
                      :clear="clear"
                      :loading="loading">
                  <div class="plf-select-header text-truncate overflow-auto scroll-hidden user-select-none">
                    <div class="d-flex gap-2 me-2">
                      <slot name="prepend"></slot>

                      <div class="d-flex flex-row-reverse gap-1">
                        <template v-if="useChips">
                          <template v-if="selectedOptions.length > 0">
                            <PlfChip v-for="item in selectedOptions"
                                     :key="item"
                                     :removable="!disabled"
                                     :label="item[optionLabel]"
                                     color="primary"
                                     classes="remove-button badge-sm"
                                     rounded>
                              <template #remove>
                                <PlfIcon name="tblr.IconX"
                                         class="remove-icon cursor-pointer"
                                         @click.stop="onSelect(item)" />
                              </template>
                            </PlfChip>
                          </template>

                          <div v-else>{{ placeholder || '&nbsp;' }}</div>
                        </template>

                        <div v-else-if="selectedOptions.length > 0">
                          <slot name="selected-options-header"
                                :selected="modelValue"
                                :option="getOption(modelValue)"
                                :loading="loading"
                                :selected-options-label="computedSelectedOptionsLabel">
                            {{ computedSelectedOptionsLabel }}
                          </slot>
                        </div>

                        <div v-else>
                          <slot name="label">
                            {{ placeholder || '&nbsp;' }}
                          </slot>
                        </div>
                      </div>
                    </div>

                  </div>
                </slot>

                <div class="d-inline-flex align-items-center">
                  <div class="d-flex align-items-center">
                    <span class="spinner spinner-border spinner-border-sm mb-0 pb-0 me-2 "
                          :class="{ 'd-none': !loading }"></span>
                    <PlfIcon name="tblr.IconX"
                             @click.stop="clear"
                             v-if="clearable && selectedOptions.length > 0"
                             class="cursor-pointer" />
                    <slot name="append"></slot>
                  </div>

                  <PlfIcon name="tblr.IconChevronDown" />
                </div>
              </div>
            </div>
          </div>

          <slot name="suffix" />
        </div>

        <slot name="error">
          <small v-for="error in errors"
                 :key="error"
                 class="d-block mt-1 text-danger">
            {{ error }}
          </small>
        </slot>
      </div>
    </div>
  </div>

  <PlfTooltip trigger="click"
              ref="tooltip"
              tabindex="-1"
              :placement="placement"
              :fallback-placements="fallbackPlacements"
              :zIndex="zIndex"
              :show-after="200"
              :teleported="true"
              :virtual-ref="$refs.trigger"
              fit-content-width
              enterable
              manual
              :show-arrow="!hideArrow"
              :popper-classes="{ 'shadow': true }"
              :popper-style="{ 'max-width': internalMaxWidth }"
              :square="square"
              :disabled="disabled"
              :visible="isVisible && (!loading || !!optionsMutation)">
    <template #content>
      <div :style="{ 'max-width': internalMaxWidth }">
        <div v-if="computedOriginalOptions && !hideOptionsHeader"
             :class="{ 'bg-secondary-lt': !searchable }"
             class="d-flex flex-column">
          <div class="d-flex align-items-center">
            <PlfCheckbox v-if="multiselect && !maxValues"
                         :square="square"
                         class="ps-2 py-2 d-inline-block"
                         :model-value="isAllSelected"
                         @update:modelValue="selectAll"
                         tab-index="0" />

            <div v-if="searchable"
                 class="p-2 flex-fill">
              <PlfInput hide-label
                        type="text"
                        clearable
                        :size="size"
                        :square="square"
                        :class="classes"
                        placeholder="Search"
                        @update:modelValue="onFilter"
                        v-model="searchValue" />
            </div>
          </div>

          <PlfDivider v-if="searchable || (multiselect && !maxValues)" />
        </div>

        <div :style="{ maxHeight: optionsHeight }"
             @scroll="onScroll"
             class="plf-select-options-container overflow-auto">
          <slot name="before-first" />

          <div v-if="optionsMutation && optionsMutation.length">
            <div class="plf-select-option"
                 tabindex="0"
                 v-for="(option, index) in optionsMutation"
                 :key="`option-${index}`"
                 :class="{
                   selected: isSelected(option),
                   disabled: disabledOptions.includes(getOptionValue(option))
                 }"
                 @keyup.space.prevent="onSelect(option)">

              <div>
                <slot name="option"
                      :options="optionsMutation"
                      :index="index"
                      :on-select="onSelect"
                      :selected="selectedOptions"
                      :disabledOptions="disabledOptions"
                      :is-selected="isSelected(option)"
                      :option="option">
                  <PlfCheckbox v-if="multiselect"
                               binary
                               :square="square"
                               class="p-2"
                               :disabled="disabledOptions.includes(getOptionValue(option))"
                               :value="getOptionValue(option)"
                               :model-value="selectedOptionsValues"
                               @update:modelValue="onSelect(option)"
                               :label="getOptionLabel(option)"
                               tab-index="-1" />
                  <div v-else
                       @click="onSelect(option)"
                       class="border-0 rounded-0 p-2"
                       :class="[{ 'disabled ': disabledOptions.includes(getOptionValue(option)) }]">
                    <span>{{ getOptionLabel(option) }}</span>
                  </div>
                </slot>
              </div>

            </div>
          </div>

          <slot name="no-option"
                v-else-if="(!computedOriginalOptions || !computedOriginalOptions?.length)">
            <div class="p-2">{{ noDataText }}</div>
          </slot>

          <slot name="no-filter-match"
                v-else>
            <div class="p-2">{{ noMatchText }}</div>
          </slot>

          <slot name="after-last"></slot>
        </div>
      </div>
    </template>
  </PlfTooltip>
</template>

<script setup>
import PlfCheckbox from "../checkbox/PlfCheckbox.vue";
import PlfChip from "../chip/PlfChip.vue";

import { computed, ref, watch } from "vue";
import PlfTooltip from "../tooltip/PlfTooltip.vue";
import vOutsideClick from '../../../directives/outside-click.js';
import PlfInput from "../input/PlfInput.vue";
import PlfDivider from "../divider/PlfDivider.vue";
import PlfIcon from "../icon/PlfIcon.vue";

import selectProps from './select-props';
import { toUnit } from "../../../composables/utils";

const emit = defineEmits(['update:modelValue', 'filter', 'load', 'scroll']);

const props = defineProps(selectProps);

const isVisible = ref(false);
const focused = ref(false);

const selectRef = ref();
const tooltip = ref();

const internalMaxWidth = computed(() => {
  if (props.maxWidth) return toUnit(props.maxWidth);

  if (!props.dropdownFitContent) return 'auto';

  if (selectRef.value) {
    return toUnit(selectRef.value.offsetWidth);
  }

  return 'auto';
});

const computedOriginalOptions = computed(() => {
  if (!Array.isArray(props.options) || !props.options) return null;

  return props.options.map(option => {
    if (typeof option === 'object') {
      return {
        ...option,
        [props.optionLabel]: getOptionLabel(option),
        [props.optionValue]: getOptionValue(option),
      };
    } else {
      return {
        [props.optionLabel]: option,
        [props.optionValue]: option,
      }
    }
  })
})

const selectClasses = computed(() => {
  const classes = [
    { 'invalid': props.invalid },
    { 'disabled': props.disabled },
    { 'borderless': props.borderless },
    { 'plf-select-focused': focused.value },
    { 'border-0': props.borderless },
    { 'bg-primary': props.filled || (props.standout && isVisible.value) },
    { 'border-2': props.outlined },
    { 'rounded-pill': props.rounded },
    { 'rounded-2': !props.square },
    { 'rounded-0': props.square },
    { 'bg-transparent': props.transparent },
  ];

  if (Array.isArray(props.classes)) {
    return classes.concat(...props.classes);
  } else if (['object', 'string'].includes(typeof props.classes)) {
    return classes.concat(props.classes);
  } else {
    return classes;
  }
});

const searchValue = ref("");

let inputDebounceTimer;

const selectedOptions = computed({
  get() {
    const val = props.modelValue !== void 0 && (props.modelValue !== null)
      ? (props.multiselect === true && Array.isArray(props.modelValue) ? props.modelValue : [props.modelValue])
      : []

    if (Array.isArray(props.options) === true) {

      const values = val.filter(e => e !== null)
        .map(v => {
          if (!(typeof v === 'object')) {
            return getOption(v);
          }
          return v;
        });

      return props.modelValue === null
        ? values.filter(v => v !== null)
        : values
    }

    return val
  },
  set(value) {
    if (inputDebounceTimer) {
      clearTimeout(inputDebounceTimer);
      inputDebounceTimer = null;
    }

    inputDebounceTimer = setTimeout(() => {
      emit('update:modelValue', value);
    }, props.inputDebounce);
  }
});

function getOption(value) {
  const fn = opt => getOptionValue(opt) === value;

  if (!props.options) return value;

  return props.options.find(fn) || value;
}

const onSelect = (option) => {

  if (!props.options) {
    return selectedOptions.value = selectedOptions.value.filter(item => getOptionValue(item) !== getOptionValue(option));
  }

  focused.value = false;
  if (disabledOptions.value.includes(getOptionValue(option))) return;

  let newValue = selectedOptions.value;
  const optionIndex = newValue.findIndex((item) => getOptionValue(item) === getOptionValue(option));
  if (props.multiselect) {
    newValue = [...selectedOptions.value];
    if (optionIndex > -1) {
      newValue = newValue.filter(item => getOptionValue(item) !== getOptionValue(option));
    } else {
      newValue.push(option);
    }
  } else {
    if (optionIndex > -1) {
      if (props.clearable) {
        newValue = null;
      } else {
        newValue = option;
      }
    } else {
      newValue = option;
    }
  }

  if (props.emitValue) {
    if (props.multiselect) {
      selectedOptions.value = newValue.map(item => getOptionValue(item));
    } else {
      selectedOptions.value = getOptionValue(newValue);
    }
  } else {
    selectedOptions.value = newValue;
  }

  if (props.closeOnSelect === true) {
    isVisible.value = false;
  }

  focused.value = true;
}

const clear = () => {
  if (props.multiselect) {
    selectedOptions.value = [];
  } else {
    selectedOptions.value = null;
  }
}

const computedFilterFn = computed(() => {
  if (props.filterFn) return props.filterFn

  return (searchValue, { mappedOptions }) => {
    if (mappedOptions) {

      let filterFields = [props.optionLabel];
      if (props.filterFields) {
        filterFields = props.filterFields;
      }

      const needle = searchValue.toLowerCase();

      optionsMutation.value = mappedOptions.filter(v => {
        return filterFields.some(field => {
          return v[field] && v[field].toString().toLowerCase().includes(needle);
        })
      });
    }
  }
})

let timer;
const onFilter = async () => {

  const options = {
    mappedOptions: computedOriginalOptions.value,
    options: props.options,
  }

  clearTimeout(timer);

  timer = setTimeout(() => {
    computedFilterFn.value(searchValue.value, options);
  }, props.debounce);
}

const onLoad = async () => {
  if (props.options != null) return;
  return emit('load');
}

const optionsMutation = ref(null);

const disabledOptions = computed(() => {
  let disabled = props.options.filter(option => isOptionDisabled(option));
  if (props.multiselect) {
    if (props.maxValues && selectedOptions.value.length >= props.maxValues) {
      disabled = props.options.filter(option => isOptionDisabled(option) || selectedOptions.value.findIndex((item) => getOptionValue(item) === getOptionValue(option)) === -1);
    }
  }
  return disabled.map(option => getOptionValue(option));
})

const isOptionDisabled = (option) => {
  if (typeof option === 'object') {
    return option.disabled;
  }
  return false;
}

const getOptionLabel = (option) => {
  if (typeof option === 'object') {
    return option[props.optionLabel];
  }

  return option;
}

const getOptionValue = (option) => {
  if (typeof option === 'object') {
    return option[props.optionValue];
  }
  return option;
}


const isAllSelected = computed(() => {
  if (!optionsMutation.value) return false;

  const selectedValues = selectedOptions.value.map(item => getOptionValue(item));
  const notDisabled = optionsMutation.value.filter(item => !isOptionDisabled(item));
  return notDisabled.every(item => {
    return selectedValues.includes(getOptionValue(item));
  })

})
const selectAll = () => {
  if (isAllSelected.value) {
    const optionsValues = optionsMutation.value.map(item => getOptionValue(item));
    selectedOptions.value = selectedOptions.value.filter(item => !optionsValues.includes(getOptionValue(item)))

  } else if (props.emitValue) {
    selectedOptions.value = optionsMutation.value
      .filter(item => !disabledOptions.value.includes(getOptionValue(item)))
      .filter(item => !selectedOptions.value.includes(getOptionValue(item)))
      .map(item => {
        return getOptionValue(item);
      }).concat(selectedOptions.value);
  } else {
    const selectedValues = selectedOptions.value.map(item => getOptionValue(item));

    selectedOptions.value = optionsMutation.value
      .filter(item => !disabledOptions.value.includes(getOptionValue(item)))
      .filter(item => !selectedValues.includes(getOptionValue(item)))
      .concat(selectedOptions.value);
  }

}

const computedSelectedOptionsLabel = computed(() => {
  return selectedOptions.value.map(item => {
    if (typeof item === 'object') {
      return item?.[props.optionLabel];
    } else {
      return item;
    }
  }).join(", ");
});

watch(() => props.options, (newVal) => {
  if (!newVal) return optionsMutation.value = null;

  optionsMutation.value = newVal.map(option => {
    if (typeof option === 'object') {
      return {
        ...option,
        [props.optionLabel]: getOptionLabel(option),
        [props.optionValue]: getOptionValue(option),
      };
    } else {
      return {
        [props.optionLabel]: option,
        [props.optionValue]: option,
      }
    }
  })
}, { immediate: true });

const selectedOptionsValues = computed(() => selectedOptions.value.map(item => getOptionValue(item)));

const isSelected = (option) => {
  return selectedOptionsValues.value.includes(getOptionValue(option));
};


const onToggle = () => {
  if (props.disabled) return;
  if (isVisible.value) {
    isVisible.value = false;
  } else {
    onLoad().then(() => {
      isVisible.value = true;
      focused.value = true;
    });
  }
}

const onFocus = () => {
  if (props.disabled) return;

  focused.value = true;
}

const onBlur = () => {
  if (props.disabled) return;

  focused.value = false;
}

const placement = 'bottom';

const fallbackPlacements = [
  'bottom-start',
  'bottom-end',
  'top-start',
  'top-end',
  'right-start',
  'left-start',
];

const onOutsideClick = (evt) => {
  if (!tooltip.value.floating.contains(evt.target)) {
    focused.value = false;
    isVisible.value = false;
  }
}

const onScroll = (evt) => {
  emit('scroll', evt);
}
</script>


<style scoped>
.plf-select-option {
  outline: none;
  /* Prevent blue border */
  cursor: pointer;
}

.plf-select-option:hover:not(.disabled) {
  background-color: var(--tblr-gray-100);
}

[data-bs-theme='dark'] .plf-select-option:hover:not(.disabled) {
  background-color: var(--tblr-gray);
}

.plf-select-option.disabled * {
  cursor: not-allowed !important;
}

.plf-select-option.selected,
.plf-select-option:active:not(.disabled),
.plf-select-option:focus:not(.disabled) {
  color: var(--tblr-primary);
  background-color: rgba(var(--tblr-primary-rgb), .05) !important;
}

.plf-select-options-container {
  background-color: var(--tblr-white);
}

[data-bs-theme='dark'] .plf-select-options-container {
  background-color: var(--tblr-dark);
}

[data-bs-theme='dark'] .plf-select {
  background-color: var(--tblr-dark);
  color: var(--tblr-white);
}

.plf-select-header {
  width: 100%;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.plf-select-header {
  outline: none;
}

.plf-select-wrapper:not(.borderless) {
  outline: none;
  transition: all .2s ease;
  border: 1px solid var(--tblr-border-color);
}

.plf-select-wrapper.plf-select-focused:not(.borderless) {
  border-color: rgba(var(--tblr-primary-rgb), .5);
  box-shadow: 0 0 0 0.25rem rgba(var(--tblr-primary-rgb), .25);
}

.plf-select-wrapper.disabled {
  color: var(--tblr-secondary) !important;
  background-color: rgba(var(--tblr-secondary-rgb), .05) !important;
  user-select: none;
}

body[data-bs-theme='dark'] .plf-select-wrapper:not(.transparent.disabled) {
  background-color: var(--tblr-dark);
}

.remove-icon {
  height: 14px;
  width: 14px;
  padding: 1px;
  border-radius: 50%;
}

.remove-icon:hover {
  background-color: var(--tblr-white);
  color: var(--tblr-primary);
}

.plf-select-wrapper.invalid {
  border-color: rgba(var(--tblr-danger-rgb), .5) !important;
}

.plf-select-wrapper.plf-select-focused.invalid {
  box-shadow: 0 0 0 0.25rem rgba(var(--tblr-danger-rgb), .25);
}
</style>
