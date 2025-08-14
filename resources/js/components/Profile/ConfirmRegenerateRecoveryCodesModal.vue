<script lang="ts">
import confirm from '@/routes/password/confirm'

const confirmRegenerateRecoveryCodeModal = tv({
  slots: {
    base: '',
  },
})

export interface ConfirmRegenerateRecoveryCodeModalProps {
  class?: any
  ui?: Partial<typeof confirmRegenerateRecoveryCodeModal.slots>
}
export interface ConfirmRegenerateRecoveryCodeModalEmits {
  confirm: [void]
  close: [void]
}
export interface ConfirmRegenerateRecoveryCodeModalSlots {}
</script>

<script lang="ts" setup>
const props = defineProps<ConfirmRegenerateRecoveryCodeModalProps>()
const emit = defineEmits<ConfirmRegenerateRecoveryCodeModalEmits>()
defineSlots<ConfirmRegenerateRecoveryCodeModalSlots>()

const title = 'Regenerate Recovery Codes'
const description = 'Please confirm that you want to regenerate your recovery codes.'
const confirmLabel = 'Regenerate'
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

const ui = computed(() => confirmRegenerateRecoveryCodeModal())
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
