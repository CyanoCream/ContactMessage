<template>
  <div class="skills__data">
    <div class="skills__names">
      <i :class="['skills__icon', icon]"></i>
      <span class="skills__name">{{ name }}</span>
    </div>
    <div :class="['skills__bar', className]"></div>
    <div>
      <span class="skills__percentage">{{ percentage }}</span>
    </div>
  </div>
</template>

<script setup>
defineProps({
  icon: String,
  name: String,
  percentage: String,
  className: String
})
</script>