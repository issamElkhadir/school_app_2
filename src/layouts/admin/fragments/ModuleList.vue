<template>
  <div class="row modules row-cols-2 row-cols-sm-3 g-3">
    <div v-for="module in modules"
         :key="`module-${module.id}`"
         class="col">
      <RouterLink :class="moduleClasses(module)"
                  class="module-item rounded-3 border gap-2"
                  :to="module.to"
                  style="height: 100px">
        <PlfIcon :name="module.icon" />
        <span>{{ module.display_name }}</span>
      </RouterLink>
    </div>
  </div>
</template>

<script setup>
import PlfIcon from '@/components/shared/icon/PlfIcon.vue';

defineProps({
  modules: Array
});

const moduleClasses = (module) => {
  return [
    `bg-${module['bg_color']}-lt`,
    `text-${module['font_color']}`
  ];
};
</script>

<style scoped>
.modules {
  overflow: auto;
  padding-block: 10px;
}

.modules .module-item {
  text-decoration: none;
  color: var(--tblr-dark);

  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  height: 100%;
  width: 100%;
  transition: transform .2s;
}

.modules .module-item .icon {
  height: 2rem;
  width: 2rem;
}

.modules .module-item:hover {
  transform: scale(1.05);
}
</style>