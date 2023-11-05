import { computed, ref } from 'vue'
import { useToast } from '@/components/shared/toast/useToast.js'
import { defineStore } from 'pinia'
import { api } from '@/boot/axios.js'

export const useNotificationsStore = defineStore('notifications', () => {
  const toast = useToast()

  /**
   * The list of notifications.
   *
   * @type {Array}
   */
  const notifications = ref([])

  /**
   * Indicates if the mark all notification as read is in progress.
   *
   * @type {boolean}
   * @default false
   */
  const markAllNotificationAsReadInProgress = ref(false)

  /**
   * Returns the number of unread notifications.
   *
   * @returns {number}
   */
  const unreadNotificationsCount = computed(() => {
    return notifications.value.filter((notification) => !notification.read_at).length
  })

  const fetchNotifications = async () => {
    return await api.get('/notifications', { params: { sort: '-created_at' } }).then((response) => {
      notifications.value = response.data.data

      notifications.value
        .filter((notification) => !notification.received_at)
        .forEach((notification) => {
          toast.add({
            summary: notification.data.title,
            detail: notification.data.body,
            severity: notification.data.status,
            life: notification.data.duration,
            position: 'bottom-right'
          })
        })
    })
  }

  /**
   * Mark the given notification as read.
   *
   * @param {*} notification
   */
  const markNotificationAsRead = async (notification) => {
    notification.markAsReadInProgress = true

    return await api
      .put(`/notifications/${notification.id}/read`)
      .then(() => {
        fetchNotifications()
      })
      .finally(() => {
        notification.markAsReadInProgress = false
      })
  }

  /**
   * Delete the given notification.
   *
   * @param {*} notification
   * @returns
   */
  const deleteNotification = async (notification) => {
    notification.deleteInProgress = true

    return await api
      .delete(`/notifications/${notification.id}`)
      .then(() => {
        fetchNotifications()
      })
      .finally(() => {
        notification.deleteInProgress = false
      })
  }

  /**
   * Mark all notifications as read.
   *
   * @returns {Promise}
   */
  const markAllNotificationAsRead = async () => {
    markAllNotificationAsReadInProgress.value = true
    return await api
      .post('/notifications/read-all')
      .then(() => {
        fetchNotifications()
      })
      .finally(() => {
        markAllNotificationAsReadInProgress.value = false
      })
  }

  return {
    notifications,

    markAllNotificationAsReadInProgress,

    unreadNotificationsCount,

    markAllNotificationAsRead,
    deleteNotification,
    markNotificationAsRead,
    fetchNotifications
  }
})
