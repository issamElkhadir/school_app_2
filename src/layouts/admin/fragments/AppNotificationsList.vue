<template>
  <AppNotificationItem v-for="notification in notifications"
                       :key="notification.id"
                       @mark-as-read="emit('mark-as-read', notification)"
                       @delete="emit('delete', notification)"
                       :notification="notification" />

  <div v-if="notifications.length === 0">
    <div class="d-flex flex-column align-items-center gap-3 p-3">
      <PlfIcon class="icon-md text-muted"
               name="mdi.IconBellOffOutline" />

      <span>{{ $t(emptyNotifications) }}</span>
    </div>
  </div>
</template>

<script setup>
import PlfIcon from '@/components/shared/icon/PlfIcon.vue';
import AppNotificationItem from './AppNotificationItem.vue';

const emit = defineEmits(['mark-as-read', 'delete']);

defineProps({
  notifications: {
    type: Array,
    required: true
  },

  emptyNotifications: {
    type: String,
    default: 'There\'s no notification'
  }
});
</script>