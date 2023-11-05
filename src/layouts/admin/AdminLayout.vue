<template>
  <LogoutModal :visible="showLogoutDialog"
               @update:visible="showLogoutDialog = $event" />

  <PlfLayout scrollable>
    <AppHeader :visible="mobile"
               :dark="isDark"
               :toggle-dark="toggleTheme"
               @logout="logout">
      <template #prepend>
        <PlfButton @click.stop="drawer = !drawer"
                   icon="mdi.IconMenu"
                   class="btn-action" />
      </template>
    </AppHeader>

    <PlfNavigationDrawer :order="-2"
                         @keyup.esc="(appsDrawer = false)"
                         v-model="appsDrawer"
                         overlay
                         max-height="calc(100% - 2rem)"
                         height="calc(550px - 2rem)"
                         class="bg-light-lt rounded-3 border start-0 end-0 mx-auto"
                         style="width: 95%; max-width: 600px; margin-block: 1rem;"
                         color="transparent"
                         location="bottom">
      <!-- <SearchEngineComponent v-if="searchMode"
                             ref="searchFieldRef" /> -->

      <ModuleList :modules="modules.applications"
                  class="p-3" />

    </PlfNavigationDrawer>

    <PlfNavigationDrawer :touchless="!mobile"
                         v-model="drawer"
                         :order="-1"
                         :mini="mini"
                         width="300px"
                         :rtl="isRTL">
      <div class="d-flex h-100 border-end">
        <div style="min-width: 60px;"
             class="scroll-y-hidden h-100 d-flex flex-column bg-primary-lt justify-content-between">
          <PlfList nav
                   class="flex-fill">
            <PlfListItem prepend-icon="mdi.IconUserOutline"
                         to="/admin/base/user/profile" />

            <AppNotifications v-if="notificationEnabled" />

            <PlfListItem prepend-icon="mdi.IconEmailOutline" />

            <ProfileLanguageChooser :locales="SUPPORT_LOCALES" />

            <PlfCan name="base.settings.settings">
              <PlfListItem prepend-icon="mdi.IconCogOutline"
                           nav
                           :to="{ name: 'admin.settings.base' }" />
            </PlfCan>

            <PlfListItem prepend-icon="mdi.IconBug"
                         nav
                         @click="clearCache" />

            <PlfListItem nav
                         @click="toggleTheme"
                         :prepend-icon="isDark ? 'mdi.IconWeatherSunny' : 'mdi.IconWeatherNight'" />

            <PlfCan name="base.fiscal-year.search">
              <FiscalYearChooser :loading="loadingFiscalYearsInProgress"
                                 :fiscalYears="fiscalYears" />
            </PlfCan>

            <PlfListItem prepend-icon="mdi.IconLogout"
                         nav
                         @click="logout" />
          </PlfList>

          <PlfList nav>
            <PlfListItem @click.stop="onSearchClicked"
                         value="search"
                         prepend-icon="mdi.IconSearch" />

            <PlfListItem value="apps"
                         @item-click.stop="onAppsClicked"
                         prepend-icon="mdi.IconApps" />
          </PlfList>
        </div>

        <div style="width: 300px;"
             class="overflow-y-auto flex-fill d-flex flex-column border-end h-100">
          <PlfIcon v-if="drawer"
                   style="top: var(--tblr-spacer-3);"
                   @click="(mini = !mini)"
                   class="mini-toggler"
                   :class="{ 'mini-active': mini }"
                   name="mdi.IconChevronLeft" />

          <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
            <PlfImage img-class="navbar-brand-image"
                      class="text-center my-3 mx-4"
                      src="/src/assets/logo-adsello.png" />
          </h1>

          <div class="flex-grow-1 overflow-x-hidden">
            <slot name="sidebar"></slot>
          </div>

          <PlfDivider />

          <div class="m-2">
            <CompanyChooser :loading="loadingCompaniesInProgress"
                            :companies="companies" />
          </div>
        </div>
      </div>
    </PlfNavigationDrawer>

    <PlfMain>
      <slot></slot>
    </PlfMain>
  </PlfLayout>
</template>

<script setup>
import PlfNavigationDrawer from '@/components/shared/drawer/PlfNavigationDrawer.vue';
import PlfLayout from '@/components/shared/layout/PlfLayout.vue';
import PlfMain from '@/components/shared/layout/PlfMain.vue';
import PlfIcon from '@/components/shared/icon/PlfIcon.vue';
import { ref, onMounted, computed, watch } from 'vue';
import PlfList from '@/components/shared/list/PlfList.vue';
import PlfListItem from '@/components/shared/list/PlfListItem.vue';
import PlfButton from '@/components/shared/button/PlfButton.vue';
import PlfImage from '@/components/shared/image/PlfImage.vue';
import { useBreakpoints, breakpointsBootstrapV5 } from '@vueuse/core'
import { useCookies } from '../../composables/browser/useCookies';
// import SearchEngineComponent from "@/components/shared/search-engine/SearchEngineComponent.vue";
import { PlfCan } from '@/components/shared/permission/PlfCan.js';
import CompanyChooser from './fragments/CompanyChooser.vue';
import AppHeader from './fragments/AppHeader.vue';
import LogoutModal from '@/components/LogoutModal.vue';
import PlfDivider from '@/components/shared/divider/PlfDivider.vue';
import ModuleList from './fragments/ModuleList.vue';
import AppNotifications from './fragments/AppNotificationsTooltip.vue';
import { useSettingsStore } from "@base/stores/settings.js";
import { useModulesStore } from "@base/stores/modules.js";
import FiscalYearChooser from './fragments/FiscalYearChooser.vue';
import { api } from '../../boot/axios';
import ProfileLanguageChooser from './fragments/ProfileLanguageChooser.vue';
import { SUPPORT_LOCALES } from '@/boot/i18n';
import { useLocale } from '@/composables/browser/useLocale';
import { useDark } from '@vueuse/core';
import { useToggle } from '@vueuse/core';

