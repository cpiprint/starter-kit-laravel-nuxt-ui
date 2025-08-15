<script lang="ts">
import { Motion } from 'motion-v'

const profileSection = tv({
  slots: {
    base: 'flex flex-col gap-6',
    actions: 'w-fit lg:ms-auto flex flex-row gap-2 items-center',
  },
})

export interface ProfileSectionProps {
  delay?: number
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
const props = withDefaults(defineProps<ProfileSectionProps>(), {
  delay: 0,
})
defineEmits<ProfileSectionEmits>()
const slots = defineSlots<ProfileSectionSlots>()

const ui = computed(() => profileSection())
</script>

<template>
  <div :class="ui.base({ class: [props.ui?.base, props.class] })">
    <UPageCard
      variant="naked"
      orientation="horizontal"
    >
      <template #title>
        <Motion
          :initial="{ opacity: 0, transform: 'translateY(10px)' }"
          :animate="{ opacity: 1, transform: 'translateY(0)', transition: { duration: 0.3, delay: props.delay } }"
        >
          {{ props.title }}
        </Motion>
      </template>

      <template #description>
        <Motion
          :initial="{ opacity: 0, transform: 'translateY(10px)' }"
          :animate="{ opacity: 1, transform: 'translateY(0)', transition: { duration: 0.2, delay: 0.1 + props.delay } }"
        >
          {{ props.description }}
        </Motion>
      </template>

      <Motion
        :initial="{ opacity: 0, scale: 0.96 }"
        :animate="{ opacity: 1, scale: 1, transition: { duration: 0.2, delay: 0.1 + props.delay } }"
      >
        <div :class="ui.actions({ class: props.ui?.actions })">
          <slot name="actions" />
        </div>
      </Motion>
    </UPageCard>

    <Motion
      :initial="{ opacity: 0, transform: 'translateY(10px)' }"
      :animate="{ opacity: 1, transform: 'translateY(0)', transition: { duration: 0.2, delay: 0.25 + props.delay } }"
    >
      <UPageCard v-if="!!slots.default" variant="subtle">
        <slot />
      </UPageCard>
    </Motion>
  </div>
</template>
