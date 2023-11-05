import { defineStore } from 'pinia'
import { computed, ref } from 'vue'
import { api } from '@/boot/axios'
import { useCookies } from '@/composables/browser/useCookies'
import axios from 'axios'

export const useAuthStore = defineStore('auth', () => {
  const cookies = useCookies()

  const user = ref(null)
  const token = ref(null)

  const redirectTo = computed(() => {
    let to = null

    if (user.value) {
      switch (user.value.profile?.type) {
        case 'staff':
          to = { name: 'admin.users.table' }
          break

        case 'student':
          to = { name: 'front.dashboard' }
          break

        default:
          to = { name: 'login' }
          break
      }
    }

    return to
  })

  /**
   * Login the user
   *
   * @param {*} email  The email of the user
   * @param {*} password  The password of the user
   * @param {*} remember  If the user wants to be remembered
   * @returns  {Promise}  The promise of the login request
   */
  const login = async (email, password, remember = false) => {
    return await api
      .post('/auth/login', {
        email: email,
        password: password,
        remember: remember
      })
      .then((response) => {
        token.value = response.data.access_token
        const expiresIn = response.data.expires_in
        user.value = response.data.user

        if (remember) {
          cookies.setItem('token', token.value, expiresIn, '/')
        } else {
          cookies.setItem('token', token.value, null, '/')
        }

        axios.defaults.headers.common['Authorization'] = `Bearer ${token.value}`
      })
  }

  /**
   * Logout the user
   *
   * @returns  {Promise}  The promise of the logout request
   */
  const logout = async () => {
    return await api.post('/auth/logout').then(() => {
      user.value = null
      token.value = null

      cookies.removeItem('token')
    })
  }

  /**
   * Refresh the user token
   *
   * @returns {Promise}  The promise of the refresh request
   */
  const refresh = async () => {
    return await api.post('/auth/refresh').then((response) => {
      token.value = response.data.access_token
      const expiresIn = response.data.expires_in
      user.value = response.data.user

      cookies.setItem('token', token.value, expiresIn)

      axios.defaults.headers.common['Authorization'] = `Bearer ${token.value}`
    })
  }

  /**
   * Check if the user is logged in
   *
   * @returns {Promise}  The promise of the check request
   * @returns {Boolean}  If the user is logged in
   */
  const check = async () => {
    if (user.value) {
      return true
    }
    
    if (!cookies.hasItem('token')) {
      return false
    }

    return await api
      .post('/auth/me')
      .then((response) => {
        user.value = response.data.user
        token.value = cookies.getItem('token') || response.data.access_token

        return true
      })
      .catch(() => {
        user.value = null
        token.value = null

        cookies.removeItem('token')

        return false
      })
  }

  return {
    user,
    token,
    redirectTo,

    check,
    login,
    refresh,
    logout
  }
})
