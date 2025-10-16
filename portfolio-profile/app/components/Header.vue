<template>
  <header class="l-header">
    <nav class="nav bd-grid">
      <div>
        <a href="#" class="nav__logo">Anang</a>
      </div>

      <div :class="['nav__menu', { 'show': isMenuOpen }]" id="nav-menu">
        <ul class="nav__list">
          <li class="nav__item">
            <a href="#home" class="nav__link" @click="closeMenu">Home</a>
          </li>
          <li class="nav__item">
            <a href="#about" class="nav__link" @click="closeMenu">About</a>
          </li>
          <li class="nav__item">
            <a href="#skills" class="nav__link" @click="closeMenu">Skills</a>
          </li>
          <li class="nav__item">
            <a href="#work" class="nav__link" @click="closeMenu">Experience</a>
          </li>
          <li class="nav__item">
            <a href="#contact" class="nav__link" @click="closeMenu">Contact</a>
          </li>
        </ul>
      </div>

      <div class="nav__toggle" id="nav-toggle" @click="toggleMenu">
        <i class='bx bx-menu'></i>
      </div>
    </nav>
  </header>
</template>

<script setup>
const isMenuOpen = ref(false)

const toggleMenu = () => {
  isMenuOpen.value = !isMenuOpen.value
}

const closeMenu = () => {
  isMenuOpen.value = false
}
</script>