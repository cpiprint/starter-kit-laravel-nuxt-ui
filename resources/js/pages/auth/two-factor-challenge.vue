<script lang="ts" setup>
import type { FormSubmitEvent } from '@nuxt/ui'
import { store } from '@/routes/two-factor/login'

const title = 'Two Factor Challenge'

const form = useForm({
  code: '',
})

const fields = computed(() => [{
  name: 'code',
  label: 'Verification Code',
  type: 'text' as const,
  placeholder: 'Enter your verification code',
  required: true,
  error: form.errors.code,
}])

function onSubmit({ data }: FormSubmitEvent<typeof form>) {
  form.code = data.code

  form.submit(store())
}
</script>

<template>
  <Auth :title="title">
    <UAuthForm
      :fields="fields"
      :title="title"
      :submit="{ label: 'Continue' }"
      icon="i-lucide-tablet-smartphone"
      :loading="form.processing"
      @submit="onSubmit"
    />
  </Auth>
</template>
