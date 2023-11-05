<template>
  <div :style="{height, width}" :class="[`skeleton-${type}`, ]" class="skeleton"></div>
</template>

<script setup>
defineProps({
  type: String,
  size: {
    type: String,
    default: 'md',
    validator: (val) => ['sm', 'md', 'lg', 'xl'].includes(val)
  },

  height: {
    type: [String, Number],
    default: '10px'
  },
  width: {
    type: [String, Number],
    default: '100%',
  }
});
</script>

<style scoped>
.skeleton {
  animation: skeleton-loading 1s linear infinite alternate;
}

.skeleton.skeleton-text {
  height: 10px;
  width: 100%;
  border-radius: 3px;
}

.skeleton.skeleton-image {
  height: 50px !important;
  width: 50px !important;
  border-radius: 50%;
}

.skeleton.skeleton-button {
  height: 25px !important;
  width: 25px !important;
}

.skeleton.skeleton-text.lg {
  height: 20px;
}

@keyframes skeleton-loading {
  0% {
    background-color: hsl(200, 20%, 80%);
  }
  100% {
    background-color: hsl(200, 20%, 95%);
  }
}


</style>