<template>
  <ResourceUpdate resource="education/subscriptions"
                  :id="id"
                  :title="$t('')">

    <template #subtitle="{ original }">
      <PlfBreadcrumb>
        <PlfBreadcrumbEl label="Education"
                         class="text-danger"
                         icon="tblr.IconPackage"/>

        <PlfBreadcrumbEl label="subscriptions"
                         :to="{ name: 'admin.subscriptions.table' }"/>

        <PlfBreadcrumbEl :label="original.name || 'Edit'"/>
      </PlfBreadcrumb>
    </template>

    <template #actions="{ disabled, saving, save, toggleEdit }">
      <template v-if="disabled">
        <PlfButton label="Edit"
                   @click="toggleEdit"/>

      </template>

      <template v-else>
        <PlfButton label="Cancel"
                   @click="toggleEdit"/>

<!--        <PlfButton label="Save"-->
<!--                   @click="save"-->
<!--                   :loading="saving"-->
<!--                   icon="mdi.IconContentSave"-->
<!--                   color="primary"/>-->
      </template>
      <PlfButton label="New"
                 :to="{ name: 'admin.subscriptions.create' }"
                 icon="mdi.IconPlus"
                 color="primary"/>
    </template>

    <template #form="props">
      <h3 class="card-title">{{ $t('subscriptions.create') }}</h3>

      <SubscriptionForm v-model="props.record"
                   :validation="props.validation"
                   :disabled="props.disabled"
      />
    </template>

  </ResourceUpdate>
</template>

<script setup>
import PlfButton from '@/components/shared/button/PlfButton.vue';
import PlfBreadcrumb from '@/components/shared/breadcrumb/PlfBreadcrumb.vue';
import PlfBreadcrumbEl from '@/components/shared/breadcrumb/PlfBreadcrumbEl.vue';
import ResourceUpdate from '@/components/ResourceUpdate.vue';
import SubscriptionForm from "@education/views/subscriptions/SubscriptionForm.vue";

defineProps({
  id: {
    type: Number,
    required: true
  }
});


</script>