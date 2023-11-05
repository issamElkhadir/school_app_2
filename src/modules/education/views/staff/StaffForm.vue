<template>
  <div class="row row-cards">

    <PlfTabView>
      <div class="col-12 col-md-10 mx-auto">

        <PlfTabPanel header="General">
          <div class="row p-3">
            <div class="col-md-6">

              <div class="d-flex space-y-3 flex-column">

                <TextField label="Name"
                           inline
                           :disabled="disabled"
                           v-model="recordMutation.name"
                           :errors="validation.name"
                           :invalid="'name' in validation"
                           required/>

                <TextField label="Phone"
                           inline
                           :disabled="disabled"
                           v-model="recordMutation.phone"
                           :errors="validation.phone"
                           :invalid="'phone' in validation"/>

                <TextField label="Email"
                           inline
                           type="email"
                           :disabled="disabled"
                           v-model="recordMutation.email"
                           :errors="validation.email"
                           :invalid="'email' in validation"/>

                  <BelongsToManyField label="Schools"
                                      resource="schools"
                                      required
                                      inline
                                      v-model="recordMutation.schools"
                                      :errors="validation.schools"
                                      :invalid="'schools' in validation"/>

              </div>
            </div>
            <div class="col-md-6">
              <div class="d-flex space-y-3 flex-column">

                <TextField label="Salary"
                           inline
                           type="number"
                           :disabled="disabled"
                           v-model="recordMutation.salary"
                           :errors="validation.salary"
                           :invalid="'salary' in validation"/>

                <TextField label="Week Hours"
                           inline
                           type="number"
                           :disabled="disabled"
                           v-model="recordMutation.week_hours"
                           :errors="validation.week_hours"
                           :invalid="'week_hours' in validation"/>

                <TextField label="Week Hours"
                           inline
                           type="textarea"
                           :disabled="disabled"
                           v-model="recordMutation.address"
                           :errors="validation.address"
                           :invalid="'address' in validation"/>

              </div>

            </div>
          </div>
        </PlfTabPanel>

        <PlfTabPanel header="Skills">
          <div class="row p-3">
            <div class="d-flex space-y-3 flex-column">
              <div class="col-12">
                <HasManyField v-model="recordMutation.skills"
                              :columns="cols"
                              :label="$t('school.fields.skills')"
                              :disabled="disabled"
                              :validation="validation"
                              attribute="skills">

                  <template #body-cell-subject="{ row, invalid, errors }">

                    <BelongsToField resource="education/subjects"
                                    required
                                    :disabled="disabled"
                                    v-model="row.subject"
                                    :errors="errors"
                                    :invalid="invalid"/>

                  </template>

                  <template #body-cell-level="{ row, invalid, errors }">

                    <BelongsToField resource="education/levels"
                                    required
                                    :disabled="disabled"
                                    v-model="row.level"
                                    :errors="errors"
                                    :invalid="invalid"/>

                  </template>

                  <template #body-cell-note="{ row, invalid, errors }">
                    <TextField v-model="row.note"
                               :disabled="disabled"
                               :invalid="invalid"
                               :errors="errors"/>
                  </template>

                </HasManyField>
              </div>
            </div>
          </div>

        </PlfTabPanel>

      </div>
    </PlfTabView>


  </div>
</template>

<script setup>
import BelongsToField from '@/fields/forms/BelongsToField.vue';
import {useVModel} from '@vueuse/core';
import TextField from "@/fields/forms/TextField.vue";
import HasManyField from "@/fields/forms/HasManyField.vue";
import BelongsToManyField from "@/fields/forms/BelongsToManyField.vue";
import PlfTabView from "@/components/shared/tabview/PlfTabView.vue";
import PlfTabPanel from "@/components/shared/tabview/PlfTabPanel.vue";

const emit = defineEmits(['update:modelValue']);

const props = defineProps({
  modelValue: {
    type: Object,
    required: true
  },

  validation: {
    type: Object,
    required: true
  },

  disabled: {
    type: Boolean,
    default: false
  }
});

const recordMutation = useVModel(props, 'modelValue', emit);

const cols = [
  {name: 'level', field: 'level', label: 'Level'},
  {name: 'subject', field: 'subject', label: 'Subject'},
  {name: 'note', field: 'note', label: 'Note'},
];


</script>