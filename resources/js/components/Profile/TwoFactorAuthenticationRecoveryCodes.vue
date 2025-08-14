<script lang="ts">
export interface TwoFactorAuthenticationRecoveryCodesProps {
  recoveryCodes: string[]
  class?: any
}
export interface TwoFactorAuthenticationRecoveryCodesEmits {}
export interface TwoFactorAuthenticationRecoveryCodesSlots {}
</script>

<script lang="ts" setup>
const props = defineProps<TwoFactorAuthenticationRecoveryCodesProps>()
defineEmits<TwoFactorAuthenticationRecoveryCodesEmits>()
defineSlots<TwoFactorAuthenticationRecoveryCodesSlots>()

const showRecoveryCodes = ref(false)

const { copy, copied } = useClipboard()
function copyRecoveryCodes() {
  copy(props.recoveryCodes!.join('\n'))
}
</script>

<template>
  <UButton
    :label="showRecoveryCodes ? 'Hide Recovery Codes' : 'Show Recovery Codes'"
    :icon="showRecoveryCodes ? 'i-lucide-eye-off' : 'i-lucide-eye'" block
    color="neutral"
    size="sm"
    variant="soft"
    @click="showRecoveryCodes = !showRecoveryCodes"
  />

  <ul v-if="showRecoveryCodes" class="list-disc pl-5 text-sm grid md:grid-cols-2">
    <li v-for="(code, index) in props.recoveryCodes" :key="index">
      {{ code }}
    </li>
  </ul>

  <UButton
    label="Copy Recovery Codes"
    :icon="copied ? 'i-lucide-copy-check' : 'i-lucide-copy'" block
    color="neutral"
    size="sm"
    variant="soft"
    @click="copyRecoveryCodes"
  />
</template>
