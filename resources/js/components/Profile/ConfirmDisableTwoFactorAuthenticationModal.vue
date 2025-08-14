<script lang="ts">
import confirm from '@/routes/password/confirm'

const confirmDisableTwoFactorAuthenticationModal = tv({
  slots: {
    base: '',
  },
})

export interface ConfirmDisableTwoFactorAuthenticationModalProps {
  class?: any
  ui?: Partial<typeof confirmDisableTwoFactorAuthenticationModal.slots>
}
export interface ConfirmDisableTwoFactorAuthenticationModalEmits {
  confirm: [void]
  close: [void]
}
export interface ConfirmDisableTwoFactorAuthenticationModalSlots {}
</script>

<script lang="ts" setup>
const props = defineProps<ConfirmDisableTwoFactorAuthenticationModalProps>()
const emit = defineEmits<ConfirmDisableTwoFactorAuthenticationModalEmits>()
defineSlots<ConfirmDisableTwoFactorAuthenticationModalSlots>()

const title = 'Disable Two-Factor Authentication'
const description = 'Please confirm that you want to disable two-factor authentication.'
const confirmLabel = 'Disable'
const confirmColor = 'error'

const form = reactive({
  processing: false,
  error: undefined,
})
function onConfirm(password: string) {
  form.processing = true
  window.axios.post(confirm.store().url, { password })
    .then(() => {
      emit('confirm')
      emit('close')
    })
    .catch((error) => {
      console.error(error)
      if (error.status === 422) {
        form.error = error.response.data.message
      }
    })
    .finally(() => {
      form.processing = false
    })
}

function onClose() {
  emit('close')
}

const ui = computed(() => confirmDisableTwoFactorAuthenticationModal())
</script>

<template>
  <ConfirmPasswordModal
    :title="title"
    :description="description"
    :confirm-label="confirmLabel"
    :confirm-color="confirmColor"
    :password-error="form.error"
    :loading="form.processing"
    :class="ui.base({ class: [props.ui?.base, props.class] })"
    @confirm="onConfirm"
    @close="onClose"
  />
</template>
