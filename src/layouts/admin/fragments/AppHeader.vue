<template>
  <PlfAppBar height="50px"
             :model-value="visible"
             :class="{'bg-dark': dark, 'bg-light': !dark}">
    <div class="d-flex justify-content-between h-100 align-items-center px-2">
      <slot name="prepend"></slot>

      <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
        <PlfImage width="8rem"
                  img-class="navbar-brand-image"
                  src="/src/assets/logo-adsello.png" />
      </h1>

      <div>
        <PlfButton @click="toggleDark"
                   class="btn-action">
          <PlfIcon v-if="dark"
                   name="mdi.IconWeatherSunny" />
          <PlfIcon v-else
                   name="mdi.IconWeatherNight" />
        </PlfButton>

        <PlfCan name="base.settings.settings">
          <RouterLink class="btn btn-action"
                      to="/admin/base/settings/settings">
            <PlfIcon name="mdi.IconCogOutline" />
          </RouterLink>
        </PlfCan>

        <RouterLink class="btn btn-action"
                    to="/admin/base/user/profile">
          <PlfIcon name="mdi.IconUserOutline" />
        </RouterLink>

        <PlfButton icon="mdi.IconLogout"
                   @click="logout"
                   class="btn-action" />
      </div>
    </div>

    <PlfDivider />
  </PlfAppBar>
</template>

<script setup>

import PlfIcon from "@/components/shared/icon/PlfIcon.vue";
import PlfAppBar from "@/components/shared/layout/PlfAppBar.vue";
import PlfButton from "@/components/shared/button/PlfButton.vue";
import PlfImage from "@/components/shared/image/PlfImage.vue";
import { PlfCan } from "@/components/shared/permission/PlfCan";
import PlfDivider from "@/components/shared/divider/PlfDivider.vue";

const emit = defineEmits(['logout']);

defineProps({
  visible: {
    type: Boolean,
    required: true
  },

  dark: {
    type: Boolean,
    default: false
  },

  toggleDark: {
    type: Function,
    required: true
  }
});

const logout = () => {
  emit('logout');
}
</script>
