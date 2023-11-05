<template>
  <div class="vh-100">
    <div class="page page-center">
      <div class="container container-normal py-4">
        <div class="row align-items-center g-4">
          <div class="col-lg">
            <div class="container-tight">
              <div class="text-center mb-4">
                <a href="."
                   class="navbar-brand navbar-brand-autodark">
                  <img src="../assets/logo-adsello.png"
                       height="36"
                       alt="">
                </a>
              </div>
              <div class="card card-md">
                <div class="card-body">
                  <h2 class="h2 text-center mb-4">{{ $t('auth.login.title') }}</h2>
                  <form @submit.prevent="login"
                        autocomplete="off">
                    <div class="mb-3">
                      <PlfInput :label="$t('auth.login.email')"
                                square
                                class="m-0"
                                v-model="email"
                                :errors="loginErrors['email']"
                                type="email" />
                    </div>
                    <div class="mb-2">
                      <PlfInput :type="passwordInputType"
                                square
                                class="m-0"
                                v-model="password"
                                :errors="loginErrors['password']"
                                :label="$t('auth.login.password')">
                        <template #append>
                          <PlfIcon name="tblr.IconEye"
                                   @click="togglePasswordVisibility"
                                   v-if="passwordInputType === 'password'"
                                   class="icon cursor-pointer" />
                          <PlfIcon name="tblr.IconEyeOff"
                                   @click="togglePasswordVisibility"
                                   v-else
                                   class="icon cursor-pointer" />
                        </template>

                        <template #label="{ label }">
                          <label class="form-label px-0">
                            {{ label }}
                          </label>
                        </template>
                      </PlfInput>
                    </div>
                    <div class="mb-2">
                      <PlfCheckbox v-model="rememberMe"
                                   square
                                   binary
                                   class="ps-0"
                                   :label="$t('auth.login.remember_me')" />
                    </div>
                    <div class="form-footer">
                      <PlfButton type="submit"
                                 :loading="isLoadingState"
                                 class="btn-primary w-100 btn-square"
                                 :label="$t('auth.login.submit')" />
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg d-none d-lg-block">
            <img src="../assets/illustrations/undraw_secure_login_pdn4.svg"
                 height="300"
                 class="d-block mx-auto"
                 alt="">
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import '@tabler/core/dist/css/tabler.min.css';
import PlfInput from "@/components/shared/input/PlfInput.vue";
import PlfCheckbox from "@/components/shared/checkbox/PlfCheckbox.vue";
import PlfIcon from "@/components/shared/icon/PlfIcon.vue";
import PlfButton from "@/components/shared/button/PlfButton.vue";
import { ref } from "vue";
import { useRouter } from "vue-router";
import { useAuthStore } from '@base/stores/auth';
import axios from 'axios';

const auth = useAuthStore();

defineOptions({
  async beforeRouteEnter(to, _from, next) {
    if (to.redirectedFrom) {
      next();
      return;
    }

    const auth = useAuthStore();

    const res = await auth.check();

    if (res) {
      axios.defaults.headers.common.Authorization = `Bearer ${auth.token}`;

      next(auth.redirectTo);
    } else {
      next();
    }
  }
});

const passwordInputType = ref('password');

const loginErrors = ref({});
const email = ref('admin@admin.com');
const password = ref('password');
const isLoadingState = ref(false);
const rememberMe = ref(false);

const router = useRouter();

const togglePasswordVisibility = () => {
  if (passwordInputType.value === 'password') {
    passwordInputType.value = 'text';
  } else {
    passwordInputType.value = 'password';
  }
}

const login = () => {

  // Clear login errors
  loginErrors.value = {};

  isLoadingState.value = true;

  auth.login(email.value, password.value, rememberMe.value)
    .then(async () => {
      const redirectTo = router.currentRoute.value.redirectedFrom ?? auth.redirectTo;

      // Then redirect the user to the home page
      await router.replace(redirectTo);
    })
    .catch(err => {
      loginErrors.value = err.response.data;
    })
    .finally(() => {
      isLoadingState.value = false;
    });
};
</script>

<style scoped></style>
