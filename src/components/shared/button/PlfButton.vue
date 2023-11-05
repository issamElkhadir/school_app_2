<template>
  <component :is="component"
             class="btn position-relative overflow-hidden"
             type="button"
             @click="onClick"
             v-bind="btnProps">
    <slot>
      <span v-if="loading"
            :class="[iconClass, { 'me-2': label }]" />

      <PlfIcon v-if="icon && !loading"
               :name="icon"
               :inline="!!label"
               :class="iconClass" />

      <span>{{ label }}</span>

      <span v-if="!label && !icon">&nbsp;</span>

      <span v-if="badge"
            class="badge ms-2"
            :class="badgeClass">
        {{ badge }}
      </span>

      <PlfIcon v-if="iconRight"
               :name="iconRight"
               :inline="true"
               class="ms-1 me-0"
               :class="iconClass" />
    </slot>
  </component>
</template>

<script setup>
import { computed } from "vue";
import PlfIcon from "../icon/PlfIcon.vue";

const emit = defineEmits(['click']);

const props = defineProps({
  label: {
    type: String
  },

  disabled: {
    type: Boolean,
    default: false
  },

  icon: {
    type: String
  },

  iconRight: {
    type: String
  },

  loadingIcon: {
    type: String,
    default: 'spinner-border spinner-border-sm'
  },
  badge: {
    type: String
  },
  badgeClass: {
    type: String,
    default: null
  },
  loading: {
    type: Boolean,
    default: false
  },
  square: {
    type: Boolean,
    default: false
  },

  color: {
    type: String
  },

  textColor: {
    type: String
  },

  to: {
    type: [String, Object]
  },

  href: {
    type: String
  },

  target: {
    type: String
  },

  iconClasses: {
    type: [String, Array, Object]
  }
});

const disabled = computed(() => {
  return props.disabled || props.loading;
});

const iconClass = computed(() => {
  const classes = [
    {
      [props.loadingIcon]: props.loading
    }
  ];

  if (typeof props.iconClasses === 'string') {
    classes.push(props.iconClasses);
  } else if (Array.isArray(props.iconClasses)) {
    classes.push(...props.iconClasses);
  } else if (typeof props.iconClasses === 'object') {
    classes.push(props.iconClasses);
  }

  return classes;
});

const component = computed(() => {
  if (props.href) return 'a';

  if (props.to) return 'router-link';

  return 'button';
});

const classes = computed(() => {
  const classes = {
    'btn-square': props.square,
    'btn-loading': props.loading,
    'btn-icon': props.icon && !props.label,
    [`text-${props.textColor}`]: !!props.textColor,
    [`btn-${props.color}`]: !!props.color,
  };

  return classes;
});

const onClick = (e) => {
  if (disabled.value) {
    e.preventDefault();

    return;
  }

  emit('click', e);

  // Add ripple effect
  // const target = e.target;

  // const rect = target.getBoundingClientRect();
  // const ripple = document.createElement('span');

  // ripple.setAttribute('class', 'ripple');

  // ripple.style.left = `${e.clientX - rect.left}px`;
  // ripple.style.top = `${e.clientY - rect.top}px`;

  // target.appendChild(ripple);

  // setTimeout(() => {
  //   ripple.remove();
  // }, 800);
}

const btnProps = computed(() => {
  const _props = {
    class: classes.value,
    disabled: props.disabled,
    target: props.target
  };

  if (props.href) {
    _props.href = props.href;
  } else if (props.to) {
    _props.to = props.to;
  }

  return _props;
});
</script>

<style scoped></style>
