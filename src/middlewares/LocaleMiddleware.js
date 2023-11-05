import { useLocale } from '@/composables/browser/useLocale'
import { useAuthStore } from '@/modules/base/stores/auth'
import { i18n } from '@/boot/i18n'

export async function LocaleMiddleware({ to, next }) {
  const auth = useAuthStore()

  const user = auth.user

  // Get the default locale from .env
  let locale = import.meta.env.VITE_APP_LOCALE

  const { setLocale, loadLocale } = useLocale()

  if (user) {
    let language = user.language

    if (language) {
      if (i18n.global.availableLocales.includes(language.iso_code)) {
        locale = language.iso_code
      }
    }
  }

  // load locale messages
  await loadLocale(locale, to.meta.module)

  // set i18n language
  setLocale(locale)

  return next()
}
