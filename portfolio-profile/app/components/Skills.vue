<template>
  <section class="skills section" id="skills">
    <h2 class="section-title">Skills</h2>

    <div class="skills__container bd-grid">
      <div>
        <h2 class="skills__subtitle">Profesional Skills</h2>

        <Skillitem
            v-for="skill in skills"
            :key="skill.name"
            :icon="skill.icon"
            :name="skill.name"
            :percentage="skill.percentage"
            :class-name="skill.className"
        />
      </div>

      <div>
        <img src="/images/work3.jpg" alt="Skills" class="skills__img">
      </div>
    </div>
  </section>
</template>

<script setup>
const skills = [
  { icon: 'bx bxl-html5', name: 'HTML5', percentage: '95%', className: 'skills__html' },
  { icon: 'bx bxl-css3', name: 'CSS3', percentage: '85%', className: 'skills__css' },
  { icon: 'bx bxl-javascript', name: 'JAVASCRIPT', percentage: '65%', className: 'skills__js' },
  { icon: 'bx bxs-paint', name: 'UX/UI', percentage: '85%', className: 'skills__ux' }
]
</script>