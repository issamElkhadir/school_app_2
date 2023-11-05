<template>
  <div class="page-wrapper h-100">
    <!-- Page header -->
    <div class="page-header mt-2 d-print-none">
      <div class="container-fluid">
        <div class="row g-2 align-items-center">
          <div class="col">
            <slot name="title"
                  :title="title">
              <h2 v-if="title"
                  class="page-title">
                {{ title }}
              </h2>
            </slot>

            <slot name="subtitle"
                  :subtitle="subtitle">
              <div v-if="subtitle"
                   class="page-pretitle">
                {{ subtitle }}
              </div>
            </slot>
          </div>

          <!-- Page title actions -->
          <div class="col-auto ms-auto d-print-none">
            <div class="btn-list">

              <slot name="actions"
                    :selected="selected"></slot>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Page body -->
    <div class="flex-fill overflow-auto page-body my-0 pt-3 d-flex flex-column">
      <div class="container-fluid d-flex h-100 flex-column flex-fill">
        <div>
          <div class="d-flex mb-3 flex-column">
            <div class="d-flex gap-3 mb-0">
              <RouterLink v-for="(mode, index) in modes"
                          :key="`mode-${index}`"
                          class="text-decoration-none text-reset user-select-none d-inline-flex flex-column gap-2"
                          exact-active-class="text-primary"
                          :to="mode.to">
                <template #default="{ isExactActive }">
                  <div class="d-inline-flex align-items-center">
                    <PlfIcon v-if="mode.icon"
                             :name="mode.icon" />

                    <span class="px-2">{{ mode.title }}</span>
                  </div>

                  <div class="border-top-wide border-primary"
                       :class="{ 'd-none': isExactActive === false }"></div>
                </template>
              </RouterLink>

              <PlfButton v-if="'cards' in $slots"
                         class="ms-auto btn-action btn-sm"
                         icon="mdi.IconChevronLeft"
                         style="margin-top: -8px;"
                         :icon-classes="{ 'rotate-n-90': !hideCards }"
                         @click="toggleCards" />
            </div>
            <div style="margin-top: -2px;"
                 class="border-top-wide w-100"></div>
          </div>

          <!-- Page cards -->
          <PlfExpandTransitionV2 v-if="'cards' in $slots"
                                 :when="!hideCards"
                                 class="plf-expand-transition">
            <slot name="cards"></slot>
          </PlfExpandTransitionV2>

        </div>
        <slot :selected="selected"
              @update:selected="evt => selected = evt"></slot>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import PlfButton from './shared/button/PlfButton.vue';
import PlfExpandTransitionV2 from './shared/transition/PlfExpandTransitionV2.vue';
import PlfIcon from './shared/icon/PlfIcon.vue';

defineProps({
  title: {
    type: String,
    required: false
  },

  subtitle: {
    type: String,
    required: false
  },

  modes: {
    type: Array,
    required: true,
    default: () => []
  }
});

const hideCards = ref(true);

const selected = ref([]);

const toggleCards = () => {
  hideCards.value = !hideCards.value;
};

</script>

<style>
.plf-expand-transition {
  transition: height var(--plf-auto-duration) cubic-bezier(0.33, 1, 0.68, 1);
}
</style>