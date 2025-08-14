<script lang="ts">
import currentUser from '@/routes/current-user'

const confirmDeleteCurrentUserModal = tv({
  slots: {
    base: '',
  },
})

export interface ConfirmDeleteCurrentUserModalProps {
  class?: any
  ui?: Partial<typeof confirmDeleteCurrentUserModal.slots>
}
export interface ConfirmDeleteCurrentUserModalEmits {
  close: [void]
}
export interface ConfirmDeleteCurrentUserModalSlots {}
</script>

<script lang="ts" setup>
const props = defineProps<ConfirmDeleteCurrentUserModalProps>()
const emit = defineEmits<ConfirmDeleteCurrentUserModalEmits>()
defineSlots<ConfirmDeleteCurrentUserModalSlots>()

const title = 'Delete Account'
const description = 'Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm.'
const confirmLabel = 'Delete Account'

const form = useForm({
  password: '',
})
function onConfirm(password: string) {
  form.password = password

  form.submit(currentUser.destroy(), {
    onSuccess: () => emit('close'),
  })
}

function onClose() {
  emit('close')
}

const ui = computed(() => confirmDeleteCurrentUserModal())
</script>

<template>
  <ConfirmPasswordModal
    :title="title"
    :description="description"
    :confirm-label="confirmLabel"
    :password-error="form.errors.password"
    :loading="form.processing"
    :class="ui.base({ class: [props.ui?.base, props.class] })"
    @confirm="onConfirm"
    @close="onClose"
  />
</template>
