<template>
  <div class="page-wrapper lvh-100">
    <div class="page-header mt-3 d-print-none">
      <div class="container-fluid">
        <div class="row g-2 align-items-center">
          <div class="col">
            <h2 class="page-title">
              Manage Role Permissions
            </h2>
          </div>

          <!-- Page title actions -->
          <div class="col-auto ms-auto d-print-none">
            <div class="btn-list">
              <PlfButton color="primary"
                         @click="savePermissions"
                         :loading="saving"
                         icon="mdi.IconContentSave"
                         label="Save" />
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="flex-fill page-body mt-3">
      <div class="container-fluid d-flex mb-2 flex-column h-100">
        <PlfTabView>
          <PlfTabPanel v-for="(module, key) in searchResults"
                       :key="`module-${key}`"
                       :header="module.label">
            <div class="table-responsive">
              <table class="table table-borderless">
                <thead>
                  <tr>
                    <th class="text-nowrap p-2">
                      <PlfInput borderless
                                v-model="search"
                                class="text-reset fs-5"
                                placeholder="Start type permission name or type...">
                        <template #append>
                          <PlfIcon class="text-muted"
                                   name="mdi.IconSearch" />
                        </template>
                      </PlfInput>
                    </th>

                    <th v-for="role in roles"
                        :key="`role-${role.id}`"
                        class="p-2"
                        role="col">
                      <div class="p-0 d-flex justify-content-between text-muted text-uppercase fs-5 fw-semibold">
                        <span>Name</span>

                        <PlfIcon inline
                                 name="mdi.IconDotsVertical" />
                      </div>
                      <div class="p-0 text-nowrap">{{ role.name }}</div>
                    </th>
                  </tr>
                </thead>

                <template v-for="resource in module.resources"
                          :key="`permissions-${resource.name}`">
                  <tbody>
                    <tr class="resource-row-group">
                      <th class="cursor-pointer user-select-none "
                          @click="toggleVisibility(key, resource.name)">
                        <div class="d-flex justify-content-between align-items-center">
                          <div class="text-nowrap">
                            <PlfIcon
                                     :name="expanded[key]?.[resource.name] ? 'mdi.IconChevronUp' : 'mdi.IconChevronDown'" />
                            <span class="ms-2">
                              {{ resource.label }}
                            </span>
                          </div>
                          <span class="badge badge-pill bg-muted-lt px-2 fs-5 ms-auto border">
                            {{ resource.permissions.length }}
                          </span>
                        </div>
                      </th>

                      <td v-for="role in roles"
                          class="text-center"
                          :key="`permission-${resource.name}-role-${role.id}`">
                        <PlfCheckbox :model-value="resourcesStatus[role.id][key][resource.name]"
                                     :binary="false"
                                     @update:model-value="togglePermission(key, role.id, resource.name)"
                                     class="d-inline-flex ps-0" />
                      </td>
                    </tr>
                  </tbody>


                  <tbody v-show="expanded[key]?.[resource.name] ?? true">
                    <tr class="resource-row-detail"
                        v-for="permission in resource.permissions"
                        :key="`permission-${permission.name}`">
                      <td>
                        <div class="d-flex justify-content-between align-items-center">
                          <span>{{ permission.label }}</span>

                          <PlfIcon class="text-muted"
                                   inline
                                   v-if="permission.description"
                                   name="mdi.IconInfo" />
                        </div>
                      </td>

                      <td v-for="role in roles"
                          class="text-center"
                          :key="`permission-${permission.name}-role-${role.id}`">
                        <PlfCheckbox class="ps-0 d-inline-flex"
                                     :value="permission.name"
                                     v-model="assignedPermissions[role.id]" />
                      </td>
                    </tr>
                  </tbody>
                </template>
              </table>
            </div>
          </PlfTabPanel>
        </PlfTabView>
      </div>
    </div>
  </div>
</template>

<script setup>
import { api } from '@/boot/axios';
import PlfButton from '@/components/shared/button/PlfButton.vue';
import PlfCheckbox from '@/components/shared/checkbox/PlfCheckbox.vue';
import PlfIcon from '@/components/shared/icon/PlfIcon.vue';
import PlfInput from '@/components/shared/input/PlfInput.vue';
import PlfTabPanel from '@/components/shared/tabview/PlfTabPanel.vue';
import PlfTabView from '@/components/shared/tabview/PlfTabView.vue';
import { useToast } from '@/components/shared/toast/useToast';
import { computed, onMounted, ref } from 'vue';

// The search value
const search = ref(null);

// The list of roles to be updated
const roles = ref([]);

// The list of assigned to roles (key by role id)
const assignedPermissions = ref({});

// The list of all available permissions
const permissions = ref({});

// Saving state
const saving = ref(false);

// The list of expanded resources
const expanded = ref({});

const toast = useToast();

