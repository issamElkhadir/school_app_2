<template>
  <div class="row row-cards">

    <div class="col-md-6">
      <TextField :label="$t('categories.fields.name')"
                 v-model="record.name"
                 required
                 :invalid="'name' in validation"
                 :errors="validation.name"
                 :disabled="disabled"/>
    </div>

    <div class="col-md-6">
      <TextField :label="$t('categories.fields.rtl_name')"
                 v-model="record.rtl_name"
                 :invalid="'rtl_name' in validation"
                 :errors="validation.rtl_name"
                 :disabled="disabled"
      />
    </div>

    <div class="col-md-6">
      <TextField :label="$t('categories.fields.short_name')"
                 v-model="record.short_name"
                 :invalid="'short_name' in validation"
                 :errors="validation.short_name"
                 :disabled="disabled"
      />
    </div>

    <div class="col-md-6">
      <BelongsToField :label="$t('categories.fields.category')"
                      v-model="record.category"
                      resource="category"
                      :invalid="'category.id' in validation"
                      :errors="validation['category.id']"
                      :disabled="disabled"
      />
    </div>

    <div class="col-md-6">
      <BooleanField :label="$t('categories.fields.status')"
                    v-model="record.status"
                    :invalid="'status' in validation"
                    :errors="validation.status"
                    :disabled="disabled"
      />
    </div>

    <div class="col-md-6">
      <TextField :label="$t('categories.fields.description')"
                 type="textarea"
                 v-model="record.description"
                 :invalid="'description' in validation"
                 :errors="validation.description"
                 :disabled="disabled"
      />
    </div>

  </div>
</template>

<script setup>
import BelongsToField from '@/fields/forms/BelongsToField.vue';
import {useVModel} from '@vueuse/core';
import BooleanField from "@/fields/forms/BooleanField.vue";
import TextField from "@/fields/forms/TextField.vue";

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

const record = useVModel(props, 'modelValue', emit);

</script>