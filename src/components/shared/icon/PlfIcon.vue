<template>
  <template v-if="Icon">
    <Icon class="icon" :class="iconClasses" />
  </template>
</template>

<script setup>
import * as tablerIcons from '@iconify-prerendered/vue-tabler';
// import * as biIcons from '@iconify-prerendered/vue-bi';
// import * as fa6RegularIcons from '@iconify-prerendered/vue-fa6-regular';
// import * as fa6SolidIcons from '@iconify-prerendered/vue-fa6-solid';
import * as mdiIcons from '@iconify-prerendered/vue-mdi';
import { computed } from 'vue';

const props = defineProps({
  name: {
    type: String
  },

  flip: {
    type: String,
    validator: (val) => ['horizontal', 'vertical', 'both'].includes(val)
  },

  inline: {
    type: Boolean
  }
});

const icons = {
  // 'bi': biIcons,
  // 'fa-solid': fa6SolidIcons,
  // 'fa-regular': fa6RegularIcons,
  'tblr': tablerIcons,
  'mdi': mdiIcons
};

const Icon = computed(() => {
  if (props.name) {
    const [iconSet, name] = props.name.split('.');

    if (iconSet in icons) {
      return icons[iconSet][name];
    }
  }

  return null;
});

const iconClasses = computed(() => {
  const flip = props.flip;

  const classes = [];

  if (flip) {
    classes.push(`flip-${flip}`);
  }

  if (props.inline) {
    classes.push('icon-inline');
  }

  return classes;
});
</script>

<style>
.icon * {
  stroke-width: 1 !important;
}

.icon {
  transition: all 0.2s ease-in-out !important;
}
</style>

<style scoped>
.icon.flip-horizontal {
  transform: scaleX(-1);
}

.icon.flip-vertical {
  transform: scaleY(-1);
}

.icon.flip-both {
  transform: scale(-1, -1);
}
</style>
