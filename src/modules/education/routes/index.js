export default {
  name: 'education',
  path: 'education',
  meta: {
    module: 'education'
  },
  component: () => import('../layouts/EducationLayout.vue'),
  children: [
    {
      name: 'admin.education.guardians',
      path: 'guardians',
      component: () => import('@education/views/guardians/GuardiansIndex.vue'),

      children: [
        {
          name: 'admin.guardians.table',
          path: '',
          component: () => import('@education/views/guardians/GuardianTable.vue')
        }
      ]
    },

    {
      name: 'admin.guardians.create',
      path: 'guardians/create',
      component: () => import('@education/views/guardians/CreateGuardianForm.vue')
    },

    {
      name: 'admin.guardians.update',
      path: 'guardians/:id/update',
      component: () => import('@education/views/guardians/UpdateGuardianForm.vue'),
      props: true
    },


    {
      name: 'admin.education.staff',
      path: 'staff',
      component: () => import('@education/views/staff/StaffIndex.vue'),

      children: [
        {
          name: 'admin.staff.table',
          path: '',
          component: () => import('@education/views/staff/StaffTable.vue')
        }
      ]
    },

    {
      name: 'admin.staff.create',
      path: 'staff/create',
      component: () => import('@education/views/staff/CreateStaffForm.vue')
    },

    {
      name: 'admin.staff.update',
      path: 'staff/:id/update',
      component: () => import('@education/views/staff/UpdateStaffForm.vue'),
      props: true
    },

    {
      name: 'admin.education.students',
      path: 'students',
      component: () => import('@education/views/students/StudentsIndex.vue'),

      children: [
        {
          name: 'admin.students.table',
          path: '',
          component: () => import('@education/views/students/StudentsTable.vue')
        }
      ]
    },

    {
      name: 'admin.students.create',
      path: 'students/create',
      component: () => import('@education/views/students/CreateStudentForm.vue')
    },

    {
      name: 'admin.students.update',
      path: 'students/:id/update',
      component: () => import('@education/views/students/UpdateStudentForm.vue'),
      props: true
    },

    {
      name: 'admin.education.classroom-types',
      path: 'classroom-types',
      component: () => import('@education/views/classroom-types/ClassroomTypesIndex.vue'),

      children: [
        {
          name: 'admin.classroom-types.table',
          path: '',
          component: () => import('@education/views/classroom-types/ClassroomTypeTable.vue')
        }
      ]
    },

    {
      name: 'admin.classroom-types.create',
      path: 'classroom-types/create',
      component: () => import('@education/views/classroom-types/CreateClassroomTypeForm.vue')
    },

    {
      name: 'admin.classroom-types.update',
      path: 'classroom-types/:id/update',
      component: () => import('@education/views/classroom-types/UpdateClassroomTypeForm.vue'),
      props: true
    },

    {
      name: 'admin.education.classrooms',
      path: 'classrooms',
      component: () => import('@education/views/classrooms/ClassroomsIndex.vue'),

      children: [
        {
          name: 'admin.classrooms.table',
          path: '',
          component: () => import('@education/views/classrooms/ClassroomTable.vue')
        }
      ]
    },

    {
      name: 'admin.classrooms.create',
      path: 'classrooms/create',
      component: () => import('@education/views/classrooms/CreateClassroomForm.vue')
    },

    {
      name: 'admin.classrooms.update',
      path: 'classrooms/:id/update',
      component: () => import('@education/views/classrooms/UpdateClassroomForm.vue'),
      props: true
    },

    {
      name: 'admin.education.cycles',
      path: 'cycles',
      component: () => import('@education/views/cycles/CyclesIndex.vue'),

      children: [
        {
          name: 'admin.cycles.table',
          path: '',
          component: () => import('@education/views/cycles/CycleTable.vue')
        }
      ]
    },

    {
      name: 'admin.cycles.create',
      path: 'cycles/create',
      component: () => import('@education/views/cycles/CreateCycleForm.vue')
    },

    {
      name: 'admin.cycles.update',
      path: 'cycles/:id/update',
      component: () => import('@education/views/cycles/UpdateCycleForm.vue'),
      props: true
    },

    {
      name: 'admin.education.branches',
      path: 'branches',
      component: () => import('@education/views/branches/BranchesIndex.vue'),

      children: [
        {
          name: 'admin.branches.table',
          path: '',
          component: () => import('@education/views/branches/BranchTable.vue')
        }
      ]
    },

    {
      name: 'admin.branches.create',
      path: 'branches/create',
      component: () => import('@education/views/branches/CreateBranchForm.vue')
    },

    {
      name: 'admin.branches.update',
      path: 'branches/:id/update',
      component: () => import('@education/views/branches/UpdateBranchForm.vue'),
      props: true
    },

    {
      name: 'admin.education.levels',
      path: 'levels',
      component: () => import('@education/views/levels/LevelsIndex.vue'),

      children: [
        {
          name: 'admin.levels.table',
          path: '',
          component: () => import('@education/views/levels/LevelsTable.vue')
        }
      ]
    },

    {
      name: 'admin.levels.create',
      path: 'levels/create',
      component: () => import('@education/views/levels/CreateLevelForm.vue')
    },

    {
      name: 'admin.levels.update',
      path: 'levels/:id/update',
      component: () => import('@education/views/levels/UpdateLevelForm.vue'),
      props: true
    },

    {
      name: 'admin.education.unities',
      path: 'unities',
      component: () => import('@education/views/unities/UnitiesIndex.vue'),

      children: [
        {
          name: 'admin.unities.table',
          path: '',
          component: () => import('@education/views/unities/UnitiesTable.vue')
        }
      ]
    },

    {
      name: 'admin.unities.create',
      path: 'unities/create',
      component: () => import('@education/views/unities/CreateUnityForm.vue')
    },

    {
      name: 'admin.unities.update',
      path: 'unities/:id/update',
      component: () => import('@education/views/unities/UpdateUnityForm.vue'),
      props: true
    },

    {
      name: 'admin.education.periods',
      path: 'periods',
      component: () => import('@education/views/periods/PeriodsIndex.vue'),

      children: [
        {
          name: 'admin.periods.table',
          path: '',
          component: () => import('@education/views/periods/PeriodsTable.vue')
        }
      ]
    },

    {
      name: 'admin.periods.create',
      path: 'periods/create',
      component: () => import('@education/views/periods/CreatePeriodForm.vue')
    },

    {
      name: 'admin.periods.update',
      path: 'periods/:id/update',
      component: () => import('@education/views/periods/UpdatePeriodForm.vue'),
      props: true
    },

    {
      name: 'admin.education.subjects',
      path: 'subjects',
      component: () => import('@education/views/subjects/SubjectsIndex.vue'),

      children: [
        {
          name: 'admin.subjects.table',
          path: '',
          component: () => import('@education/views/subjects/SubjectsTable.vue')
        }
      ]
    },

    {
      name: 'admin.subjects.create',
      path: 'subjects/create',
      component: () => import('@education/views/subjects/CreateSubjectForm.vue')
    },

    {
      name: 'admin.subjects.update',
      path: 'subjects/:id/update',
      component: () => import('@education/views/subjects/UpdateSubjectForm.vue'),
      props: true
    },

    {
      name: 'admin.education.subject-sequences',
      path: 'subject-sequences',
      component: () => import('@education/views/subject-sequences/SubjectSequencesIndex.vue'),

      children: [
        {
          name: 'admin.subject-sequences.table',
          path: '',
          component: () => import('@education/views/subject-sequences/SubjectSequencesTable.vue')
        }
      ]
    },

    {
      name: 'admin.subject-sequences.create',
      path: 'subject-sequences/create',
      component: () => import('@education/views/subject-sequences/CreateSubjectSequenceForm.vue')
    },

    {
      name: 'admin.subject-sequences.update',
      path: 'subject-sequences/:id/update',
      component: () => import('@education/views/subject-sequences/UpdateSubjectSequenceForm.vue'),
      props: true
    },

    {
      name: 'admin.education.academic-years',
      path: 'academic-years',
      component: () => import('@education/views/academic-years/AcademicYearsIndex.vue'),

      children: [
        {
          name: 'admin.academic-years.table',
          path: '',
          component: () => import('@education/views/academic-years/AcademicYearsTable.vue')
        }
      ]
    },

    {
      name: 'admin.academic-years.create',
      path: 'academic-years/create',
      component: () => import('@education/views/academic-years/CreateAcademicYearForm.vue')
    },

    {
      name: 'admin.academic-years.update',
      path: 'academic-years/:id/update',
      component: () => import('@education/views/academic-years/UpdateAcademicYearForm.vue'),
      props: true
    },


    {
      name: 'admin.education.classes',
      path: 'classes',
      component: () => import('@education/views/classes/ClassesIndex.vue'),

      children: [
        {
          name: 'admin.classes.table',
          path: '',
          component: () => import('@education/views/classes/ClassesTable.vue')
        }
      ]
    },

    {
      name: 'admin.classes.create',
      path: 'classes/create',
      component: () => import('@education/views/classes/CreateClassForm.vue')
    },

    {
      name: 'admin.classes.update',
      path: 'classes/:id/update',
      component: () => import('@education/views/classes/UpdateClassForm.vue'),
      props: true
    },


    {
      name: 'admin.education.categories',
      path: 'categories',
      component: () => import('@education/views/categories/CategoriesIndex.vue'),

      children: [
        {
          name: 'admin.categories.table',
          path: '',
          component: () => import('@education/views/categories/CategoriesTable.vue')
        }
      ]
    },

    {
      name: 'admin.categories.create',
      path: 'categories/create',
      component: () => import('@education/views/categories/CreateCategoryForm.vue')
    },

    {
      name: 'admin.categories.update',
      path: 'categories/:id/update',
      component: () => import('@education/views/categories/UpdateCategoriesForm.vue'),
      props: true
    },

    {
      name: 'admin.education.articles',
      path: 'articles',
      component: () => import('@education/views/articles/ArticlesIndex.vue'),

      children: [
        {
          name: 'admin.articles.table',
          path: '',
          component: () => import('@education/views/articles/ArticlesTable.vue')
        }
      ]
    },

    {
      name: 'admin.articles.create',
      path: 'articles/create',
      component: () => import('@education/views/articles/CreateArticleForm.vue')
    },

    {
      name: 'admin.articles.update',
      path: 'articles/:id/update',
      component: () => import('@education/views/articles/UpdateArticleForm.vue'),
      props: true
    },


    {
      name: 'admin.education.packs',
      path: 'packs',
      component: () => import('@education/views/packs/PacksIndex.vue'),

      children: [
        {
          name: 'admin.packs.table',
          path: '',
          component: () => import('@education/views/packs/PacksTable.vue')
        }
      ]
    },

    {
      name: 'admin.packs.create',
      path: 'packs/create',
      component: () => import('@education/views/packs/CreatePackForm.vue')
    },

    {
      name: 'admin.packs.update',
      path: 'packs/:id/update',
      component: () => import('@education/views/packs/UpdatePackForm.vue'),
      props: true
    },


    {
      name: 'admin.education.subscriptions',
      path: 'subscriptions',
      component: () => import('@education/views/subscriptions/SubscriptionsIndex.vue'),

      children: [
        {
          name: 'admin.subscriptions.table',
          path: '',
          component: () => import('@education/views/subscriptions/SubscriptionsTable.vue')
        }
      ]
    },

    {
      name: 'admin.subscriptions.create',
      path: 'subscriptions/create',
      component: () => import('@education/views/subscriptions/CreateSubscriptionForm.vue')
    },

    {
      name: 'admin.subscriptions.update',
      path: 'subscriptions/:id/update',
      component: () => import('@education/views/subscriptions/UpdateSubscriptionForm.vue'),
      props: true
    },

    // absence routes
    {
      name: 'admin.education.absences',
      path: 'absences',
      component: () => import('@education/views/absences/AbsencesIndex.vue'),

      children: [
        {
          name: 'admin.absences.table',
          path: '',
          component: () => import('@education/views/absences/AbsencesTable.vue')
        }
      ]
    },
    // absence types routes
    
    {
      name: 'admin.education.absence-types',
      path: 'absence-types',
      component: () => import('@education/views/absence-types/AbsenceTypesIndex.vue'),

      children: [
        {
          name: 'admin.absence-types.table',
          path: '',
          component: () => import('@education/views/absence-types/AbsenceTypesTable.vue')
        }
      ]
    },
    {
      name: 'admin.absence-types.create',
      path: 'absence-types/create',
      component: () => import('@education/views/absence-types/CreateAbsenceTypeForm.vue')
    },

    {
      name: 'admin.absence-types.update',
      path: 'absence-types/:id/update',
      component: () => import('@education/views/absence-types/UpdateAbsenceTypeForm.vue'),
      props: true
    },
    // contract types routes
    
    {
      name: 'admin.education.contract-types',
      path: 'contract-types',
      component: () => import('@education/views/contract-types/ContractTypesIndex.vue'),

      children: [
        {
          name: 'admin.contract-types.table',
          path: '',
          component: () => import('@education/views/contract-types/ContractTypesTable.vue')
        }
      ]
    },
    {
      name: 'admin.contract-types.create',
      path: 'contract-types/create',
      component: () => import('@education/views/contract-types/CreateContractTypeForm.vue')
    },

    {
      name: 'admin.contract-types.update',
      path: 'contract-types/:id/update',
      component: () => import('@education/views/contract-types/UpdateContractTypeForm.vue'),
      props: true
    },
    // employment contracts routes
    
    {
      name: 'admin.education.employment-contracts',
      path: 'employment-contracts',
      component: () => import('@education/views/employment-contracts/EmploymentContractsIndex.vue'),

      children: [
        {
          name: 'admin.employment-contracts.table',
          path: '',
          component: () => import('@education/views/employment-contracts/EmploymentContractsTable.vue')
        }
      ]
    },
    {
      name: 'admin.employment-contracts.create',
      path: 'employment-contracts/create',
      component: () => import('@education/views/employment-contracts/CreateEmploymentContractForm.vue')
    },

    {
      name: 'admin.employment-contracts.update',
      path: 'employment-contracts/:id/update',
      component: () => import('@education/views/employment-contracts/UpdateEmploymentContractForm.vue'),
      props: true
    },
    // appointment requests routes
    
    {
      name: 'admin.education.appointment-requests',
      path: 'appointment-requests',
      component: () => import('@education/views/appointment-requests/AppointmentRequestsIndex.vue'),

      children: [
        {
          name: 'admin.appointment-requests.table',
          path: '',
          component: () => import('@education/views/appointment-requests/AppointmentRequestsTable.vue')
        }
      ]
    },
    {
      name: 'admin.appointment-requests.create',
      path: 'appointment-requests/create',
      component: () => import('@education/views/appointment-requests/CreateAppointmentRequestForm.vue')
    },

    {
      name: 'admin.appointment-requests.update',
      path: 'appointment-requests/:id/update',
      component: () => import('@education/views/appointment-requests/UpdateAppointmentRequestForm.vue'),
      props: true
    },

    // medical forms routes
    
    {
      name: 'admin.education.medical-forms',
      path: 'medical-forms',
      component: () => import('@education/views/medical-forms/MedicalFormsIndex.vue'),

      children: [
        {
          name: 'admin.medical-forms.table',
          path: '',
          component: () => import('@education/views/medical-forms/MedicalFormsTable.vue')
        }
      ]
    },
    {
      name: 'admin.medical-forms.create',
      path: 'medical-forms/create',
      component: () => import('@education/views/medical-forms/CreateMedicalFormForm.vue')
    },

    {
      name: 'admin.medical-forms.update',
      path: 'medical-forms/:id/update',
      component: () => import('@education/views/medical-forms/UpdateMedicalFormForm.vue'),
      props: true
    },
    // doctor routes
    
    {
      name: 'admin.education.doctors',
      path: 'doctors',
      component: () => import('@education/views/doctors/DoctorsIndex.vue'),

      children: [
        {
          name: 'admin.doctors.table',
          path: '',
          component: () => import('@education/views/doctors/DoctorsTable.vue')
        }
      ]
    },
    {
      name: 'admin.doctors.create',
      path: 'doctors/create',
      component: () => import('@education/views/doctors/CreateDoctorForm.vue')
    },

    {
      name: 'admin.doctors.update',
      path: 'doctors/:id/update',
      component: () => import('@education/views/doctors/UpdateDoctorForm.vue'),
      props: true
    },

    // form routes
    {
      name: 'admin.education.forms',
      path: 'forms',
      component: () => import('@education/views/forms/FormsIndex.vue'),

      children: [
        {
          name: 'admin.forms.table',
          path: '',
          component: () => import('@education/views/forms/FormsTable.vue')
        }
      ]
    },
    {
      name: 'admin.forms.create',
      path: 'forms/create',
      component: () => import('@education/views/forms/CreateForm.vue'),
      // children: [
      //   {
      //     name: 'admin.forms.create.form',
      //     path: '',
      //     component: () => import('@education/views/forms/FormForm.vue'),
      //     props : true
      //   } ,
      //   {
      //     name: 'admin.forms.create.responses',
      //     path: 'responses',
      //     component: () => import('@education/views/forms/FormForm.vue'),
      //     props : true
      //   } ,
      //   {
      //     name: 'admin.forms.create.settings',
      //     path: 'settings',
      //     component: () => import('@education/views/forms/FormForm.vue'),
      //     props : true
      //   } ,
      //   {
      //     name: 'admin.forms.create.preview',
      //     path: 'preview',
      //     component: () => import('@education/views/forms/FormPreview.vue'),
      //     props : true
      //   } ,
      // ]
    },
    {
      name: 'admin.forms.update',
      path: 'forms/:id/update',
      component: () => import('@education/views/forms/UpdateForm.vue'),
      props: true
    },

    // pre inscriptions
    {
      name: 'admin.education.pre-inscriptions',
      path: 'pre-inscriptions',
      component: () => import('@education/views/pre-inscriptions/PreInscriptionsIndex.vue'),

      children: [
        {
          name: 'admin.pre-inscriptions.table',
          path: '',
          component: () => import('@education/views/pre-inscriptions/PreInscriptionsTable.vue')
        }
      ]
    },
    {
      name: 'admin.pre-inscriptions.create',
      path: 'pre-inscriptions/create',
      component: () => import('@education/views/pre-inscriptions/CreatePreInscriptionForm.vue')
    },

    {
      name: 'admin.pre-inscriptions.update',
      path: 'pre-inscriptions/:id/update',
      component: () => import('@education/views/pre-inscriptions/UpdatePreInscriptionForm.vue'),
      props: true
    },

    // participators
    {
      name: 'admin.education.participators',
      path: 'participators',
      component: () => import('@education/views/participators/ParticipatorsIndex.vue'),

      children: [
        {
          name: 'admin.participators.table',
          path: '',
          component: () => import('@education/views/participators/ParticipatorsTable.vue')
        }
      ]
    },
    // {
    //   name: 'admin.education.guardians',
    //   path: 'guardians',
    //   component: () => import('../views/guardians/StaffIndex.vue')
    // }
  ]
}