<template>
  <div class="h-btn-container w-auto position-relative">
    <button class="bg-transparent p-2 rounded-circle">
      <PlfIcon :name="icon" :style="iconStyle" :to="{ name: 'admin.forms.create.preview' }" />
    </button>
    <div v-if="tooltipText" class="h-btn-tooltip position-absolute p-2 rounded">{{ tooltipText }}</div>
  </div>
</template>
<script setup>
import PlfIcon from '@/components/shared/icon/PlfIcon.vue';
import { ref, onMounted, onBeforeUnmount, watch } from 'vue';

const props = defineProps({
  icon: {
    type: String,
    default: ''
  },
  tooltipText: {
    type: String,
    default: ''
  },
  iconSizePx: {
    type: String,
    default: ''
  },
  color: {
    type: String,
    default: ''
  },
  to :{
    type : String
  }
});

const screenWidth = ref(window.innerWidth);

const updateScreenWidth = () => {
  screenWidth.value = window.innerWidth;
};

onMounted(() => {
  window.addEventListener('resize', updateScreenWidth);
});

onBeforeUnmount(() => {
  window.removeEventListener('resize', updateScreenWidth);
});

const iconStyle = ref({
  color: props.color,
  height: props.iconSizePx,
  width: props.iconSizePx
});

const MAX_ICON_SIZE_DECREASE = 7;

watch(screenWidth, () => {
  if (screenWidth.value < 787) {
    const newSize = parseInt(props.iconSizePx) - MAX_ICON_SIZE_DECREASE;
    iconStyle.value.height = newSize + 'px';
    iconStyle.value.width = newSize + 'px';
  } else {
    iconStyle.value.height = props.iconSizePx;
    iconStyle.value.width = props.iconSizePx;
  }
});
</script>

<style scoped>
.h-btn-container button {
  border: 0;
}
.h-btn-container:hover button {
  background-color: #f1f5f9 !important;
}
.h-btn-tooltip {
  position: absolute;
  display: none;
  z-index: 9999;
  background-color: #475569;
  color: #f1f5f9;
  min-width: max-content;
  font-size: 12px;
  user-select: none;
  top: 0;
  left: 50%;
  transform: translateX(-50%);
  margin-top: 5px;
}

.h-btn-container:hover .h-btn-tooltip {
  display: block;
  animation: tooltipSlide 0.2s forwards;
}
@keyframes tooltipSlide {
  from {
    top: 0;
    opacity: 0;
  }
  to {
    top: 100%;
    opacity: 1;
  }
}
</style>
