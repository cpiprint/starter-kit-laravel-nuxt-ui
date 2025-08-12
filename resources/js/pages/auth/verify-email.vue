<script lang="ts" setup>
import { send } from '@/routes/verification'

const form = useForm({})
function onClick() {
  form.submit(send())
}
</script>

<template>
  <Auth title="Verify your email">
    <p>
      A verification email has been sent to your address. Please check your inbox and click on the verification link.
    </p>
    <p>
      Didn't receive the email? No problem, you can resend it by clicking the button below.
    </p>

    <UButton
      block
      :loading="form.processing"
      label="Resend verification email"
      type="button"
      color="neutral"
      variant="subtle"
      @click="onClick()"
    />
  </Auth>
</template>