// Load permissions and roles on component mounted
onMounted(() => {
  api.get('/permissions/all').then(({ data }) => {
    permissions.value = data.data;
  });

  api.get('/roles/all', {
    params: {
      include: 'permissions'
    }
  }).then(({ data }) => {
    roles.value = data.data;

    for (const role of roles.value) {
      assignedPermissions.value[role.id] = role.permissions ?? [];
    }
  });
});

// The search result by model label and permission label
const searchResults = computed(() => {
  if (!search.value) {
    return permissions.value;
  }

  const enteredSearch = search.value.toLowerCase();

  return Object.fromEntries(
    Object.entries(permissions.value).map(([key, module]) => {
      if (module.label.toLowerCase().includes(enteredSearch)) {
        return [key, module];
      }

      const resources = module.resources.map(resource => {

        const clone = { ...resource };

        clone.permissions = clone.permissions.filter(p => {
          return p.label.toLowerCase().includes(enteredSearch);
        });


        return clone.permissions.length > 0 ? clone : null;
      }).filter(Boolean);

      return [key, { ...module, resources }];
    })
  );
});

// Toggle resource visibility by module
const toggleVisibility = (module, resource) => {
  if (!(module in expanded.value)) {
    expanded.value[module] = {};
  }

  if (!(resource in expanded.value[module])) {
    expanded.value[module][resource] = true;
  }

  expanded.value[module][resource] = !expanded.value[module][resource];
}

/**
 * The status of each resource
 * 
 * null: some permissions checked
 * false: none of the resource permissions are checked
 * true: all permissions of the resource are checked
 */
const resourcesStatus = computed(() => {

  const result = {};

  for (const role of roles.value) {
    result[role.id] = {};

    for (const module in searchResults.value) {
      const resources = searchResults.value[module].resources;

      result[role.id][module] = {};

      resources.forEach(resource => {
        const resourcePermissions = resource.permissions.map(p => p.name);

        const assigned = assignedPermissions.value[role.id].filter(p => {
          return resourcePermissions.includes(p);
        });

        result[role.id][module][resource.name] = assigned.length === resource.permissions.length ? true : assigned.length > 0 ? null : false;
      });
    }
  }

  return result;
});

const togglePermission = (module, role, resource) => {
  if (resourcesStatus.value[role][module][resource] !== true) {
    const oldPermissions = assignedPermissions.value[role];

    const newPermissions = searchResults.value[module].resources.find(p => p.name === resource).permissions.map(p => p.name);

    assignedPermissions.value[role] = [
      ...new Set(oldPermissions.concat(newPermissions))
    ];
  } else {
    const permissionsToExclude = searchResults.value[module].resources.find(p => p.name === resource).permissions;

    assignedPermissions.value[role] = assignedPermissions.value[role].filter(p => {
      return !permissionsToExclude.map(p => p.name).includes(p);
    });
  }
}

const savePermissions = () => {
  saving.value = true;

  const roles = Object.keys(assignedPermissions.value);

  const permissions = roles.map(id => {
    return {
      role: {
        id,
        permissions: assignedPermissions.value[id]
      }
    }
  });

  api.put('permissions', permissions)
    .then(response => {
      console.log({ response });

      toast.add({
        severity: 'success',
        position: 'bottom-right',
        summary: 'Success',
        detail: response.data.message,
      });
    }).catch(error => {
      console.log({ error: error.response });

      toast.add({
        severity: 'error',
        position: 'bottom-right',
        summary: 'Error',
        detail: error.response.data.message,
      });
    }).finally(() => {
      saving.value = false;
    });
}
</script>

<style>
:root {
  --table-border-width: .5px;
  --table-border-color: var(--tblr-gray-300);
}

[data-bs-theme="dark"] {
  --table-border-color: var(--tblr-gray-600);
}
</style>

<style scoped>
.table {
  border-collapse: separate;
  border-spacing: 0;
  width: 100%;
}

.table td,
.table th {
  padding: 10px;
  border: var(--table-border-width) solid var(--table-border-color);
}

.table tr th:first-child,
.table tr td:first-child {
  position: sticky;
  -webkit-position: sticky;
  left: 0;
  z-index: 1;
  overflow: visible;
  background-color: var(--tblr-white);
}

.table .resource-row-group th,
.table .resource-row-group td {
  background-color: var(--tblr-gray-200) !important;
  cursor: pointer;
}

.table th:first-child,
.table td:first-child {
  min-width: 300px;

  width: 300px;

  max-width: 300px;
}

[data-bs-theme="dark"] .table .resource-row-group th,
[data-bs-theme="dark"] .table .resource-row-group td {
  background-color: var(--tblr-gray-700) !important;
}

[data-bs-theme="dark"] .table tr th:first-child,
[data-bs-theme="dark"] .table tr td:first-child {
  background-color: var(--tblr-dark);
}
</style>