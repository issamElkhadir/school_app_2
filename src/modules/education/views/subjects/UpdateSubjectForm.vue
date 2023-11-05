<template>
  <ResourceUpdate resource="education/subjects"
                  :id="id"
                  :title="$t('')">

    <template #subtitle="{ original }">
      <PlfBreadcrumb>
        <PlfBreadcrumbEl label="Education"
                         class="text-danger"
                         icon="tblr.IconPackage" />

        <PlfBreadcrumbEl label="subjects"
                         :to="{ name: 'admin.subjects.table' }" />

        <PlfBreadcrumbEl :label="original.name || 'Edit'" />
      </PlfBreadcrumb>
    </template>

    <template #actions="{ disabled, saving, save, toggleEdit }">
      <template v-if="disabled">
        <PlfButton label="Edit"
                   @click="toggleEdit" />

        <PlfButton label="New"
                   :to="{ name: 'admin.subjects.create' }"
                   icon="mdi.IconPlus"
                   color="primary" />
      </template>

      <template v-else>
        <PlfButton label="Cancel"
                   @click="toggleEdit" />

        <PlfButton label="Save"
                   @click="save"
                   :loading="saving"
                   icon="mdi.IconContentSave"
                   color="primary" />
      </template>
    </template>

    <template #form="{ record, original, validation, disabled }">
      <h3 class="card-title">Update Subject {{ original.name }}</h3>

      <div class="row row-cards">

        <div class="col-12 text-end">
          <AvatarField v-model="record.picture"
                       :errors="validation.picture"
                       :invalid="'picture' in validation"
                       :disabled="disabled" />
        </div>

        <div class="col-md-4">
          <PlfInput label="Name"
                    :disabled="disabled"
                    v-model="record.name"
                    :errors="validation.name"
                    :invalid="'name' in validation"
                    required />
        </div>

        <div class="col-md-4">
          <PlfInput label="Color"
                    :disabled="disabled"
                    v-model="record.color"
                    :errors="validation.color"
                    :invalid="'color' in validation" />
        </div>

        <div class="col-md-4">
          <PlfInput label="Massar ID"
                    :disabled="disabled"
                    v-model="record.massar_id"
                    :errors="validation.massar_id"
                    :invalid="'massar_id' in validation"
                    required />
        </div>

        <div class="col-md-4">
          <PlfInput label="Order"
                    :disabled="disabled"
                    v-model="record.order"
                    :errors="validation.order"
                    :invalid="'order' in validation" />
        </div>

        <div class="col-md-4">
          <BelongsToField label="Unity"
                          resource="education/unities"
                          required
                          :disabled="disabled"
                          v-model="record.unity"
                          :errors="validation['unity.id']"
                          :invalid="'unity.id' in validation" />
        </div>

        <div class="col-md-4">
          <BelongsToField label="Classroom Type"
                          resource="education/classroom-types"
                          required
                          :disabled="disabled"
                          v-model="record.classroomType"
                          :errors="validation['classroomType.id']"
                          :invalid="'classroomType.id' in validation" />
        </div>

        <div class="col-md-4">
          <BelongsToField label="Periods"
                          resource="education/periods"
                          multiple
                          :disabled="disabled"
                          v-model="record.periods"
                          :errors="validation['periods.id']"
                          :invalid="'periods.id' in validation" />
        </div>

      </div>

    </template>
  </ResourceUpdate>
</template>

<script setup>
import PlfButton from '@/components/shared/button/PlfButton.vue';
import PlfInput from '@/components/shared/input/PlfInput.vue';
import PlfBreadcrumb from '@/components/shared/breadcrumb/PlfBreadcrumb.vue';
import PlfBreadcrumbEl from '@/components/shared/breadcrumb/PlfBreadcrumbEl.vue';
import ResourceUpdate from '@/components/ResourceUpdate.vue';
import BelongsToField from "@/fields/forms/BelongsToField.vue";
import PlfImage from "@/components/shared/image/PlfImage.vue";
import AvatarField from '@/fields/forms/AvatarField.vue';

defineProps({
  id: {
    type: Number,
    required: true
  }
});

</script>