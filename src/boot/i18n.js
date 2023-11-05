import { createI18n } from 'vue-i18n'
import messages from '../i18n'
import { useLocale } from '@/composables/browser/useLocale';

// TODO: Should be fetched from the API
const SUPPORT_LOCALES = [
  { iso: 'en-US', name: 'English', nativeName: 'English', dir: 'ltr' },
  { iso: 'ar-MA', name: 'Arabic', nativeName: 'العربية', dir: 'rtl' },
  { iso: 'fr-FR', name: 'French', nativeName: 'Français', dir: 'ltr' },
  { iso: 'es-ES', name: 'Spanish', nativeName: 'Español', dir: 'ltr' }
];

const i18n = createI18n({
  legacy: false,
  locale: import.meta.env.VITE_APP_LOCALE,
  fallbackLocale: import.meta.env.VITE_APP_FALLBACK_LOCALE,
  globalInjection: true,
  availableLocales: SUPPORT_LOCALES.map((locale) => locale.iso),
  messages
})

const { setLocale } = useLocale();

export default {
  install: (app) => {
    // Set the default locale
    setLocale(import.meta.env.VITE_APP_LOCALE)

    app.use(i18n)
  }
}

export { i18n, SUPPORT_LOCALES }