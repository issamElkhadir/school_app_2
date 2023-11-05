<template>
  <ResourceUpdate resource="education/classrooms"
                  :id="id"
                  :title="$t('')">

    <template #subtitle="{ original }">
      <PlfBreadcrumb>
        <PlfBreadcrumbEl label="Education"
                         class="text-danger"
                         icon="tblr.IconPackage" />

        <PlfBreadcrumbEl label="Classrooms"
                         :to="{ name: 'admin.classrooms.table' }" />

        <PlfBreadcrumbEl :label="original.name || 'Edit'" />
      </PlfBreadcrumb>
    </template>

    <template #actions="{ disabled, saving, save, toggleEdit }">
      <template v-if="disabled">
        <PlfButton label="Edit"
                   @click="toggleEdit" />

        <PlfButton label="New"
                   :to="{ name: 'admin.classrooms.create' }"
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
      <h3 class="card-title">Update Classroom {{ original.name }}</h3>

      <div class="row row-cards">

        <div class="col-md-12 d-flex flex-row-reverse ">
          <PlfImage :src="record.image?.url"
                    :no-spinner="true"
                    img-class="avatar " />
        </div>

        <div class="col-md-4">
          <PlfInput label="Name"
                    :disabled="disabled"
                    v-model="record.name"
                    :errors="validation.name"
                    :invalid="'name' in validation"
                    required/>
        </div>

        <div class="col-md-4">
          <PlfInput label="Last Name"
                    :disabled="disabled"
                    v-model="record.last_name"
                    :errors="validation.last_name"
                    :invalid="'last_name' in validation"
                    required/>
        </div>

        <div class="col-md-4">
          <PlfInput label="Capacity"
                    type="number"
                    :disabled="disabled"
                    v-model="record.capacity"
                    :errors="validation.capacity"
                    :invalid="'capacity' in validation"
          />
        </div>

        <div class="col-md-4">
          <PlfInput label="RTL Name"
                    :disabled="disabled"
                    v-model="record.rtl_name"
                    :errors="validation.rtl_name"
                    :invalid="'rtl_name' in validation"
          />
        </div>

        <div class="col-md-4">
          <BelongsToField label="School"
                          resource="schools"
                          required
                          :disabled="disabled"
                          v-model="record.school"
                          :errors="validation['school.id']"
                          :invalid="'school.id' in validation"/>
        </div>

        <div class="col-md-4">
          <BelongsToField label="Classroom Type"
                          resource="education/classroom-types"
                          required
                          :disabled="disabled"
                          v-model="record.classroomType"
                          :errors="validation['classroomType.id']"
                          :invalid="'classroomType.id' in validation"/>
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

defineProps({
  id: {
    type: Number,
    required: true
  }
});

</script>