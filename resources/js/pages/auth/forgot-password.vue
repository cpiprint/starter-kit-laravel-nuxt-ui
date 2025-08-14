<script lang="ts" setup>
import type { FormSubmitEvent } from '@nuxt/ui'
import { email } from '@/routes/password'

const props = defineProps<{
  flash: {
    status?: string
  }
}>()

const title = 'Forgot Password'

const form = useForm({
  email: '',
})

const fields = computed(() => [{
  name: 'email',
  label: 'Email Address',
  type: 'text' as const,
  placeholder: 'Enter your email address',
  required: true,
  error: form.errors.email,
}])

const toast = useToast()
function onSubmit({ data }: FormSubmitEvent<typeof form>) {
  form.email = data.email

  form.submit(email(), {
    onFinish: () => {
      if (!props.flash.status) {
        return
      }

      toast.add({
        title: props.flash.status,
        color: 'success',
        close: false,
        duration: 0,
      })
    },
  })
}
</script>

<template>
  <Auth :title="title">
    <UAuthForm
      :fields="fields"
      :title="title"
      :submit="{ label: 'Send Reset Link' }"
      icon="i-lucide-mail"
      :loading="form.processing"
      @submit="onSubmit"
    />
  </Auth>
</template>
