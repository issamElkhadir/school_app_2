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
                         :to="{ name: 'admin.users.table' }" />

              <PlfButton label="Save"
                         icon="mdi.IconContentSave"
                         color="primary" />

            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Page body -->
    <div class="flex-fill page-body">
      <div class="container-fluid d-flex mb-2 flex-column h-100">
        <div class="row row-cards">
          <div class="col-12">
            <form class="card">
              <div class="card-body">
                <h3 class="card-title">New User</h3>
                <div class="row row-cards">
                  <div class="col-md-4">
                    <PlfInput label="First Name"
                              required />
                  </div>

                  <div class="col-md-4">
                    <PlfInput label="Middle Name" />
                  </div>

                  <div class="col-md-4">
                    <PlfInput label="Last Name"
                              required />
                  </div>

                  <div class="col-md-4">
                    <PlfInput label="Email"
                              required />
                  </div>

                  <div class="col-md-4">
                    <PlfSelect label="Language"
                               hide-arrow
                               :options="['English', 'German', 'Arabic']"
                               required />
                  </div>

                  <div class="col-md-12">
                    <PlfInput label="Address"
                              type="textarea"
                              rows="3"
                              required />
                  </div>

                  <div class="col-md-6">
                    <PlfInput label="Password"
                              type="password"
                              required />
                  </div>

                  <div class="col-md-6">
                    <PlfInput label="Password Confirmation"
                              type="password"
                              required />
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import PlfButton from '@/components/shared/button/PlfButton.vue';
import PlfInput from '@/components/shared/input/PlfInput.vue';
import PlfSelect from '@/components/shared/select/PlfSelect.vue';

const title = 'Users';
const subtitle = 'Create New User';
</script>