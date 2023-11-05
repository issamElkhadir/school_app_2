<template>
  <ResourceUpdate resource="education/levels"
                  :id="id"
                  :title="$t('')">

    <template #subtitle="{ original }">
      <PlfBreadcrumb>
        <PlfBreadcrumbEl label="Education"
                         class="text-danger"
                         icon="tblr.IconPackage" />

        <PlfBreadcrumbEl label="Levels"
                         :to="{ name: 'admin.levels.table' }" />

        <PlfBreadcrumbEl :label="original.name || 'Edit'" />
      </PlfBreadcrumb>
    </template>

    <template #actions="{ disabled, saving, save, toggleEdit }">
      <template v-if="disabled">
        <PlfButton label="Edit"
                   @click="toggleEdit" />

        <PlfButton label="New"
                   :to="{ name: 'admin.levels.create' }"
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
      <h3 class="card-title">Update Level {{ original.name }}</h3>

      <div class="row row-cards">

        <div class="col-md-4">
          <PlfInput label="Name"
                    :disabled="disabled"
                    v-model="record.name"
                    :errors="validation.name"
                    :invalid="'name' in validation"
                    required/>
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
          <PlfInput label="Short Name"
                    :disabled="disabled"
                    v-model="record.short_name"
                    :errors="validation.short_name"
                    :invalid="'short_name' in validation"
          />
        </div>

        <div class="col-md-4">
          <PlfInput label="Description"
                    :disabled="disabled"
                    v-model="record.description"
                    :errors="validation.description"
                    :invalid="'description' in validation"
          />
        </div>

        <div class="col-md-4">
          <BelongsToField label="Branch"
                          resource="education/branches"
                          required
                          :disabled="disabled"
                          v-model="record.branch"
                          :errors="validation['branch.id']"
                          :invalid="'branch.id' in validation"/>
        </div>

        <div class="col-md-4">
          <PlfSelect label="Status"
                     required
                     :disabled="disabled"
                     v-model="record.status"
                     :options="status"
                     emit-value
                     close-on-select
                     :errors="validation.status"
                     :invalid="'status' in validation">
            <template #option="{ option, onSelect }">
              <div class="p-2"
                   @click="onSelect(option)">
                <span class="badge"
                      :class="option.color"></span>
                {{ option.label }}
              </div>
            </template>

            <template #select-header="{ option }">
              <div v-if="option"
                   class="flex-fill cursor-pointer d-flex align-items-center">
                <span class="me-1 badge"
                      :class="option.color"></span>
                {{ option.label }}
              </div>
            </template>
          </PlfSelect>
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
import PlfSelect from "@/components/shared/select/PlfSelect.vue";
import BelongsToField from "@/fields/forms/BelongsToField.vue";

defineProps({
  id: {
    type: Number,
    required: true
  }
});

const status = [
  {value: true, label: 'Active', color: 'bg-success'},
  {value: false, label: 'Inactive', color: 'bg-secondary'}
];

</script>