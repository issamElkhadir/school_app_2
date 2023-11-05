<template>
  <PlfTooltip :z-index="3000"
              square
              trigger="click">
    <template #content>
      <div class="px-3 py-2"
           style="width: 300px">
        <PlfSelect :z-index="5000"
                   square
                   :loading="loading"
                   option-label="name"
                   option-value="iso"
                   emit-value
                   v-model="locale"
                   :label="$t('Select a language')"
                   :placeholder="$t('Select a language')"
                   :options="locales">
          <template #option="{ option: { name, iso } }">
            <div class="d-flex align-items-center gap-2"
                 @click="locale = iso"
                 :class="{ 'bg-indigo-lt': locale === iso }">
              <PlfCheckbox class="p-2 pe-0 border-end"
                           square
                           @click.stop
                           v-model="locale"
                           :true-value="iso" />

              <div class="pe-2">
                {{ name }}
              </div>
            </div>
          </template>
        </PlfSelect>
      </div>
    </template>

    <template #default>
      <PlfListItem nav
                   prepend-icon="mdi.IconLanguage" />
    </template>
  </PlfTooltip>
</template>

<script setup>
import PlfTooltip from '@/components/shared/tooltip/PlfTooltip.vue';
import PlfSelect from '@/components/shared/select/PlfSelect.vue';
import PlfCheckbox from '@/components/shared/checkbox/PlfCheckbox.vue';
import PlfListItem from '@/components/shared/list/PlfListItem.vue';
import { ref, watch } from 'vue';
import { useAuthStore } from '@/modules/base/stores/auth';
import { api } from '@/boot/axios';

defineProps({
  locales: {
    type: Array,
  },

  loading: {
    type: Boolean,
    default: false
  }
});

const auth = useAuthStore();

const locale = ref(auth.user.language?.iso_code);

let timer;

watch(locale, (iso) => {
  clearTimeout(timer);

  timer = setTimeout(async () => {
    await api.post('/users/set-locale', { iso });

    location.reload();
  }, 2000);
});
</script>