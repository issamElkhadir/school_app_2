import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useAcademicYearsStore = defineStore('classes', () => {
  const academicYears = ref([{ name: '2021-2022' }, { name: '2022-2023' }])

  const activeAcademicYear = ref(academicYears.value[0])

  return {
    academicYears,
    activeAcademicYear
  }
})
