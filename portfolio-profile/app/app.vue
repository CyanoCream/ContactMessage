<template>
  <div>
    <NuxtRouteAnnouncer />
    <Header />
    <main class="l-main">
      <NuxtPage />
    </main>
    <Footer />
  </div>
</template>

<script setup>
useHead({
  title: 'Anang Eko Fitriyanto - Software Engineer',
  link: [
    {
      rel: 'icon',
      type: 'image/svg+xml',
      href: '/favicon.svg'
    },
    {
      rel: 'stylesheet',
      href: 'https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css'
    }
  ],
  meta: [
    { name: 'description', content: 'Anang Eko Fitriyanto - Professional Software Engineer Portfolio' }
  ]
})
</script>

<style>
/* Import global styles */
@import url('~/assets/css/styles.css');
</style>