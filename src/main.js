import { boot } from './boot/axios';
import i18n from './boot/i18n';
import { setupCalendar } from 'v-calendar';

import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import router from './router'

const app = createApp(App)

app.use(createPinia())
app.use(router)
app.use(setupCalendar)
app.use(boot)
app.use(i18n)

app.mount('#app')

app.config.productionTip = false;

window.onerror = function(message, source, lineno, colno, error) {
  console.log('error message:', {message, source, lineno, colno, error});
}

// Handle all Vue errors
app.config.errorHandler = (error, component, info) => {
  if (import.meta.env.DEV) {
    console.error(error);
  } else {
    // TODO send to sentry or similar
  }
};