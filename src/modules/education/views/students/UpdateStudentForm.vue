<template>
  <ResourceUpdate resource="education/students"
                  :id="id"
                  :title="$t('')">

    <template #subtitle="{ original }">
      <PlfBreadcrumb>
        <PlfBreadcrumbEl label="Education"
                         class="text-danger"
                         icon="tblr.IconPackage"/>

        <PlfBreadcrumbEl label="students"
                         :to="{ name: 'admin.students.table' }"/>

        <PlfBreadcrumbEl :label="original.name || 'Edit'"/>
      </PlfBreadcrumb>
    </template>

    <template #actions="{ disabled, saving, save, toggleEdit }">
      <template v-if="disabled">
        <PlfButton label="Edit"
                   @click="toggleEdit"/>

        <PlfButton label="New"
                   :to="{ name: 'admin.students.create' }"
                   icon="mdi.IconPlus"
                   color="primary"/>
      </template>

      <template v-else>
        <PlfButton label="Cancel"
                   @click="toggleEdit"/>

        <PlfButton label="Save"
                   @click="save"
                   :loading="saving"
                   icon="mdi.IconContentSave"
                   color="primary"/>
      </template>
    </template>

    <template #form="props">
      <h3 class="card-title">{{ $t('students.create') }}</h3>

      <StudentForm v-model="props.record"
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
import StudentForm from "@education/views/students/StudentForm.vue";

defineProps({
  id: {
    type: Number,
    required: true
  }
});


</script>