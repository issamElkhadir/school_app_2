<template>
  <nav-link to=""
    class="modeLink rounded cursor-pointer"
    :class="{ activeLink: active }"
  >{{ $t(text) }}</nav-link>
</template>
<script setup>
import { defineProps } from 'vue';

const props = defineProps({
  text: String,
  mode: String,
  active: Boolean,
});
</script>

<style scoped>
.modeLink {
  text-decoration: none;
  color: #3c4043;
  font-size: 18px;
  font-weight: 600;
  padding: 10px 20px;
  transition: color 0.3s, background-color 0.3s;
  position: relative;
}
@media (max-width: 768px) {
  .modeLink {
    padding: 8px 16px;
    font-size: 16px;
  }
}

.modeLink:hover {
  background-color: #f1f5f9;
}

.activeLink {
  color: #206BC4;
  font-weight: 700;
}

.activeLink::before {
  content: '';
  position: absolute;
  bottom: -3px;
  left: 0;
  width: 100%;
  height: 3px;
  background-color: #206BC4;
  transform-origin: left;
  transform: scaleX(0);
  transition: transform 0.3s ease-in-out;
}

.activeLink::before {
  transform: scaleX(1);
}
</style>
