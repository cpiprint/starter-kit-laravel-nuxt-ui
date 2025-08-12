<script setup lang="ts">
const props = defineProps<{
  title: string
}>()
</script>

<template>
  <Head :title="props.title" />

  <div>
    <AppHeader />

    <UMain>
      <slot />
    </UMain>

    <AppFooter />
  </div>
</template>
