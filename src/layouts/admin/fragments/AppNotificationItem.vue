<template>
  <div :class="{ 'is-unread': !notification.read_at, 'border-end-wide': !notification.read_at }"
       class="notification-item d-flex p-2 border-bottom gap-3">
    <div v-if="notification.data.icon">
      <PlfIcon class="icon-md"
               :class="{ [`text-${notification.data.color}`]: notification.data.color }"
               :name="notification.data.icon" />
    </div>

    <div class="d-flex flex-column flex-fill">
      <div class="fw-bold">
        {{ notification.data.title }}
      </div>

      <p class="m-0">
        {{ notification.data.body }}
      </p>

      <div>
        <small class="text-muted">
          {{ notification.created_at_friendly }}
        </small>
      </div>

      <!-- Render actions -->
      <div v-if="notification.data.actions.length > 0"
           class="d-flex mt-2">
        <div v-for="(action, index) in notification.data.actions"
             :key="`action-${index}`">
          <PlfButton :label="action.label"
                     v-if="action.asButton"
                     :icon="action.icon"
                     :color="action.color"
                     v-bind="action.props"
                     :target="action.newTab ? '_blank' : '_self'"
                     @click="onActionRun(action)"
                     class="btn-sm" />

          <a v-else
             :href="action.url"
             @click="onActionRun(action)"
             :class="`text-${action.color}`"
             :target="action.newTab ? '_blank' : '_self'"
             v-bind="action.props">
            <PlfIcon :name="action.icon" />
            {{ action.label }}
          </a>
        </div>
      </div>
    </div>

    <div class="d-flex flex-column align-self-start gap-2">
      <PlfButton class="btn-sm btn-icon btn-ghost-primary"
                 :loading="notification.markAsReadInProgress"
                 @click="markAsRead">
        <PlfIcon name="mdi.IconEye" />
      </PlfButton>

      <PlfButton class="btn-ghost-danger btn-sm btn-icon"
                 :loading="notification.deleteInProgress"
                 @click="deleteNotification">
        <PlfIcon name="mdi.IconTrash" />
      </PlfButton>
    </div>
  </div>
</template>

<script setup>
import PlfButton from '@/components/shared/button/PlfButton.vue';
import PlfIcon from '@/components/shared/icon/PlfIcon.vue';

const emit = defineEmits(['mark-as-read', 'delete']);

const props = defineProps({
  notification: {
    type: Object,
    required: true
  }
});

const markAsRead = () => {
  emit('mark-as-read', props.notification);
}

const deleteNotification = () => {
  emit('delete', props.notification);
}

const onActionRun = (action) => {
  if (action.markAsRead) {
    markAsRead();
  }
};
</script>