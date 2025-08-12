<script lang="ts" setup>
import type { FormSubmitEvent } from '@nuxt/ui'
import { store } from '@/routes/password/confirm'

const form = useForm({
  password: '',
})

const fields = computed(() => [{
  name: 'password',
  label: 'Password',
  type: 'password' as const,
  placeholder: 'Enter your password',
  error: form.errors.password,
}])

function onSubmit({ data }: FormSubmitEvent<typeof form>) {
  form.password = data.password

  form.submit(store())
}
</script>

<template>
  <Auth title="Confirm Password">
    <UAuthForm
      :fields="fields"
      :submit="{ label: 'Confirm Password' }"
      title="Confirm Password"
      :loading="form.processing"
      icon="i-lucide-lock"
      @submit="onSubmit"
    />
  </Auth>
</template>
