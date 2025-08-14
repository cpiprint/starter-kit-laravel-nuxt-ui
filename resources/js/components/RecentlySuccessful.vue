<script lang="ts">
const recentlySuccessful = tv({
  slots: {
    base: 'text-sm text-muted',
  },
})

export interface RecentlySuccessfulProps {
  class?: any
  ui?: Partial<typeof recentlySuccessful.slots>
}
export interface RecentlySuccessfulEmits {}
export interface RecentlySuccessfulSlots {
  default: (props?: any) => any
}
</script>

<script lang="ts" setup>
const props = defineProps<RecentlySuccessfulProps>()
defineEmits<RecentlySuccessfulEmits>()
defineSlots<RecentlySuccessfulSlots>()

const ui = computed(() => recentlySuccessful())
</script>

<template>
  <span :class="ui.base({ class: [props.ui?.base, props.class] })">
    <slot />
  </span>
</template>
