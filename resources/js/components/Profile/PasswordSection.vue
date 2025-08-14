<script lang="ts">
import userPassword from '@/routes/user-password'

const passwordSection = tv({
  slots: {
    base: '',
    form: 'flex flex-col gap-y-4',
    field: 'flex max-sm:flex-col justify-between items-center gap-4',
  },
})

export interface PasswordSectionProps {
  class?: any
  ui?: Partial<typeof passwordSection.slots>
}
export interface PasswordSectionEmits {}
export interface PasswordSectionSlots {}
</script>

<script lang="ts" setup>
const props = defineProps<PasswordSectionProps>()
defineEmits<PasswordSectionEmits>()
defineSlots<PasswordSectionSlots>()

const passwordInput = useTemplateRef('passwordInput')
const currentPasswordInput = useTemplateRef('currentPasswordInput')

const form = useForm({
  current_password: '',
  password: '',
  password_confirmation: '',
})
function onSubmit() {
  form.submit(userPassword.update(), {
    errorBag: 'updatePassword',
    preserveScroll: true,
    onSuccess: () => form.reset(),
    onError: () => {
      if (form.errors.password) {
        form.reset('password', 'password_confirmation')
        passwordInput.value?.inputRef?.focus()
      }

      if (form.errors.current_password) {
        form.reset('current_password')
        currentPasswordInput.value?.inputRef?.focus()
      }
    },
  })
}

const ui = computed(() => passwordSection())
</script>

<template>
  <ProfileSection
    title="Update Password"
    description="Ensure your account is using a long, random password to stay secure."
    :class="ui.base({ class: [props.ui?.base, props.class] })"
    :ui="{ actions: 'flex-row-reverse lg:flex-row' }"
  >
    <template #actions>
      <RecentlySuccessful v-if="form.recentlySuccessful">
        Updated.
      </RecentlySuccessful>

      <UButton
        label="Update"
        color="neutral"
        type="submit"
        form="password"
        :loading="form.processing"
      />
    </template>

    <form
      id="password"
      :class="ui.form({ class: props.ui?.form })"
      @submit.prevent="onSubmit"
    >
      <UFormField
        label="Current Password"
        required
        :error="form.errors.current_password"
        :class="ui.field({ class: props.ui?.field })"
        :ui="{ container: 'flex flex-col items-end' }"
      >
        <UInput
          ref="currentPasswordInput"
          v-model="form.current_password"
          name="current_password"
          type="password"
          autocomplete="current-password"
        />
      </UFormField>

      <UFormField
        label="New Password"
        required
        :error="form.errors.password"
        :class="ui.field({ class: props.ui?.field })"
        :ui="{ container: 'flex flex-col items-end' }"
      >
        <UInput
          ref="passwordInput"

          v-model="form.password"
          name="password"
          type="password"
          autocomplete="new-password"
        />
      </UFormField>

      <UFormField
        label="Confirm New Password"
        required
        :error="form.errors.password_confirmation"
        :class="ui.field({ class: props.ui?.field })"
        :ui="{ container: 'flex flex-col items-end' }"
      >
        <UInput
          v-model="form.password_confirmation"
          name="password_confirmation"
          type="password"
          autocomplete="new-password"
        />
      </UFormField>
    </form>
  </ProfileSection>
</template>
