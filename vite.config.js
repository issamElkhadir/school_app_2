import { fileURLToPath, URL } from 'node:url'

import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import { resolve, dirname } from 'node:path'
import VueI18nPlugin from '@intlify/unplugin-vue-i18n/vite'

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [
    vue(),
    /* ... */
    VueI18nPlugin({
      /* options */
      // locale messages resource pre-compile option
      include: resolve(dirname(import.meta.url), './src/i18n/**'),
    })
  ],
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url)),
      '@base': fileURLToPath(new URL('./src/modules/base', import.meta.url)),
      '@education': fileURLToPath(new URL('./src/modules/education', import.meta.url)),
      '@accounting': fileURLToPath(new URL('./src/modules/accounting', import.meta.url)),
      
      'vue-i18n': 'vue-i18n/dist/vue-i18n.esm-bundler.js'
    }
  },

  server: {
    port: 9000
  }
})