defineProps({
  module: {
    type: String,
  },

  model: {
    type: String,
  },

  action: {
    type: String,
  },
});

const isDark = useDark({
  selector: 'body',
  attribute: 'data-bs-theme',
});

const toggleDark = useToggle(isDark);

const cookies = useCookies();

const { get } = useSettingsStore();

const { isRTL } = useLocale();

const modules = useModulesStore();

const notificationEnabled = computed(() => get('base/general.notification'));

const toggleTheme = () => {
  toggleDark();

  const theme = isDark.value ? 'dark' : 'light';

  cookies.setItem('theme', theme, new Date().setMonth(12), '/');

  api.post('users/set-theme', { theme });
};

const drawer = ref(true);
const miniActionsDrawer = ref(false);
const mini = ref(false);
const appsDrawer = ref(false);

const breakpoints = useBreakpoints(breakpointsBootstrapV5);

const mobile = breakpoints.smallerOrEqual('md');

const LOCAL_STORAGE_MENU_KEY = 'main-menu';

watch([drawer, mini, miniActionsDrawer], ([newDrawer, newMini, newMiniActionsDrawer]) => {
  localStorage.setItem(LOCAL_STORAGE_MENU_KEY, JSON.stringify({
    drawer: newDrawer,
    mini: newMini,
    miniActionsDrawer: newMiniActionsDrawer
  }));
});

onMounted(() => {
  let menuConfig = localStorage.getItem(LOCAL_STORAGE_MENU_KEY);

  if (menuConfig) {
    menuConfig = JSON.parse(menuConfig);

    if (menuConfig) {
      drawer.value = menuConfig.drawer ?? true;
      mini.value = menuConfig.mini ?? false;
      miniActionsDrawer.value = menuConfig.miniActionsDrawer ?? true;
    }
  }
});

const clearCache = () => {
  localStorage.clear();
  location.reload();
};

const searchMode = ref(false);

const searchFieldRef = ref();

const onSearchClicked = () => {

  if (appsDrawer.value && searchMode.value) {
    searchMode.value = appsDrawer.value = false;
  } else if (appsDrawer.value) {
    searchMode.value = true;
  } else {
    searchMode.value = appsDrawer.value = true;
  }

  setTimeout(() => searchFieldRef.value.focus());
}

const onAppsClicked = () => {
  if (searchMode.value) {
    searchMode.value = false;
    appsDrawer.value = true;
  } else if (appsDrawer.value) {
    appsDrawer.value = false;
  } else {
    searchMode.value = false;
    appsDrawer.value = true;
  }
}

watch(mobile, (val, old) => {
  if (!val && old !== val) {
    drawer.value = true;
  }
});

const showLogoutDialog = ref(false);

const loadingCompaniesInProgress = ref(false);
const loadingFiscalYearsInProgress = ref(false);

const companies = ref([]);
const fiscalYears = ref([]);

const logout = () => {
  showLogoutDialog.value = true;
}

const loadCompanies = async () => {
  // loadingCompaniesInProgress.value = true;

  // return await api.get('/base/user/assigned-companies')
  //   .then(response => {
  //     companies.value = response.data;
  //   })
  //   .finally(() => {
  //     loadingCompaniesInProgress.value = false;
  //   });
}

const loadFiscalYears = async () => {
  // loadingFiscalYearsInProgress.value = true;

  // return await api.get('/education/fiscal-years')
  //   .then(response => {
  //     fiscalYears.value = response.data;
  //   })
  //   .finally(() => {
  //     loadingFiscalYearsInProgress.value = false;
  //   });
}

onMounted(() => {
  loadCompanies();
  loadFiscalYears();
});
</script>

<style scoped>
.mini-toggler {
  transition: all .5s;
  transform: translateX(-50%);
  left: 100%;
  position: fixed;
  border-radius: 50%;
  cursor: pointer;
  background-color: var(--tblr-primary);
  color: var(--tblr-white);
  height: 15px;
  width: 15px;
}

.mini-toggler.mini-active {
  transform: translateX(-50%) rotate(180deg);
}

[dir=rtl] .mini-toggler {
  left: 0;
  transform: translateX(-50%) rotate(180deg);
}

[dir=rtl] .mini-toggler.mini-active {
  transform: translateX(-50%) rotate(360deg);
}
</style>
