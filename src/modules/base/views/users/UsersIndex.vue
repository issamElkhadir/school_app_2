<template>
  <ResourceIndex :modes="modes">
    <template #default="props">
      <RouterView v-bind="props" />
    </template>

    <template #actions>
      <PlfButton class="btn d-none d-sm-inline-block"
                 icon="mdi.IconPlus"
                 color="primary"
                 :to="{ name: 'admin.users.create' }"
                 label="New" />
    </template>

    <template #subtitle>
      <PlfBreadcrumb>
        <PlfBreadcrumbEl label="Base"
                         icon="tblr.IconPackage"
                         class="text-danger" />

        <PlfBreadcrumbEl label="Users"
                         :to="{ name: 'admin.users.table' }" />

        <PlfBreadcrumbEl label="Index" />
      </PlfBreadcrumb>
    </template>

    <template #cards>

      <div class="mb-3">
        <div class="row gx-3">
          <div class="col-12 col-md-4">
            <div class="p-3 border rounded">
              <div class="d-inline-flex text-muted justify-content-between w-100 align-items-center">
                <span class="fw-bold">Total customers</span>

                <PlfIcon name="tblr.IconDotsVertical" />
              </div>

              <div class="d-inline-flex justify-content-between w-100 align-items-center">
                <span class="display-5 fw-bold">
                  2,420
                </span>

                <span class="badge bg-success-lt rounded-pill">
                  <PlfIcon name="mdi.IconArrowUp"
                           inline />
                  12.5%
                </span>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="p-3 border rounded">
              <div class="d-inline-flex text-muted justify-content-between align-items-center w-100">
                <span class="fw-bold">Members</span>
                <PlfIcon name="tblr.IconDotsVertical" />
              </div>

              <div class="d-inline-flex justify-content-between w-100 align-items-center">
                <span class="display-5 fw-bold">
                  1,210
                </span>

                <span class="badge bg-success-lt rounded-pill">
                  <PlfIcon name="mdi.IconArrowUp"
                           inline />
                  12.5%
                </span>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="p-3 border rounded">
              <div class="d-inline-flex text-muted justify-content-between align-items-center w-100">
                <span class="fw-bold">Active now</span>
                <PlfIcon name="tblr.IconDotsVertical" />
              </div>

              <div class="d-inline-flex position-relative pe-3 justify-content-between w-100 align-items-center">
                <span class="display-5 fw-bold">
                  316
                </span>

                <div class="avatar-list avatar-list-stacked">
                  <span class="avatar avatar-xs shadow-sm rounded-circle"
                        style="background-image: url('https://preview.tabler.io/static/avatars/000m.jpg')"></span>
                  <span class="avatar avatar-xs shadow-sm rounded-circle"
                        style="background-image: url('https://preview.tabler.io/static/avatars/001f.jpg')"></span>
                  <span class="avatar avatar-xs shadow-sm rounded-circle"
                        style="background-image: url('https://preview.tabler.io/static/avatars/002f.jpg')"></span>
                  <span class="avatar avatar-xs shadow-sm rounded-circle"
                        style="background-image: url('https://preview.tabler.io/static/avatars/002m.jpg')"></span>
                  <span class="avatar avatar-xs shadow-sm rounded-circle">+8</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </template>
  </ResourceIndex>
</template>

<script setup>
import PlfBreadcrumb from '@/components/shared/breadcrumb/PlfBreadcrumb.vue';
import ResourceIndex from '@/components/ResourceIndex.vue';
import PlfButton from '@/components/shared/button/PlfButton.vue';
import PlfIcon from '@/components/shared/icon/PlfIcon.vue';
import PlfBreadcrumbEl from '@/components/shared/breadcrumb/PlfBreadcrumbEl.vue';

const modes = [
  {
    title: 'Table',
    icon: 'mdi.IconMenu',
    to: { name: 'admin.users.table' },
  },

  {
    title: 'Kanban',
    icon: 'mdi.IconViewColumn',
    to: { name: 'admin.users.kanban' },
  }
]
</script>