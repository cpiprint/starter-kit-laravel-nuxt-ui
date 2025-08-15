<script lang="ts" setup>
import type { NavigationMenuItem } from '@nuxt/ui'
import { useStorage } from '@vueuse/core'
import { computed, ref } from 'vue'
import { dashboard } from '@/routes'
import profile from '@/routes/profile'

const props = defineProps<{
  title: string
}>()

const page = usePage()

const links = [[{
  label: 'Home',
  icon: 'i-lucide-house',
  to: dashboard().url,
  active: page.component === 'dashboard',
}, {
  label: 'Profile',
  icon: 'i-lucide-user',
  to: profile.show().url,
  active: page.component === 'user/profile/index',
}], [{
  label: 'Feedback',
  icon: 'i-lucide-message-circle',
  to: 'https://github.com/barbapapazes/starter-kit-laravel-nuxt-ui',
  target: '_blank',
}]] satisfies NavigationMenuItem[][]

const groups = computed(() => [{
  id: 'links',
  label: 'Go to',
  items: links.flat(),
}, {
  id: 'code',
  label: 'Code',
  items: [{
    id: 'source',
    label: 'View page source',
    icon: 'simple-icons:github',
    to: `https://github.com/barbapapazes/starter-kit-laravel-nuxt-ui`,
    target: '_blank',
  }],
}])

const toast = useToast()
const cookie = useStorage('cookie-consent', 'pending')
if (cookie.value !== 'accepted') {
  toast.add({
    title: 'We use first-party cookies to enhance your experience on our website.',
    duration: 0,
    close: false,
    actions: [{
      label: 'Accept',
      color: 'neutral',
      variant: 'outline',
      onClick: () => {
        cookie.value = 'accepted'
      },
    }, {
      label: 'Opt out',
      color: 'neutral',
      variant: 'ghost',
      onClick: () => {
        cookie.value = 'rejected'
      },
    }],
  })
}
</script>

<template>
  <Head :title="props.title" />

  <Suspense>
    <App>
      <UDashboardGroup unit="rem" storage="local">
        <UDashboardSidebar
          id="default"
          collapsible
          resizable
          class="bg-elevated/25"
          :ui="{ footer: 'lg:border-t lg:border-default' }"
        >
          <template #default="{ collapsed }">
            <UDashboardSearchButton :collapsed="collapsed" class="bg-transparent ring-default" />

            <UNavigationMenu
              :collapsed="collapsed"
              :items="links[0]"
              orientation="vertical"
              tooltip
              popover
            />

            <UNavigationMenu
              :collapsed="collapsed"
              :items="links[1]"
              orientation="vertical"
              tooltip
              class="mt-auto"
            />
          </template>

          <template #footer="{ collapsed }">
            <UserMenu :collapsed="collapsed" />
          </template>
        </UDashboardSidebar>

        <UDashboardSearch :groups="groups" />

        <slot />
      </UDashboardGroup>
    </App>
  </Suspense>
</template>
