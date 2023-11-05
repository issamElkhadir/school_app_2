<template>
  <PlfToast />
  <RouterView />
</template>

<script setup>
import { RouterView } from 'vue-router'
import PlfToast from './components/shared/toast/PlfToast.vue';
import rtlCss from '@tabler/core/dist/css/tabler.rtl.min.css?raw';
import ltrCss from '@tabler/core/dist/css/tabler.min.css?raw';

import './assets/main.css';
import { useLocale } from './composables/browser/useLocale';
import { i18n } from './boot/i18n';
import { watch } from 'vue';
import { useStyleTag } from '@vueuse/core';

const { css } = useStyleTag()

const { isRTL } = useLocale(i18n);

watch(isRTL, (val) => {
  if (val) {
    css.value = rtlCss;
  } else {
    css.value = ltrCss;
  }
}, { immediate: true })
</script>