<script lang="ts">
import type { PageProps } from '@inertiajs/core'
import type { User } from '@/types/user'
import currentUserPhoto from '@/routes/current-user-photo'
import userProfileInformation from '@/routes/user-profile-information'
import { send } from '@/routes/verification'

const userProfileInformationSection = tv({
  slots: {
    base: '',
    form: 'flex flex-col gap-y-4',
    field: 'flex max-sm:flex-col justify-between items-start gap-4',
  },
})

export interface UserProfileInformationSectionProps {
  delay?: number
  class?: any
  ui?: Partial<typeof userProfileInformationSection.slots>
}
export interface UserProfileInformationSectionEmits {}
export interface UserProfileInformationSectionSlots {}
</script>

<script lang="ts" setup>
const props = defineProps<UserProfileInformationSectionProps>()
defineEmits<UserProfileInformationSectionEmits>()
defineSlots<UserProfileInformationSectionSlots>()

interface Page extends PageProps {
  auth: {
    user: User
  }
}
const page = usePage<Page>()

const form = useForm({
  _method: userProfileInformation.update().method,
  name: page.props.auth.user.name,
  email: page.props.auth.user.email,
  photo: null,
})
function onSubmit() {
  form.post(userProfileInformation.update().url, {
    errorBag: 'updateProfileInformation',
    onSuccess: () => form.reset('photo'),
  })
}

const profilePictureForm = useForm({})
function onRemoveProfilePicture() {
  profilePictureForm.submit(currentUserPhoto.destroy())
}

const toast = useToast()
const sendVerificationEmailForm = useForm({})
function onSendVerificationEmail() {
  sendVerificationEmailForm.submit(send(), {
    onSuccess: () => {
      toast.add({
        color: 'info',
        icon: 'i-lucide-mail',
        title: 'Verification email sent',
      })
    },
  })
}

const ui = computed(() => userProfileInformationSection())
</script>

<template>
  <ProfileSection
    title="Profile Information"
    description="These informations will be displayed publicly."
    :delay="props.delay"
    :class="ui.base({ class: [props.ui?.base, props.class] })"
    :ui="{ actions: 'flex-row-reverse lg:flex-row' }"
  >
    <template #actions>
      <RecentlySuccessful v-if="form.recentlySuccessful">
        Saved.
      </RecentlySuccessful>

      <UButton
        label="Save changes"
        color="neutral"
        type="submit"
        form="user-profile-information"
        :loading="form.processing"
      />
    </template>

    <form
      id="user-profile-information"
      :class="ui.form({ class: props.ui?.form })"
      @submit.prevent="onSubmit"
    >
      <UFormField
        label="Profile Photo"
        description="JPG or PNG. Max 1MB."
        :error="form.errors.photo"
        :class="ui.field({ class: props.ui?.field })"
      >
        <div v-if="page.props.auth.user.profile_photo_url" class="relative">
          <UAvatar :src="page.props.auth.user.profile_photo_url" class="size-24" />
          <UTooltip text="Remove profile photo">
            <UButton
              icon="i-lucide-trash"
              color="neutral"
              variant="solid"
              :loading="profilePictureForm.processing"
              size="xs"
              class="absolute -top-1.5 -end-1.5 p-0.5 rounded-full"
              @click="onRemoveProfilePicture"
            />
          </UTooltip>
        </div>

        <UFileUpload
          v-else
          v-model="form.photo"
          accept="image/jpg,image/jpeg,image/png"
          class="size-24"
          :ui="{ base: 'rounded-full', fileLeadingAvatar: 'rounded-full', fileTrailingButton: 'border-0 p-0.5' }"
        />
      </UFormField>

      <UFormField
        label="Name"
        description="Will appear on receipts, invoices, and other communication."
        required
        :error="form.errors.name"
        :class="ui.field({ class: props.ui?.field })"
        :ui="{ container: 'flex flex-col items-end' }"
      >
        <UInput
          v-model="form.name"
          name="name"
          autocomplete="off"
        />
      </UFormField>
      <UFormField
        label="Email"
        description="Used to sign in, for email receipts and product updates."
        required
        :error="form.errors.email"
        :class="ui.field({ class: props.ui?.field })"
        :ui="{ container: 'flex flex-col items-end' }"
      >
        <UInput
          v-model="form.email"
          name="email"
          type="email"
          autocomplete="off"
        />
      </UFormField>

      <UAlert
        v-if="!page.props.auth.user.email_verified_at"
        title="Email not verified"
        description="Please verify your email address to unlock all features."
        color="warning"
        variant="subtle"
        orientation="horizontal"
        :actions="[
          {
            label: 'Resend verification email',
            color: 'warning',
            variant: 'solid',
            loading: sendVerificationEmailForm.processing,
            onClick: () => onSendVerificationEmail(),
          },
        ]"
      />
    </form>
  </ProfileSection>
</template>
