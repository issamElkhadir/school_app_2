<template>
  <div class="page-wrapper lvh-100">
    <!-- Page header -->
    <div class="page-header mt-3 d-print-none">
      <div class="container-fluid">
        <div class="row g-2 align-items-center">
          <div class="col">
            <slot name="subtitle"
                  :subtitle="subtitle">
              <div v-if="subtitle"
                   class="page-pretitle">
                {{ subtitle }}
              </div>
            </slot>

            <slot name="title"
                  :title="title">
              <h2 class="page-title">
                {{ title }}
              </h2>
            </slot>
          </div>

          <!-- Page title actions -->
          <div class="col-auto ms-auto d-print-none">
            <div class="btn-list">
              <!-- Actions -->

              <PlfButton label="Cancel"
                         :to="{ name: 'admin.countries' }" />

              <PlfButton label="Delete"
                         icon="mdi.IconTrash"
                         color="danger" />

            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Page body -->
    <div class="flex-fill page-body">
      <div class="container-fluid d-flex mb-2 flex-column h-100">
        <!-- Details -->
      </div>
    </div>
  </div>
</template>

<script setup>
import PlfButton from '@/components/shared/button/PlfButton.vue';

const title = 'Show Country'
const subtitle = 'Country details'
</script>