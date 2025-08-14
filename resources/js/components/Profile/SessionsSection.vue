<script lang="ts">
const sessionsSection = tv({
  slots: {
    base: '',
  },
})

export interface SessionsSectionProps {
  class?: any
  ui?: Partial<typeof sessionsSection.slots>
}
export interface SessionsSectionEmits {}
export interface SessionsSectionSlots {}
</script>

<script lang="ts" setup>
const props = defineProps<SessionsSectionProps>()
defineEmits<SessionsSectionEmits>()
defineSlots<SessionsSectionSlots>()

const ui = computed(() => sessionsSection())
</script>

<template>
  sessions section
</template>
