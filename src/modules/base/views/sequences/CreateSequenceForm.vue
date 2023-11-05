<template>
  <ResourceCreate resource="sequences"
                  :title="$t('sequences.title')"
                  @saved="onSaved"
                  v-model:record="record">
    <template #subtitle>
      <PlfBreadcrumb>
        <PlfBreadcrumbEl label="Base"
                         class="text-danger"
                         icon="tblr.IconPackage" />

        <PlfBreadcrumbEl :label="$t('sequences.title')"
                         :to="{ name: 'admin.sequences.table' }" />

        <PlfBreadcrumbEl label="New" />
      </PlfBreadcrumb>
    </template>

    <template #actions="{ save, storing }">
      <PlfButton label="Cancel"
                 :to="{ name: 'admin.sequences.table' }" />

      <PlfButton label="Save"
                 @click="save"
                 :loading="storing"
                 icon="mdi.IconContentSave"
                 color="primary" />
    </template>

    <template #form="props">
      <h3 class="card-title">{{ $t('sequences.create') }}</h3>

      <SequenceForm v-model:record="props.record"
                    :validation="props.validation" />
    </template>
  </ResourceCreate>
</template>

<script setup>
import PlfButton from '@/components/shared/button/PlfButton.vue';
import { useRouter } from 'vue-router';
import ResourceCreate from '@/components/ResourceCreate.vue';
import PlfBreadcrumb from '@/components/shared/breadcrumb/PlfBreadcrumb.vue';
import PlfBreadcrumbEl from '@/components/shared/breadcrumb/PlfBreadcrumbEl.vue';
import SequenceForm from './SequenceForm.vue';
import { ref } from 'vue';

const router = useRouter();

const onSaved = ({ id }) => {
  router.push({ name: 'admin.sequences.update', params: { id } });
}

const record = ref({
  next_value: 1,
  step: 1,
  start_value: 1,
  end_value: null,
  prefix: null,
  suffix: null,
  name: null,
  code: null,
  length: 1
});
</script>