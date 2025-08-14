<script lang="ts">
const profileSection = tv({
  slots: {
    base: 'flex flex-col gap-6',
    actions: 'w-fit lg:ms-auto flex flex-row gap-2 items-center',
  },
})

export interface ProfileSectionProps {
  title: string
  description?: string
  class?: any
  ui?: Partial<typeof profileSection.slots>
}
export interface ProfileSectionEmits {}
export interface ProfileSectionSlots {
  default: (props?: any) => any
  actions: (props?: any) => any
}
</script>

<script lang="ts" setup>
const props = defineProps<ProfileSectionProps>()
defineEmits<ProfileSectionEmits>()
const slots = defineSlots<ProfileSectionSlots>()

const ui = computed(() => profileSection())
</script>

<template>
  <div :class="ui.base({ class: [props.ui?.base, props.class] })">
    <UPageCard
      :title="props.title"
      :description="props.description"
      variant="naked"
      orientation="horizontal"
    >
      <div :class="ui.actions({ class: props.ui?.actions })">
        <slot name="actions" />
      </div>
    </UPageCard>
    <UPageCard v-if="!!slots.default" variant="subtle">
      <slot />
    </UPageCard>
  </div>
</template>
