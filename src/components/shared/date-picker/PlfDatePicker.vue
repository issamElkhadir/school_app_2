<template>
  <div class="form-group"
       :class="{ row: inline && !hideLabel }">
    <label class="form-label"
           v-if="!hideLabel && label"
           :class="{ 'col-md-3 col-form-label': inline, required }">
      {{ label }}
    </label>

    <div :class="{ 'col-md-9': inline }">
      <VDatePicker v-model="date"
                   :model-modifiers="modelModifiers"
                   ref="calendarRef"
                   :masks="masks"
                   :is-expanded="isExpanded"
                   :disabled-dates='disabledDates'
                   :available-dates='availableDates'
                   :title-position="titlePosition"
                   :trim-weeks="trimWeeks"
                   :hide-time-header="hideTimeHeader"
                   :show-weeknumbers="showWeeknumbers"
                   :show-iso-weeknumbers="showIsoWeeknumbers"
                   :rows="rows"
                   :columns="columns"
                   :step="step"
                   :min-date="minDate"
                   update-on-input
                   :max-date="maxDate"
                   :is-required="required"
                   :is24hr="is24hr"
                   :locale="locale"
                   :mode="mode"
                   :valid-hours="validHours"
                   :timezone="timezone"
                   :model-config="modelConfig"
                   :color="color"
                   :minute-increment="minuteIncrement"
                   :popover="popover"
                   :attributes="attributes"
                   :input-debounce="inputDebounce"
                   @drag="dragValue = $event"
                   :select-attribute="selectDragAttribute"
                   :drag-attribute="selectDragAttribute"
                   :is-range="isRange">
        <template v-if="useInput"
                  #default="{ inputValue, inputEvents }">
          <template v-if="isRange">
            <div class="d-flex align-items-center gap-2">
              <div class="flex-fill">
                <PlfInput :model-value="inputValue.start"
                          hide-label
                          :color="inputColor"
                          v-bind="$attrs"
                          @focus="inputEvents.start.focusin"
                          @blur="inputEvents.start.focusout">
                  <template #prepend>
                    <PlfIcon name="tblr.IconCalendar" />
                  </template>
                </PlfInput>
              </div>

              <PlfIcon class="flex-shrink-0"
                       name="tblr.IconArrowRight" />

              <div class="flex-fill">
                <PlfInput :model-value="inputValue.end"
                          hide-label
                          :color="inputColor"
                          v-bind="$attrs"
                          @focus="inputEvents.end.focusin"
                          @blur="inputEvents.end.focusout">
                  <template #prepend>
                    <PlfIcon name="tblr.IconCalendar" />
                  </template>
                </PlfInput>
              </div>
            </div>
          </template>

          <PlfInput v-else
                    v-bind="$attrs"
                    v-on="inputEvents"
                    :inline="inline"
                    :color="inputColor"
                    :clearable="clearable"
                    @clear="onClear"
                    @focus="inputEvents.focusin"
                    @blur="inputEvents.focusout"
                    :model-value="inputValue"
                    hide-label>
            <template #suffix="props">
              <slot name="suffix"
                    v-bind="props" />
            </template>

            <template #prefix="props">
              <slot name="prefix"
                    v-bind="props" />
            </template>

            <template #append="props">
              <slot name="append"
                    v-bind="props" />
            </template>

            <template #prepend>
              <slot name="prepend">
                <PlfIcon name="tblr.IconCalendar" />
              </slot>
            </template>
          </PlfInput>
        </template>
      </VDatePicker>
    </div>
  </div>
</template>

<script setup>
import 'v-calendar/dist/style.css';
import { DatePicker as VDatePicker } from 'v-calendar';
import { computed, ref, watch } from "vue";
import PlfInput from "../input/PlfInput.vue";
import PlfIcon from '../icon/PlfIcon.vue';

const emit = defineEmits(['update:modelValue']);

const props = defineProps({
  modelValue: {},

  modelModifiers: {
    type: Object,
    default: () => {
      return {};
    }
  },

  disabledDates: {},
  availableDates: {},

  label: {
    type: String,
  },

  hideLabel: {
    type: Boolean,
    default: () => false,
  },

  inline: {
    type: Boolean,
    default: () => false,
  },

  isExpanded: {
    type: Boolean,
    default: () => false,
  },

  titlePosition: {
    type: String,
    default: 'center',
    validator: (value) => {
      return ['left', 'center', 'right'].includes(value);
    }
  },

  trimWeeks: {
    type: Boolean,
    default: () => false,
  },

  showWeeknumbers: {
    type: [Boolean, String],
    default: () => false,
    validator(value) {
      return typeof value === 'boolean'
        ||
        ['left', 'right', 'left-outside', 'right-outside'].includes(value)
    }
  },

  showIsoWeeknumbers: {
    type: [Boolean, String],
    default: () => false,
    validator(value) {
      return typeof value === 'boolean'
        ||
        ['left', 'right', 'left-outside', 'right-outside'].includes(value)
    }
  },

  rows: {
    type: [Number, Object],
    default: () => 1,
  },

  columns: {
    type: [Number, Object],
    default: () => 1
  },

  step: {
    type: Number,
  },

  minDate: {
    type: Date,
  },

  maxDate: {
    type: Date,
  },

  isRange: {
    type: Boolean,
    default: false,
  },

  useInput: {
    type: Boolean,
    default: true,
  },

  mode: {
    type: String,
    default: () => 'single',
    validator(value) {
      return ["single", "date", "dateTime", "time"].includes(value)
    }
  },

  is24hr: {
    type: Boolean,
  },

  timezone: {
    type: String,
    required: false,
  },

  required: {
    type: Boolean,
    default: false,
  },

  validHours: {
    type: [Object, Array, Function],
  },

  minuteIncrement: {
    type: Number
  },

  modelConfig: {
    type: Object,
  },

  isDark: {
    type: Boolean,
    default: () => false,
  },

  color: {
    type: String,
    default: () => 'blue',
  },

  inputColor: {
    type: String,
    default: () => 'primary',
  },

  locale: {
    type: [String, Object],
  },

  popover: {
    type: Object,
    default: () => {
      return {};
    }
  },

  inputDebounce: {
    type: Number,
  },

  masks: {
    type: Object,
  },

  clearable: {
    type: Boolean,
    default: false,
  },

  attributes: {
    type: Array,
    default: () => {
      return [
        {
          key: 'today',
          highlight: {
            color: 'orange',
            fillMode: 'light',
          },
          dates: new Date(),
        },
      ]
    }
  },

  hideTimeHeader: {
    type: Boolean,
    default: false,
  },
});

const date = ref(null);
const calendarRef = ref();

const dragValue = ref(null);

const selectDragAttribute = computed(() => {
  return {
    popover: {
      visibility: 'hover',
      isInteractive: true, // Defaults to true when using slot
    },
  };
});

const onClear = () => {
  date.value = null;
}

watch(() => props.modelValue, (newValue) => {
  date.value = newValue;
}, { immediate: true });

watch(date, (newValue) => {
  emit('update:modelValue', newValue);
});
</script>

<style>
/*.vc-day.is-not-in-month * {*/
/*  opacity: 1;*/
/*  pointer-events: auto;*/
/*  color: rgba(25, 24, 26, .4);*/
/*}*/
</style>
