<template>
  <div class="position-relative">
    <img v-if="src"
         @load="onLoad"
         @error="onError"
         :src="src"
         :loading="loading"
         :decoding="decoding"
         :referrerpolicy="referrerPolicy"
         :srcset="srcset"
         :sizes="sizes"
         :crossorigin="crossorigin"
         :style="{height, width, fit}"
         :class="imgClass"
         :alt="alt"/>

    <div v-else
         :class="imgClass"
         :style="{height, width, fit}"/>

    <template v-if="!noSpinner">
      <div v-if="!loaded" class="position-absolute top-0 bottom-0 start-0 end-0 d-flex align-items-center justify-content-center">
        <slot name="loading"></slot>
      </div>

      <PlfInnerLoading v-if="!('loading' in $slots)"
                       :showing="!loaded"/>
    </template>
  </div>
</template>

<script setup>
import {ref, watch} from "vue";
import PlfInnerLoading from "../loading/PlfInnerLoading.vue";

const props = defineProps({
  src: {
    type: String,
    default: '',
  },

  loading: {
    type: String,
    default: 'eager',
  },

  crossorigin: {
    type: String,
    validator: value => ['anonymous', 'use-credentials'].includes(value),
  },

  decoding: {
    type: String,
    validator: value => ['async', 'auto', 'sync'].includes(value),
  },

  referrerPolicy: {
    type: String,
    validator: value => ['no-referrer', 'no-referrer-when-downgrade', 'origin', 'origin-when-cross-origin', 'unsafe-url'].includes(value),
  },

  noSpinner: {
    type: Boolean,
    default: false,
  },

  alt: {
    type: String,
  },

  srcset: {
    type: String,
  },

  sizes: {
    type: String,
  },

  height: {
    type: String,
  },

  width: {
    type: String,
  },

  fit: {
    type: String,
    default: 'cover',
    validator: value => ['fill', 'contain', 'cover', 'none', 'scale-down'].includes(value),
  },

  imgClass: {
    type: [String, Object, Array],
    default: '',
  },
});

const loaded = ref(true);

const onLoad = () => {
  loaded.value = true;
};

const onError = () => {
  loaded.value = true;
};

watch(() => props.src, (newValue) => {
  if (newValue) {
    loaded.value = false;
  }
});
</script>

<style scoped>

</style>
