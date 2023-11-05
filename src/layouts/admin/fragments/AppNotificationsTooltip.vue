<template>
  <!-- Delete notification modal -->
  <DeleteModal :deleting="deleting"
               :deleted="deleted"
               v-model:visible="showDeleteModal"
               :message="$t('Are you sure you want to delete this notification?')"
               delete-button-text="Delete"
               @delete="onDeleteConfirmed" />

  <PlfTooltip trigger="click"
              :offset="5"
              :z-index="2000"
              :popper-style="{ 'padding-bottom': 0 }"
              placement="right-start">
    <div class="position-relative">
      <PlfListItem nav
                   prepend-icon="mdi.IconBellOutline" />

      <span v-if="notificationsStore.unreadNotificationsCount > 0"
            class="badge bg-danger position-absolute top-0 end-0">
      </span>
    </div>

    <template #content>
      <div v-if="notificationsStore.notifications.length > 0">
        <h3 class="m-2 text-center">{{ $t('Notifications') }}</h3>

        <PlfDivider />
      </div>

      <div class="overflow-auto"
           style="width: 300px; max-height: 300px;">
        <AppNotificationsList :notifications="notificationsStore.notifications"
                              @mark-as-read="notificationsStore.markNotificationAsRead"
                              @delete="confirmDelete" />
      </div>

      <div v-if="notificationsStore.notifications.length > 0">
        <PlfButton class="w-full rounded-bottom btn-primary fw-bold"
                   square
                   :loading="notificationsStore.markAllNotificationAsReadInProgress"
                   @click="notificationsStore.markAllNotificationAsRead">
          {{ $t('Mark all as read') }}
        </PlfButton>
      </div>
    </template>
  </PlfTooltip>
</template>

<script setup>
import { computed, onBeforeUnmount, onMounted, ref, watch } from 'vue';
import DeleteModal from '@/components/DeleteModal.vue';
import PlfButton from '@/components/shared/button/PlfButton.vue';
import PlfDivider from '@/components/shared/divider/PlfDivider.vue';
import PlfListItem from '@/components/shared/list/PlfListItem.vue';
import PlfTooltip from '@/components/shared/tooltip/PlfTooltip.vue';
import AppNotificationsList from './AppNotificationsList.vue';
import { useNotificationsStore } from '@base/stores/notifications.js';
import { useSettingsStore } from '@/modules/base/stores/settings';

const notificationsStore = useNotificationsStore();
const settings = useSettingsStore();

const deleting = ref(false);
const deleted = ref(false);
const showDeleteModal = ref(false);

const notification = ref(null);

const confirmDelete = (n) => {
  notification.value = n;
  showDeleteModal.value = true;
};

const onDeleteConfirmed = () => {
  deleting.value = true;

  notificationsStore.deleteNotification(notification.value)
    .then(() => {
      deleted.value = true;
    })
    .finally(() => {
      deleting.value = false;

      setTimeout(() => {
        deleted.value = false;
        showDeleteModal.value = false;
      }, 1000);
    });
};

onMounted(() => {
  notificationsStore.fetchNotifications();
});

let interval = null;

const isNotificationEnabled = computed(() => {
  return settings.get('base/general.notification');
});

watch(isNotificationEnabled, (newVal) => {
  clearInterval(interval);

  if (newVal) {
    interval = setInterval(() => {
      notificationsStore.fetchNotifications();
    }, 10000);
  }
}, { immediate: true });

onBeforeUnmount(() => {
  clearInterval(interval);
});
</script>

<style scoped>
:deep(.notification-item:last-child) {
  border-bottom: none !important;
}

:deep(.notification-item) {
  border-inline-end-color: transparent !important;
}

:deep(.notification-item.is-unread) {
  background-color: var(--tblr-light) !important;
  border-inline-end-color: var(--tblr-warning) !important;
}

:global([data-bs-theme='dark'] .notification-item.is-unread) {
  background-color: var(--tblr-gray-900) !important;
}
</style>