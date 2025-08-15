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
          <UserProfileInformationSection :delay="0" />

          <PasswordSection :delay="0.3" />

          <TwoFactorAuthenticationSection :delay="0.6" />

          <SessionsSection :delay="0.9" />

          <DeleteCurrentUserSection :delay="1.2" />
        </div>
      </template>
    </UDashboardPanel>
  </Dashboard>
</template>
