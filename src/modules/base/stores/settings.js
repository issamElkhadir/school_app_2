import { defineStore } from 'pinia'
import { ref } from 'vue'
import { get, set, has, remove } from '@/composables/utils/object.js'
import { api } from '@/boot/axios';

export const useSettingsStore = defineStore('settings', () => {
  const settings = ref({})

  /**
   * Get a setting from the store
   *
   * @param {string} key the key of the setting to get
   * @param {*} defaultVal the default value to return if the setting does not exist
   * @returns {*} the setting value or the default value
   */
  const getSettings = (key, defaultVal) => get(settings.value, key, defaultVal)

  /**
   * Set a setting in the store
   *
   * @param {string} key the key of the setting to set
   * @param {*} value the value of the setting to set
   * @returns {void}
   */
  const setSettings = (key, value) => set(settings.value, key, value)

  /**
   * Check if a setting exists in the store
   *
   * @param {string} key the key of the setting to check
   * @returns {boolean} true if the setting exists, false otherwise
   */
  const hasSettings = (key) => has(settings.value, key)

  /**
   * Remove a setting from the store by key
   *
   * @param {string} key the key of the setting to remove
   * @returns {void}
   */
  const removeSettings = (key) => remove(settings.value, key)

  /**
   * Fetch settings from the API
   * 
   * @returns {Promise<import('axios').AxiosResponse>} the API response
   */
  const fetch = async () => {
    const response = await api.get('settings');

    settings.value = response.data.data;

    return response;
  }

  return {
    settings,

    get: getSettings,
    set: setSettings,
    has: hasSettings,
    remove: removeSettings,
    fetch,
  }
});