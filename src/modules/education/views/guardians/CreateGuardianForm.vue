<template>
  <ResourceCreate resource="education/guardians"
                  :title="$t('')"
                  @saved="onSaved">
    <template #subtitle>
      <PlfBreadcrumb>
        <PlfBreadcrumbEl label="Education"
                         class="text-danger"
                         icon="tblr.IconPackage"/>

        <PlfBreadcrumbEl label="Guardians"
                         :to="{ name: 'admin.guardians.table' }"/>

        <PlfBreadcrumbEl label="New"/>
      </PlfBreadcrumb>
    </template>

    <template #actions="{ save, storing }">
      <PlfButton label="Cancel"
                 :to="{ name: 'admin.guardians.table' }"/>

      <PlfButton label="Save"
                 @click="save"
                 :loading="storing"
                 icon="mdi.IconContentSave"
                 color="primary"/>
    </template>

    <template #form="{ record, validation }">
      <h3 class="card-title">New Guardian</h3>

      <div class="row row-cards">
        <div class="col-md-6">
          <PlfInput label="First Name"
                    inline
                    :disabled="disabled"
                    v-model="record.first_name"
                    :errors="validation.first_name"
                    :invalid="'first_name' in validation"
                    required/>
        </div>

        <div class="col-md-6">
          <PlfInput label="Last Name"
                    inline
                    :disabled="disabled"
                    v-model="record.last_name"
                    :errors="validation.last_name"
                    :invalid="'last_name' in validation"
                    required/>
        </div>

        <div class="col-md-6">
          <PlfInput label="RTL First Name"
                    inline
                    :disabled="disabled"
                    v-model="record.rtl_first_name"
                    :errors="validation.rtl_first_name"
                    :invalid="'rtl_first_name' in validation"
          />
        </div>

        <div class="col-md-6">
          <PlfInput label="RTL Last Name"
                    inline
                    :disabled="disabled"
                    v-model="record.rtl_last_name"
                    :errors="validation.rtl_last_name"
                    :invalid="'rtl_last_name' in validation"
          />
        </div>

        <div class="col-md-6">
          <PlfInput label="CNI Number"
                    inline
                    :disabled="disabled"
                    v-model="record.cni_number"
                    :errors="validation.cni_number"
                    :invalid="'cni_number' in validation"
                    required/>
        </div>

        <div class="col-md-6">
          <PlfInput label="Home Phone"
                    inline
                    :disabled="disabled"
                    v-model="record.home_phone"
                    :errors="validation.home_phone"
                    :invalid="'home_phone' in validation"
          />
        </div>

        <div class="col-md-6">
          <PlfInput label="Mobile Phone"
                    inline
                    :disabled="disabled"
                    v-model="record.mobile_phone"
                    :errors="validation.mobile_phone"
                    :invalid="'mobile_phone' in validation"
          />
        </div>

        <div class="col-md-6">
          <PlfInput label="Email Address"
                    inline
                    :disabled="disabled"
                    v-model="record.email_address"
                    :errors="validation.email_address"
                    :invalid="'email_address' in validation"
          />
        </div>


        <div class="col-md-6">
          <BelongsToField label="Country"
                          resource="countries"
                          required
                          inline
                          :disabled="disabled"
                          v-model="record.country"
                          :errors="validation['country.id']"
                          :invalid="'country.id' in validation"/>
        </div>

        <div class="col-md-6">
          <BelongsToField label="City"
                          resource="cities"
                          required
                          inline
                          :disabled="disabled"
                          v-model="record.city"
                          :errors="validation['city.id']"
                          :invalid="'city.id' in validation"/>
        </div>

        <div class="col-md-6">
          <PlfInput label="Gender"
                    required
                    inline
                    :disabled="disabled"
                    v-model="record.gender"
                    :errors="validation.gender"
                    :invalid="'gender' in validation"/>
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

const router = useRouter();


const onSaved = ({id}) => {
  router.push({name: 'admin.guardians.update', params: {id}});
}
</script>