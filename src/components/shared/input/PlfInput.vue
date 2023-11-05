<template>
  <div class="form-group"
       :class="{
         required,
         'plf-input-floating': floating,
         'row': inline,
       }">

    <slot v-if="!floating && isLabelVisible"
          name="label"
          :label="label">
      <label :class="{ 'col-md-3 col-form-label': inline, required }"
             class="form-label">
        {{ label }}
      </label>
    </slot>

    <div :class="computedInputContainer">
      <div class="d-flex flex-column-reverse">
        <slot name="error">
          <small v-for="error in errors"
                 :key="error"
                 class="mt-1 text-danger">
            {{ error }}
          </small>
        </slot>

        <slot name="hint">
          <small v-if="hint"
                 class="mt-1 text-muted">{{ hint }}</small>
        </slot>

        <div class="d-flex gap-2 align-items-center">
          <slot name="prefix"></slot>

          <div :class="computedInputWrapperClasses">
            <div class="d-flex px-2 gap-2 flex-row align-items-center">
              <div v-if="'prepend' in $slots">
                <slot name="prepend"></slot>
              </div>

              <div class="position-relative d-flex flex-fill flex-column-reverse">
                <component autocomplete="off"
                           :is="tagName"
                           :name="name"
                           ref="inputRef"
                           class="bg-transparent"
                           :value="inputValue"
                           v-bind="{ disabled, ...$attrs }"
                           :type="type"
                           :class="computedInputClasses"
                           :placeholder="computedPlaceholder"
                           @focus="onFocus"
                           @blur="onBlur"
                           @keyup="onKeyUp"
                           @input="onInput"
                           @focusin="onFocusIn"
                           @focusout="onFocusOut"
                           @mouseleave="onMouseLeave"
                           @mousemove="onMouseMove"
                           @change="onChange" />

                <label v-if="floating && label && isLabelVisible"
                       :class="computedLabelClasses">
                  {{ label }}
                </label>
              </div>
              <div class="ms-auto ">
                <div class="d-flex align-items-center gap-2">
                  <slot name="append"></slot>

                  <span v-if="loading"
                        class="spinner-border spinner-border-sm"></span>

                  <div v-if="inputValue && clearable"
                       class="cursor-pointer"
                       @click="onClear">
                    <PlfIcon name="tblr.IconX" />
                  </div>
                </div>
              </div>
            </div>
          </div>

          <slot name="suffix"></slot>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed, ref, watch } from "vue";
import PlfIcon from "../icon/PlfIcon.vue";

const emit = defineEmits([
  'update:modelValue',
  'focus',
  'blur',
  'mousemove',
  'mouseleave',
  'input',
  'change',
  "keyup",
  "focusin",
  "focusout",
  'clear'
]);

const props = defineProps({
  modelValue: {},

  modelModifiers: {},

  type: {
    type: String,
    default: () => 'text'
  },

  loading: {
    type: Boolean,
    default: false,
  },

  label: {
    type: String,
    default: '',
  },

  inline: {
    type: Boolean,
    default: false
  },

  errors: {
    type: Array,
    default: () => [],
  },

  floating: {
    type: Boolean,
    default: false
  },

  borderless: {
    type: Boolean,
    default: false
  },

  disabled: {
    type: Boolean,
    default: false
  },

  square: {
    type: Boolean,
    default: false
  },

  placeholder: {
    type: String,
    default: '',
  },

  invalid: {
    type: Boolean,
    default: false,
  },

  hint: {
    type: String,
    default: '',
  },

  clearable: {
    type: Boolean,
    default: false,
  },

  rounded: {
    type: Boolean,
    default: false,
  },

  name: {
    type: String,
  },

  hideLabel: {
    type: Boolean,
    default: false,
  },

  size: {
    type: String,
    default: 'md',
  },

  required: {
    type: Boolean,
    default: false,
  },

  inputClasses: {
    type: String,
    default: '',
  },

  color: {
    type: String,
    default: 'primary',
  },
});

const inputValue = ref('');

const computedModelValue = computed({
  get: () => props.modelValue,
  set: (newValue) => emit('update:modelValue', newValue)
});

const isLabelVisible = computed(() => {
  return props.label && !props.hideLabel;
});

const focused = ref(false);

const inputRef = ref(null);

const computedInputWrapperClasses = computed(() => {
  return {
    'plf-input-wrapper w-full': true,
    'invalid': props.invalid,
    'rounded-0': props.square,
    'rounded-2': !props.square,
    'rounded-pill': props.rounded,
    'borderless': props.borderless,
    'plf-input-focused': focused.value,
    'disabled': props.disabled,
    [props.inputClasses]: true
  };
});

