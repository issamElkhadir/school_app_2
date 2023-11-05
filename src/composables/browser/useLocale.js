import { computed, nextTick } from 'vue';
import { SUPPORT_LOCALES, i18n } from '@/boot/i18n';
import { api } from '@/boot/axios';
import { useTextDirection } from '@vueuse/core';

export function useLocale() {
  const dir = computed(() => {
    return SUPPORT_LOCALES.find((l) => l.iso === i18n.global.locale?.value)?.dir || 'ltr';
  });

  const isRTL = computed(() => dir.value === 'rtl');

  const mode = useTextDirection({
    selector: 'html',
    initial: dir.value
  });

  /**
   *
   * @param {string} locale - locale code
   */
  const setLocale = (locale) => {
    const dir = SUPPORT_LOCALES.find((l) => l.iso === locale)?.dir || 'ltr';

    if (i18n.mode === 'legacy') {
      i18n.global.locale = locale;
    } else {
      i18n.global.locale.value = locale;
    }

    // Set axios locale header
    api.defaults.headers.common['Accept-Language'] = locale;

    document.querySelector('html').setAttribute('lang', locale);

    mode.value = dir;
  };

  /**
   *
   * @param {string} locale - locale code
   * @param {string} module - module name
   * @returns
   */
  const loadLocale = async (locale = null, module = null) => {
    module ??= 'general';

    let key = `locale-${module}`;

    if (locale) {
      key = `${key}-${locale}`;
    }

    key = key.toLowerCase();

    const signature = localStorage.getItem(`${key}_signature`);

    const params = { module, locale };

    if (signature) {
      params.signature = signature;
    }

    const response = await api.get('t', { params });

    const data = response.data;

    let messages;

    if (data.cache) {
      const cached = localStorage.getItem(key);

      if (cached) {
        messages = JSON.parse(cached);
      } else {
        localStorage.removeItem(key);
        localStorage.removeItem(`${key}_signature`);

        // Force reload
        location.reload();
      }
    } else {
      messages = data.translations;

      localStorage.setItem(key, JSON.stringify(messages));
      localStorage.setItem(`${key}_signature`, data.signature);
    }

    if (!messages || messages.length === 0) return;

    if (!locale) {
      const locales = Object.keys(messages);
      for (const locale of locales) {
        i18n.global.mergeLocaleMessage(locale, messages[locale]);
      }
    } else {
      // set locale and locale message
      i18n.global.mergeLocaleMessage(locale, messages);
    }

    return nextTick();
  };

  const getLocale = () => i18n.locale.value;

  return {
    dir,
    isRTL,
    i18n,

    setLocale,
    getLocale,
    loadLocale
  };
}
