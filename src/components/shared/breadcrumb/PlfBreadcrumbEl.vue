<template>
  <li class="breadcrumb-item d-flex align-items-center">
    <slot :label="label" :icon="icon">
      <router-link v-if="!!to" :exact="exact" :to="to" :active-class="activeClass"
        :exact-active-class="exactActiveClass">
        <PlfIcon v-if="icon" :name="icon" />
        {{ label }}
      </router-link>

      <template v-else>
        <slot name="icon" :icon="icon">
          <PlfIcon v-if="icon" :name="icon" />
        </slot>
        <slot name="label" :label="label">
          {{ label }}
        </slot>
      </template>
    </slot>
  </li>
</template>

<script setup>
import PlfIcon from '../icon/PlfIcon.vue';

defineProps({
  label: [String, Number, Boolean],
  icon: String,
  to: [String, Object],
  exact: Boolean,
  replace: Boolean,
  activeClass: String,
  exactActiveClass: String,
  href: String,
  target: String,

  disabled: {
    type: Boolean,
    default: () => false,
  }
})
</script>

<style scoped>

</style>
