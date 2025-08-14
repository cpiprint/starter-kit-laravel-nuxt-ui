<script lang="ts">
import type { PageProps } from '@inertiajs/core'
import type { User } from '@/types/user'
import RecoveryCodeController from '@/actions/Laravel/Fortify/Http/Controllers/RecoveryCodeController'
import ConfirmDisableTwoFactorAuthenticationModal from '@/components/Profile/ConfirmDisableTwoFactorAuthenticationModal.vue'
import ConfirmEnableTwoFactorAuthenticationModal from '@/components/Profile/ConfirmEnableTwoFactorAuthenticationModal.vue'
import ConfirmRegenerateRecoveryCodesModal from '@/components/Profile/ConfirmRegenerateRecoveryCodesModal.vue'
import twoFactor from '@/routes/two-factor'

const twoFactorAuthenticationSection = tv({
  slots: {
    base: '',
    qrCode: 'size-40 p-1 bg-white rounded-sm',
  },
})

export interface TwoFactorAuthenticationSectionProps {
  class?: any
  ui?: Partial<typeof twoFactorAuthenticationSection.slots>
}
export interface TwoFactorAuthenticationSectionEmits {}
export interface TwoFactorAuthenticationSectionSlots {}
</script>

<script lang="ts" setup>
const props = defineProps<TwoFactorAuthenticationSectionProps>()
defineEmits<TwoFactorAuthenticationSectionEmits>()
defineSlots<TwoFactorAuthenticationSectionSlots>()

const overlay = useOverlay()

interface Page extends PageProps {
  flash: {
    status?: string
  }
  auth: {
    user: User
  }
  two_factor_qr_code?: string
  recovery_codes?: string[]
}
const page = usePage<Page>()

const isEnabling = ref(false)
const enabled = computed(() => page.props.auth.user.two_factor_enabled)

const enableForm = useForm({})
function onEnable() {
  overlay
    .create(ConfirmEnableTwoFactorAuthenticationModal, {
      props: {
        onConfirm: () => {
          enableForm.submit(twoFactor.enable(), {
            only: ['auth', 'two_factor_qr_code'],
            onSuccess: () => {
              isEnabling.value = true
            },
          })
        },
      },
      destroyOnClose: true,
    })
    .open()
}

const disableForm = useForm({})
function onDisable() {
  overlay
    .create(ConfirmDisableTwoFactorAuthenticationModal, {
      props: {
        onConfirm: () => {
          disableForm.submit(twoFactor.disable(), {
            onSuccess: () => {
              isEnabling.value = false
              isConfirming.value = false
            },
          })
        },
      },
      destroyOnClose: true,
    })
    .open()
}

const isConfirming = ref(false)
const confirmed = computed(() => page.props.auth.user.two_factor_confirmed)

const confirmForm = useForm({
  code: '',
})
function onConfirm() {
  confirmForm.submit(twoFactor.confirm(), {
    only: ['auth', 'recovery_codes'],
    errorBag: 'confirmTwoFactorAuthentication',
    onSuccess: () => {
      confirmForm.reset()
      isEnabling.value = false
      isConfirming.value = true
    },
  })
}

const isActive = computed(() => isEnabling.value || isConfirming.value)

const regenerateForm = useForm({})
function onRegenerateRecoveryCodes() {
  overlay
    .create(ConfirmRegenerateRecoveryCodesModal, {
      props: {
        onConfirm: () => {
          // Cannot use the route, must use the action.
          // @see https://github.com/laravel/fortify/pull/602
          regenerateForm.submit(RecoveryCodeController.store(), {
            only: ['recovery_codes'],
            onSuccess: () => {
              isEnabling.value = false
              isConfirming.value = false
            },
          })
        },
      },
      destroyOnClose: true,
    })
    .open()
}

const ui = computed(() => twoFactorAuthenticationSection())
</script>

<template>
  <ProfileSection
    title="Two Factor Authentication"
    description="Add additional security to your account using two factor authentication."
    :class="ui.base({ class: [props.ui?.base, props.class] })"
    :ui="{ actions: 'flex-row-reverse lg:flex-row' }"
  >
    <template #actions>
      <template v-if="!enabled">
        <RecentlySuccessful v-if="enableForm.recentlySuccessful">
          Enabled.
        </RecentlySuccessful>

        <UButton
          label="Enable"
          color="neutral"
          :loading="enableForm.processing"
          @click="onEnable"
        />
      </template>

      <template v-else-if="!confirmed && !isActive">
        <RecentlySuccessful v-if="enableForm.recentlySuccessful">
          Re-enabled.
        </RecentlySuccessful>

        <UButton
          label="Re-enable"
          color="neutral"
          :loading="enableForm.processing"
          @click="onEnable"
        />
      </template>

      <template v-if="enabled">
        <RecentlySuccessful v-if="disableForm.recentlySuccessful">
          Disabled.
        </RecentlySuccessful>

        <UButton
          label="Disable"
          color="error"
          :loading="disableForm.processing"
          @click="onDisable"
        />
      </template>

      <template v-if="isEnabling">
        <RecentlySuccessful v-if="confirmForm.recentlySuccessful">
          Confirmed.
        </RecentlySuccessful>

        <UButton
          label="Confirm"
          color="neutral"
          type="submit" form="two-factor-authentication-confirm"
          :loading="confirmForm.processing"
        />
      </template>
    </template>

    <UAlert v-if="!enabled" color="warning" variant="subtle" title="You have not enabled two factor authentication." />
    <UAlert v-else-if="!confirmed && !isActive" color="info" variant="subtle" title="Two factor authentication enabled but not confirmed. Please re-enable to continue." />

    <template v-if="isEnabling">
      <UAlert color="info" variant="subtle" title="Finish isEnabling two factor authentication." />

      <p>
        To finish isEnabling two factor authentication, scan the following QR code using your phone's authenticator application or enter the setup key and provide the generated OTP code.
      </p>

      <div :class="ui.qrCode({ class: props.ui?.qrCode })">
        <div class="h-full w-full qr-code" v-html="page.props.two_factor_qr_code" />
      </div>

      <form id="two-factor-authentication-confirm" @submit.prevent="onConfirm">
        <UFormField required label="Authentication Code">
          <UInput
            v-model="confirmForm.code"
            type="text"
            inputmode="numeric"
            autofocus
            autocomplete="one-time-code"
          />
        </UFormField>
      </form>
    </template>

    <template v-else-if="enabled && isConfirming">
      <p>
        Two factor authentication has been successfully enabled. You may now use the following recovery codes to regain access to your account in case you lose access to your two factor authentication device.
      </p>

      <TwoFactorAuthenticationRecoveryCodes :recovery-codes="page.props.recovery_codes!" />
    </template>

    <template v-else-if="confirmed">
      <UButton
        v-if="!page.props.recovery_codes"
        label="Regenerate Recovery Codes"
        icon="i-lucide-refresh-cw"
        block
        color="neutral"
        size="sm"
        variant="soft"
        :loading="regenerateForm.processing"
        @click="onRegenerateRecoveryCodes"
      />

      <TwoFactorAuthenticationRecoveryCodes
        v-if="page.props.recovery_codes"
        :recovery-codes="page.props.recovery_codes"
      />
    </template>
  </ProfileSection>
</template>

<style scoped>
:deep(.qr-code > svg) {
  width: 100%;
  height: 100%;
}
</style>
