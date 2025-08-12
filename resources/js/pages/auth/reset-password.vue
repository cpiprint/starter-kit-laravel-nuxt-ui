<script lang="ts" setup>
import type { FormSubmitEvent } from '@nuxt/ui'
import password from '@/routes/password'

const props = defineProps<{
  token: string
  email: string
}>()

const form = useForm({
  email: props.email,
  token: props.token,
  password: '',
  password_confirmation: '',
})

const fields = computed(() => [{
  name: 'email',
  type: 'text' as const,
  label: 'Email',
  placeholder: 'Enter your email',
  required: true,
  error: form.errors.email,
}, {
  name: 'password',
  label: 'Password',
  type: 'password' as const,
  placeholder: 'Enter your password',
  error: form.errors.password,
}, {
  name: 'password_confirmation',
  label: 'Confirm Password',
  type: 'password' as const,
  placeholder: 'Confirm your password',
}])

function onSubmit({ data }: FormSubmitEvent<typeof form>) {
  form.email = data.email
  form.password = data.password
  form.password_confirmation = data.password_confirmation

  form.submit(password.update())
}
</script>

<template>
  <Auth title="Reset Password">
    <UAuthForm
      :fields="fields"
      :submit="{ label: 'Reset Password' }"
      title="Reset Password"
      :loading="form.processing"
      icon="i-lucide-lock"
      @submit="onSubmit"
    />
  </Auth>
</template>
