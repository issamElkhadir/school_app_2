<template>
  <div class="page-wrapper lvh-100">
    <!-- Page header -->
    <div class="page-header mt-2 d-print-none">
      <div class="container-fluid">
        <div class="row g-2 align-items-center">
          <div class="col">

            <h2 class="page-title">
              {{ $t('settings.title') }}
            </h2>

            <div class="page-pretitle">
              {{ $t('settings.subtitle') }}
            </div>
          </div>

          <!-- Page title actions -->
          <div class="col-auto ms-auto d-print-none">
            <div class="btn-list">
              <!-- Actions -->
              <PlfButton class="btn-primary"
                         label="Save"
                         @click="update"
                         :loading="save.saving"
                         icon="mdi.IconContentSave" />
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Page body -->
    <div class="flex-fill page-body my-0">
      <div class="container-fluid h-100 d-flex my-2 flex-column h-100">
        <PlfDivider />

        <div class="row my-2">
          <div class="col-3 d-none d-md-block">
            <PlfList mandatory
                     selected="6">
              <PlfListItem :to="{ name: 'admin.settings.base' }"
                           title="Base"
                           v-if="'base' in modules" />

              <PlfListItem :to="{ name: 'admin.settings.education' }"
                           title="Education"
                           v-if="'education' in modules" />

              <PlfListItem :to="{ name: 'admin.settings.billing' }"
                           title="Billing" />

              <PlfListItem value="3"
                           title="Password" />

              <PlfListItem value="4"
                           title="Team">
                <template #append>
                  <span class="badge bg-secondary-lt rounded-pill ms-auto">4</span>
                </template>
              </PlfListItem>

              <PlfListItem value="5"
                           title="Plan" />

              <PlfListItem value="7"
                           title="Email" />

              <PlfListItem value="8"
                           title="Notifications" />

              <PlfListItem value="9"
                           title="Integrations" />

              <PlfListItem value="10"
                           title="API" />
            </PlfList>
          </div>

          <div class="col-12 col-md-9">
            <RouterView v-model="fetch.data"
                        :validation="save.validation" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import PlfButton from '@/components/shared/button/PlfButton.vue';
import PlfDivider from '@/components/shared/divider/PlfDivider.vue';
import PlfList from '@/components/shared/list/PlfList.vue';
import PlfListItem from '@/components/shared/list/PlfListItem.vue';
import { useResource } from '@/composables/network/resources/useResource';
import { computed, onMounted } from 'vue';
import { useToast } from '@/components/shared/toast/useToast';
import { useModulesStore } from '../../stores/modules';

const {
  save,
  fetch,
} = useResource('settings');

const toast = useToast();

onMounted(() => {
  fetch.fetch();
});

const update = () => {
  save.save({
    payload: fetch.data,
    url: 'settings',
    onSuccess: () => {
      toast.add({
        severity: 'success',
        summary: 'Settings updated',
        detail: 'Your settings have been updated successfully.',
        position: 'bottom-right'
      });
    },

    onError: () => {
      toast.add({
        severity: 'error',
        summary: 'Settings update failed',
        detail: save.error ?? 'Your settings could not be updated. Please try again.',
        position: 'bottom-right'
      });
    },
  });
};

const modulesStore = useModulesStore();

const modules = computed(() => modulesStore.modules.reduce((acc, module) => {
  acc[module.name] = module;
  return acc;
}, {}));
</script>