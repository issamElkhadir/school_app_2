import { defineStore } from 'pinia'
import { computed, ref } from 'vue'

export const useModulesStore = defineStore('modules', () => {
  const modules = ref([])

  const fetched = ref(false)

  const applications = computed(() => modules.value.filter((module) => module.is_application))

  const fetch = async () => {
    if (fetched.value) {
      return
    }

    // Simulate API call delay
    //! TODO: Replace with real API call
    await new Promise((resolve) => {
      setTimeout(() => {
        modules.value = [
          { name: 'base', to: '/base', is_application: true },

          { name: 'education', to: '/education', is_application: true },

          { name: 'accounting', to: '/accounting', is_application: true }
        ]

        resolve()
      }, 0)

      fetched.value = true
    })
  }

  return {
    modules,
    applications,

    fetch
  }
})
