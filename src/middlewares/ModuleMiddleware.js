import { useModulesStore } from "@/modules/base/stores/modules"

export function ModuleMiddleware(module = null) {
  return async function MyMiddleware({ to, next, redirect }) {
    if (!module && (!to.meta.module || (to.meta.type === 'error' && to.redirectedFrom))) {
      next()
      return
    }

    module ??= to.meta.module

    const modules = useModulesStore()
    // Fetch modules
    await modules.fetch()
  
    const index = modules.applications.findIndex((e) => {
      return e.name === module
    })
  
    if (index === -1) {
      redirect({ name: '404' })
      return
    }
  
    next()
  }
}