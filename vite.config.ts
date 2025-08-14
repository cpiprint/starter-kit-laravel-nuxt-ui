import { wayfinder } from '@laravel/vite-plugin-wayfinder'
import uiPro from '@nuxt/ui-pro/vite'
import vue from '@vitejs/plugin-vue'
import laravel from 'laravel-vite-plugin'
import { defineConfig } from 'vite'

export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/css/app.css', 'resources/js/app.js'],
      refresh: true,
    }),
    wayfinder(),

    vue(),

    uiPro({
      autoImport: {
        imports: [
          'vue',
          '@vueuse/core',
          {
            from: 'tailwind-variants',
            imports: ['tv'],
          },
          {
            from: '@inertiajs/vue3',
            imports: ['useForm', 'router', 'usePage'],
          },
        ],
        dirs: [
          'resources/js/composables',
        ],
      },
      components: {
        dirs: [
          'resources/js/layouts',
          'resources/js/components',
        ],
        resolvers: [
          (componentName) => {
            if (['Head', 'Link'].includes(componentName)) {
              return {
                name: componentName,
                from: '@inertiajs/vue3',
              }
            }
          },
        ],
      },
      inertia: true,
    }),
  ],
})
