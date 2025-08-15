<script setup lang="ts">
import type { PageProps } from '@inertiajs/core'
import type { DropdownMenuItem } from '@nuxt/ui'
import type { User } from '@/types/user'
import { logout } from '@/routes'
import profile from '@/routes/profile'

defineProps<{
  collapsed?: boolean
}>()

const colorMode = useColorMode()
const appConfig = useAppConfig()

interface Page extends PageProps {
  auth: {
    user: User
  }
}
const page = usePage<Page>()

const user = computed(() => ({
  name: page.props.auth.user.name,
  avatar: {
    src: page.props.auth.user.profile_photo_url,
    alt: page.props.auth.user.name,
  },
}))

const items = computed<DropdownMenuItem[][]>(() => ([[{
  type: 'label',
  label: user.value.name,
  avatar: user.value.avatar,
}], [{
  label: 'Profile',
  icon: 'i-lucide-user',
  to: profile.show().url,
  active: page.component === 'user/profile/index',
}], [{
  label: 'Appearance',
  icon: 'i-lucide-sun-moon',
  children: [{
    label: 'Light',
    icon: 'i-lucide-sun',
    type: 'checkbox',
    checked: colorMode.value === 'light',
    onSelect(e: Event) {
      e.preventDefault()

      colorMode.value = 'light'
    },
  }, {
    label: 'Dark',
    icon: 'i-lucide-moon',
    type: 'checkbox',
    checked: colorMode.value === 'dark',
    onUpdateChecked(checked: boolean) {
      if (checked) {
        colorMode.value = 'dark'
      }
    },
    onSelect(e: Event) {
      e.preventDefault()
    },
  }],
}], [{
  label: 'Documentation',
  icon: 'i-lucide-book-open',
  to: 'https://ui.nuxt.com/getting-started/installation/vue',
  target: '_blank',
}, {
  label: 'GitHub repository',
  icon: 'simple-icons:github',
  to: 'https://github.com/barbapapazes/starter-kit-laravel-nuxt-ui',
  target: '_blank',
}], [{
  label: 'Log out',
  icon: 'i-lucide-log-out',
  onSelect: () => {
    router.visit(logout().url, {
      method: logout().method,
    })
  },
}]]))
</script>

<template>
  <UDropdownMenu
    :items="items"
    :content="{ align: 'center', collisionPadding: 12 }"
    :ui="{ content: collapsed ? 'w-48' : 'w-(--reka-dropdown-menu-trigger-width)' }"
  >
    <UButton
      v-bind="{
        ...user,
        label: collapsed ? undefined : user?.name,
        trailingIcon: collapsed ? undefined : 'i-lucide-chevrons-up-down',
      }"
      color="neutral"
      variant="ghost"
      block
      :square="collapsed"
      class="data-[state=open]:bg-elevated"
      :ui="{
        trailingIcon: 'text-dimmed',
      }"
    />

    <template #chip-leading="{ item }">
      <span
        :style="{
          '--chip-light': `var(--color-${(item as any).chip}-500)`,
          '--chip-dark': `var(--color-${(item as any).chip}-400)`,
        }"
        class="ms-0.5 size-2 rounded-full bg-(--chip-light) dark:bg-(--chip-dark)"
      />
    </template>
  </UDropdownMenu>
</template>
