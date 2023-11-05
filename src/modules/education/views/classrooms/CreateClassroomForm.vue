<template>
  <ResourceCreate resource="education/classrooms"
                  :title="$t('')"
                  @saved="onSaved">
    <template #subtitle>
      <PlfBreadcrumb>
        <PlfBreadcrumbEl label="Education"
                         class="text-danger"
                         icon="tblr.IconPackage"/>

        <PlfBreadcrumbEl label="Classrooms"
                         :to="{ name: 'admin.classrooms.table' }"/>

        <PlfBreadcrumbEl label="New"/>
      </PlfBreadcrumb>
    </template>

    <template #actions="{ save, storing }">
      <PlfButton label="Cancel"
                 :to="{ name: 'admin.classrooms.table' }"/>

      <PlfButton label="Save"
                 @click="save"
                 :loading="storing"
                 icon="mdi.IconContentSave"
                 color="primary"/>
    </template>

    <template #form="{ record, validation }">
      <h3 class="card-title">New Classroom</h3>

      <div class="row row-cards">

        <div class="col-md-12 d-flex flex-row-reverse ">
          <PlfImage :src="record.image?.url"
                    :no-spinner="true"
                    img-class="avatar " />
        </div>

        <div class="col-md-4">
          <PlfInput label="Name"
                    v-model="record.name"
                    :errors="validation.name"
                    :invalid="'name' in validation"
                    required/>
        </div>

        <div class="col-md-4">
          <PlfInput label="Last Name"
                    v-model="record.last_name"
                    :errors="validation.last_name"
                    :invalid="'last_name' in validation"
                    required/>
        </div>

        <div class="col-md-4">
          <PlfInput label="Capacity"
                    type="number"
                    v-model="record.capacity"
                    :errors="validation.capacity"
                    :invalid="'capacity' in validation"
          />
        </div>

        <div class="col-md-4">
          <PlfInput label="RTL Name"
                    v-model="record.rtl_name"
                    :errors="validation.rtl_name"
                    :invalid="'rtl_name' in validation"
          />
        </div>

        <div class="col-md-4">
          <BelongsToField label="School"
                          resource="schools"
                          required
                          v-model="record.school"
                          :errors="validation['school.id']"
                          :invalid="'school.id' in validation"/>
        </div>

        <div class="col-md-4">
          <BelongsToField label="Classroom Type"
                          resource="education/classroom-types"
                          required
                          v-model="record.classroomType"
                          :errors="validation['classroomType.id']"
                          :invalid="'classroomType.id' in validation"/>
        </div>

      </div>
    </template>
  </ResourceCreate>
</template>

<script setup>
import PlfButton from '@/components/shared/button/PlfButton.vue';
import PlfInput from '@/components/shared/input/PlfInput.vue';
import {useRouter} from 'vue-router';
import ResourceCreate from '@/components/ResourceCreate.vue';
import PlfBreadcrumb from '@/components/shared/breadcrumb/PlfBreadcrumb.vue';
import PlfBreadcrumbEl from '@/components/shared/breadcrumb/PlfBreadcrumbEl.vue';
import BelongsToField from '@/fields/forms/BelongsToField.vue';
import PlfImage from "@/components/shared/image/PlfImage.vue";

const router = useRouter();


const onSaved = ({id}) => {
  router.push({name: 'admin.classrooms.update', params: {id}});
}
</script>