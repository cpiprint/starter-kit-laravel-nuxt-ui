<script lang="ts" setup>

</script>

<template>
  <Dashboard title="Profile">
    <UDashboardPanel id="Profile" :ui="{ body: 'lg:py-12' }">
      <template #header>
        <UDashboardNavbar title="Profile">
          <template #leading>
            <UDashboardSidebarCollapse />
          </template>
        </UDashboardNavbar>
      </template>

      <template #body>
        <div class="flex flex-col gap-4 sm:gap-6 lg:gap-12 w-full lg:max-w-2xl mx-auto">
          <UserProfileInformationSection />

          <PasswordSection />

          <TwoFactorAuthenticationSection />

          <SessionsSection />

          <DeleteCurrentUserSection />
        </div>
      </template>
    </UDashboardPanel>
  </Dashboard>
</template>
