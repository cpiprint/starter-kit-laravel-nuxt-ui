<script lang="ts">
import ConfirmDeleteCurrentUserModal from '@/components/Profile/ConfirmDeleteCurrentUserModal.vue'

const deleteCurrentUserSection = tv({
  slots: {
    base: '',
  },
})

export interface DeleteCurrentUserSectionProps {
  delay?: number
  class?: any
  ui?: Partial<typeof deleteCurrentUserSection.slots>
}
export interface DeleteCurrentUserSectionEmits {}
export interface DeleteCurrentUserSectionSlots {}
</script>

<script lang="ts" setup>
const props = defineProps<DeleteCurrentUserSectionProps>()
defineEmits<DeleteCurrentUserSectionEmits>()
defineSlots<DeleteCurrentUserSectionSlots>()

const overlay = useOverlay()
function onClick() {
  overlay
    .create(ConfirmDeleteCurrentUserModal, {
      destroyOnClose: true,
    })
    .open()
}

const ui = computed(() => deleteCurrentUserSection())
</script>

<template>
  <ProfileSection
    title="Delete Account"
    description="Permanently delete your account."
    :delay="props.delay"
    :class="ui.base({ class: [props.ui?.base, props.class] })"
  >
    <template #actions>
      <UButton
        label="Delete Account"
        color="error"
        type="submit"
        @click="onClick"
      />
    </template>
  </ProfileSection>
</template>
