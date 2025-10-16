<template>
  <section class="work section" id="work">
    <h2 class="section-title">Work</h2>

    <div class="work__container bd-grid">
      <a
          v-for="(work, index) in works"
          :key="index"
          href=""
          class="work__img"
      >
        <img :src="work.image" :alt="work.alt">
      </a>
    </div>
  </section>
</template>

<script setup>
const works = [
  { image: '/images/work1.jpg', alt: 'Work 1' },
  { image: '/images/work2.jpg', alt: 'Work 2' },
  { image: '/images/work3.jpg', alt: 'Work 3' },
  { image: '/images/work4.jpg', alt: 'Work 4' },
  { image: '/images/work5.jpg', alt: 'Work 5' },
  { image: '/images/work6.jpg', alt: 'Work 6' }
]
</script>