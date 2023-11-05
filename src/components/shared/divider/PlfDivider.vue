<template>
  <div :class="classes" class="m-0">
    <slot></slot>
  </div>
</template>

<script setup>
import { computed, useSlots } from 'vue';

const props = defineProps({
  vertical: {
    type: Boolean,
    default: false
  },

  textAlign: {
    type: String,
    default: null,
    validator: (val) => ['left', 'right'].includes(val)
  }
});

const slots = useSlots();

const classes = computed(() => {
  const classes = [];

  const orientation = props.vertical ? 'vr' : 'hr';

  if (slots.default) {
    classes.push(`${orientation}-text`);
  } else {
    classes.push(`${orientation}`);
  }

  if (props.textAlign) {
    classes.push(`hr-text-${props.textAlign}`);
  }

  return classes;
});
</script>