watch(() => props.modelValue, (newValue) => {
  inputValue.value = newValue;
}, { immediate: true });

const computedInputClasses = computed(() => {
  return [
    'plf-input',
    {
      borderless: props.borderless,
      'rounded-0': props.square,
      'py-2': !props.floating && props.size === 'md',
      'py-1 lh-sm': !props.floating && props.size === 'sm',
      'py-03 lh-1': !props.floating && props.size === 'xs',
      'p-2': !props.label && props.floating,
    }
  ];
});

const computedLabelClasses = computed(() => {
  return [
    'form-label col-form-label bg-transparent',
    {
      'form-label-floating': (inputValue.value || focused.value) && props.floating && (inputValue.value !== '' || focused.value),
    }
  ];
});

const computedInputContainer = computed(() => {
  return {
    'd-flex flex-column-reverse': !props.floating,
    'col-md-9': props.inline && isLabelVisible.value,
  };
});

const computedPlaceholder = computed(() => {
  if (focused.value || !props.label) {
    return props.placeholder;
  }

  if (props.label && props.floating) {
    return '';
  }
  return props.placeholder;
});

const onFocus = ($event) => {
  focused.value = true;

  emit('focus', $event);
};

const onBlur = ($event) => {
  focused.value = false;

  emit('blur', $event);
};

const onInput = (e) => {
  if (props.disabled) return;

  inputValue.value = e.target.value;

  if (!props.modelModifiers?.lazy) computedModelValue.value = e.target.value;
};

const onKeyUp = (e) => {
  if (props.disabled) return;

  emit('keyup', e);
};

const onFocusIn = (e) => {
  if (props.disabled) return;

  emit('focusin', e);
};

const onFocusOut = (e) => {
  if (props.disabled) return;

  emit('focusout', e);
};

const onChange = (e) => {
  if (props.disabled) return;
  inputValue.value = e.target.value;
  if (props.modelModifiers?.lazy) computedModelValue.value = e.target.value;
}

const onClear = () => {
  const val = computedModelValue.value;

  computedModelValue.value = '';

  inputRef.value.focus();

  emit('clear', val);
};

const onMouseMove = ($event) => {
  if (props.disabled) return;

  emit('mousemove', $event);
}

const onMouseLeave = ($event) => {
  if (props.disabled) return;
  emit('mouseleave', $event);
}

const tagName = computed(() => {
  if (props.type === 'textarea') {
    return 'textarea';
  }
  return 'input';
});

const computedColor = computed(() => {
  const name = `--tblr-${props.color}`;

  return {
    name: `var(${name})`,
    rgb: `var(${name}-rgb)`,
  }
})

defineExpose({
  focus: () => inputRef.value.focus()
});
</script>

<style scoped>
.plf-input-floating {
  position: relative;
}

.plf-input {
  border: none;
  outline: none;
  width: 100%;
  padding: 0;
  margin: 0;
}

.plf-input-wrapper {
  border: 1px solid var(--tblr-border-color);
  transition: all .2s ease;
}

.plf-input-wrapper.borderless {
  border: none;
  box-shadow: none;
}

.plf-input-wrapper:not(.square) {
  border-radius: 0;
}

.plf-input-wrapper.invalid {
  border-color: rgba(var(--tblr-danger-rgb), .5) !important;
}

.plf-input-wrapper.plf-input-focused.invalid {
  box-shadow: 0 0 0 0.25rem rgba(var(--tblr-danger-rgb), .25);
}

.plf-input-focused {
  border-color: rgba(v-bind('computedColor.rgb'), .5);
  box-shadow: 0 0 0 0.25rem rgba(v-bind('computedColor.rgb'), .25);
}

.plf-input-floating label {
  top: 50%;
  transform: translateY(-50%);
  left: 0;
  position: absolute;
  z-index: 1;
  pointer-events: none;
  color: #6c757d;
  transition: all .2s ease;
}

[dir="rtl"] .plf-input-floating label {
  right: 0;
  left: auto;
}

.plf-input-floating .plf-input {
  padding-top: 1.5rem;
  padding-bottom: .5rem;
}

.plf-input-floating .form-label-floating {
  top: .7rem;
  font-size: .7rem;
  color: v-bind('computedColor.name');
}

[data-bs-theme='dark'] .plf-input {
  background-color: transparent;
  color: var(--tblr-white);
}

.plf-input-wrapper.disabled,
.plf-input-wrapper.disabled * {
  cursor: not-allowed !important;
  user-select: none;
}

.plf-input-wrapper.disabled {
  color: var(--tblr-secondary);
  background-color: rgba(var(--tblr-secondary-rgb), .05);
  user-select: none;
}
</style>
