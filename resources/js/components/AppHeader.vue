<script setup lang="ts">
import { login, register } from '@/routes'
import pricing from '@/routes/pricing'

const page = usePage()

const items = computed(() => [{
  label: 'Docs',
  to: 'https://docs.example.com',
}, {
  label: 'Pricing',
  to: pricing.index().url,
  active: page.component === 'pricing/index',
}, {
  label: 'Blog',
  to: 'https://blog.example.com',
}, {
  label: 'Changelog',
  to: 'https://changelog.example.com',
  badge: {
    label: 'New',
    color: 'primary' as const,
  },
}])
</script>

<template>
  <UHeader>
    <template #left>
      <Link href="/">
        <!-- TODO: NuxtUIProxLaravel à faire via Figma -->
        <LogoPro class="w-auto h-6 shrink-0" />
      </Link>
      <TemplateMenu />
    </template>

    <UNavigationMenu
      :items="items"
      variant="link"
    />

    <template #right>
      <UColorModeButton />

      <UButton
        icon="i-lucide-log-in"
        color="neutral"
        variant="ghost"
        :to="login().url"
        class="lg:hidden"
      />

      <UButton
        label="Sign in"
        color="neutral"
        variant="outline"
        :to="login().url"
        class="hidden lg:inline-flex"
      />

      <UButton
        label="Sign up"
        color="neutral"
        trailing-icon="i-lucide-arrow-right"
        class="hidden lg:inline-flex"
        :to="register().url"
      />
    </template>

    <template #body>
      <UNavigationMenu
        :items="items"
        orientation="vertical"
        class="-mx-2.5"
      />

      <USeparator class="my-6" />

      <UButton
        label="Sign in"
        color="neutral"
        variant="subtle"
        :to="login().url"
        block
        class="mb-3"
      />
      <UButton
        label="Sign up"
        color="neutral"
        :to="register().url"
        block
      />
    </template>
  </UHeader>
</template>
