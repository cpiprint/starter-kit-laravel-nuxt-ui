<script lang="ts">
import confirm from '@/routes/password/confirm'

const confirmEnableTwoFactorAuthenticationModal = tv({
  slots: {
    base: '',
  },
})

export interface ConfirmEnableTwoFactorAuthenticationModalProps {
  class?: any
  ui?: Partial<typeof confirmEnableTwoFactorAuthenticationModal.slots>
}
export interface ConfirmEnableTwoFactorAuthenticationModalEmits {
  confirm: [void]
  close: [void]
}
export interface ConfirmEnableTwoFactorAuthenticationModalSlots {}
</script>

<script lang="ts" setup>
const props = defineProps<ConfirmEnableTwoFactorAuthenticationModalProps>()
const emit = defineEmits<ConfirmEnableTwoFactorAuthenticationModalEmits>()
defineSlots<ConfirmEnableTwoFactorAuthenticationModalSlots>()

const title = 'Enable Two-Factor Authentication'
const description = 'Please confirm that you want to enable two-factor authentication.'
const confirmLabel = 'Enable'
const confirmColor = 'neutral'

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

const ui = computed(() => confirmEnableTwoFactorAuthenticationModal())
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
