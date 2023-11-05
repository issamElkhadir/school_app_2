<template>
  <div class="page">

    <div class="page-wrapper">
      <div class="page-header d-print-none">
        <div class="container-xl">
          <div class="row g-2 align-items-center">
            <div class="col">
              <h2 class="page-title">
                Artisan Commander
              </h2>

              <div class="page-subtitle">
                Execute artisan commands from the browser.
              </div>
            </div>

            <div class="col text-end">
              <div class="row">
                <div class="col-6">
                  <PlfInput v-model="username" />
                </div>

                <div class="col-5">
                  <PlfInput v-model="password"
                            type="password" />
                </div>

                <div class="col">
                  <PlfButton :loading="loggingIn"
                             @click="login"
                             icon="mdi.IconLogin" />
                </div>
              </div>

              <span class="float-start text-success">
                Lorem ipsum dolor sit amet.
              </span>
            </div>
          </div>
        </div>
      </div>

      <div class="page-body">

        <div class="container-xl">
          <PlfInput v-model="command"
                    @keyup.enter="execute">
            <template #prepend>
              <code class="language-html d-inline-block p-1">php artisan</code>
            </template>

            <template #suffix>
              <PlfButton :loading="executing"
                         @click="execute"
                         icon="mdi.IconPlay" />
            </template>
          </PlfInput>

          <div class="bg-white shadow-sm rounded overflow-hidden border mt-2">
            <div class="p-3 pb-0">
              <p class="text-muted">Output:</p>
            </div>

            <pre class="pt-0"
                 v-html="output"></pre>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { api } from '@/boot/axios';
import PlfButton from '@/components/shared/button/PlfButton.vue';
import PlfInput from '@/components/shared/input/PlfInput.vue';

import { ref } from 'vue';
import { ansi2html } from './ansi2html.js'

const command = ref(null);

const output = ref();

const executing = ref(false);

const execute = () => {
  executing.value = true;

  api.post('/artisan', {
    command: command.value
  }).then(({ data }) => {
    output.value = ansi2html(data.output ?? '');
  }).catch(({ response }) => {
    output.value = response.data.output;
  }).finally(() => {
    executing.value = false;
  });
}

const startServer = () => {
  api.post('/artisan/serve').then(({ data }) => {
    output.value = ansi2html(data.output ?? '');
  }).catch(({ response }) => {
    output.value = response.data.output;
  }).finally(() => {
    executing.value = false;
  });
}
</script>

<style scoped>
pre {
  all: unset;
  width: 100%;
  display: block;
  height: 350px;
  padding: 1rem;
  border-radius: var(--tblr-border-radius);
  font-size: 0.875rem;
  font-family: 'Fira Code', monospace;
  line-height: 1.5;
  overflow-x: auto;
  margin-bottom: 0;

  white-space: -moz-pre-wrap;
  white-space: -o-pre-wrap;
  white-space: -pre-wrap;
  white-space: pre-wrap;
  word-wrap: break-word;
  overflow-wrap: break-word;
}
</style>