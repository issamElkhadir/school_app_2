<template>
  <ResourceKanban :columns="columns"
                  description-column="email"
                  name-column="first_name"
                  :title="$t('users.title')"
                  url="/users">
    <template #item="{ item }">
      <div class="border border-secondary-subtle rounded-2">
        <div class="d-flex flex-column m-2">
          <div class="d-flex justify-content-between">
            <div class="d-flex align-items-start flex-column flex-fill">
              <div class="d-flex align-items-center gap-2 mb-3">
                <img src="https://picsum.photos/200/200"
                     class="rounded-circle"
                     width="40"
                     height="40" />

                <span class="fw-bold">
                  {{ item.first_name }} {{ item.last_name }}
                </span>
              </div>

              <span class="small mb-2">
                <PlfIcon name="mdi.IconEnvelopeOutline"
                         inline />
                {{ item.email }}
              </span>

              <span class="small">
                <PlfIcon name="mdi.IconPhoneOutline"
                         inline />
                (212) 555-1234-123
              </span>
            </div>

            <PlfDropdown hide-arrow>
              <template #default>
                <PlfButton class="btn-action btn-sm"
                           icon="mdi.IconDotsHorizontal" />
              </template>

              <template #menu>
                <PlfList nav
                         class="p-0">
                  <PlfListItem class="rounded-0 my-0 py-2"
                               prepend-icon="mdi.IconPencil"
                               title="Edit" />
                  <PlfListItem class="rounded-0 my-0 py-2 text-danger"
                               prepend-icon="mdi.IconTrash"
                               title="Remove" />
                </PlfList>
              </template>
            </PlfDropdown>
          </div>
        </div>

        <PlfDivider />

        <div class="m-2 btn-actions">
          <PlfButton class="btn-sm btn-action"
                     icon="mdi.IconLike" />

          <PlfButton class="btn-sm btn-action"
                     icon="mdi.IconShare" />

          <PlfButton class="btn-sm btn-action"
                     icon="mdi.IconComment" />
        </div>

      </div>


    </template>
  </ResourceKanban>
</template>

<script setup>
import { useI18n } from 'vue-i18n';
import PlfButton from '@/components/shared/button/PlfButton.vue';
import ResourceKanban from '@/components/ResourceKanban.vue';
import PlfIcon from '@/components/shared/icon/PlfIcon.vue';
import PlfDropdown from '@/components/shared/dropdown/PlfDropdown.vue';
import PlfList from '@/components/shared/list/PlfList.vue';
import PlfListItem from '@/components/shared/list/PlfListItem.vue';
import PlfDivider from '@/components/shared/divider/PlfDivider.vue';

const { t } = useI18n();

const columns = [
  { id: 'true', label: t('Active'), color: 'success' },
  { id: 'false', label: t('Inactive'), color: 'secondary' },
];
</script>