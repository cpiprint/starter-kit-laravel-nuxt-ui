<script lang="ts">
import type { ButtonProps } from '@nuxt/ui'

const confirmPasswordModal = tv({
  slots: {
    base: '',
    input: 'w-full',
    actions: 'mt-6 flex justify-end gap-4',
  },
})

export interface ConfirmPasswordModalProps {
  title: string
  description: string
  confirmLabel: string
  confirmColor?: ButtonProps['color']
  passwordError?: string
  loading: boolean
  class?: any
  ui?: Partial<typeof confirmPasswordModal.slots>
}
export interface ConfirmPasswordModalEmits {
  confirm: [string]
  close: [void]
}
export interface ConfirmPasswordModalSlots {}
</script>

<script lang="ts" setup>
const props = withDefaults(defineProps<ConfirmPasswordModalProps>(), {
  confirmColor: 'error',
})
const emit = defineEmits<ConfirmPasswordModalEmits>()
defineSlots<ConfirmPasswordModalSlots>()

const password = ref('')
function onConfirm() {
  emit('confirm', password.value)
}

function onCancel() {
  emit('close')
}

const passwordInput = useTemplateRef('passwordInput')
function focus() {
  passwordInput.value?.inputRef?.focus()
}
watch([() => props.passwordError, () => props.loading], ([error, loading]) => {
  if (error && !loading) {
    focus()
  }
})

const ui = computed(() => confirmPasswordModal())
</script>

<template>
  <UModal
    :title="props.title"
    :description="props.description"
    :class="ui.base({ class: [props.ui?.base, props.class] })"
  >
    <template #body>
      <form id="confirm-password" @submit.prevent="onConfirm">
        <UFormField
          label="Password"
          required
          :error="props.passwordError"
        >
          <UInput
            ref="passwordInput"
            v-model="password"
            type="password"
            name="password"
            placeholder="Enter your password"
            autofocus
            :class="ui.input({ class: props.ui?.input })"
          />
        </UFormField>
      </form>

      <div :class="ui.actions({ class: props.ui?.actions })">
        <UButton label="Cancel" type="button" color="neutral" variant="ghost" @click="onCancel" />

        <UButton :label="confirmLabel" type="submit" :loading="props.loading" :color="props.confirmColor" form="confirm-password" />
      </div>
    </template>
  </UModal>
</template>
