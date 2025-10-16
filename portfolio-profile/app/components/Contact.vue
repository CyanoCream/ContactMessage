<template>
  <section class="contact section" id="contact">
    <h2 class="section-title">Contact</h2>

    <div class="contact__container bd-grid">
      <form @submit.prevent="submitForm" class="contact__form">
        <input
            type="text"
            placeholder="Name"
            class="contact__input"
            v-model="form.name"
            :disabled="isLoading"
            required
        >
        <input
            type="email"
            placeholder="Email"
            class="contact__input"
            v-model="form.email"
            :disabled="isLoading"
            required
        >
        <input
            type="text"
            placeholder="Subject"
            class="contact__input"
            v-model="form.subject"
            :disabled="isLoading"
            required
        >
        <textarea
            cols="0"
            rows="10"
            class="contact__input"
            placeholder="Message"
            v-model="form.message"
            :disabled="isLoading"
            required
        ></textarea>

        <!-- Success Message -->
        <div v-if="successMessage" class="contact__success">
          {{ successMessage }}
        </div>

        <!-- Error Message -->
        <div v-if="errorMessage" class="contact__error">
          {{ errorMessage }}
        </div>

        <button
            type="submit"
            class="contact__button button"
            :disabled="isLoading"
        >
          <span v-if="isLoading">Sending...</span>
          <span v-else>Send</span>
        </button>
      </form>
    </div>
  </section>
</template>

<script setup>
import { reactive, ref } from 'vue'

const form = reactive({
  name: '',
  email: '',
  subject: '',
  message: ''
})

const isLoading = ref(false)
const successMessage = ref('')
const errorMessage = ref('')

const submitForm = async () => {
  isLoading.value = true
  successMessage.value = ''
  errorMessage.value = ''

  try {
    const response = await $fetch('/api/contact/send', {
      baseURL: process.env.NUXT_PUBLIC_API_BASE_URL || 'http://127.0.0.1:8000',
      method: 'POST',
      body: form,
      headers: {
        'Content-Type': 'application/json',
      },
    })

    if (response.success) {
      successMessage.value = response.message || 'Message sent successfully!'

      // Reset form
      form.name = ''
      form.email = ''
      form.subject = ''
      form.message = ''

      // Clear success message after 5 seconds
      setTimeout(() => {
        successMessage.value = ''
      }, 5000)
    }
  } catch (error) {
    console.error('Error sending message:', error)
    errorMessage.value = error.data?.message || 'Terjadi kesalahan saat mengirim pesan. Silakan coba lagi.'

    // Clear error message after 5 seconds
    setTimeout(() => {
      errorMessage.value = ''
    }, 5000)
  } finally {
    isLoading.value = false
  }
}
</script>

<style scoped>
.contact__success {
  background-color: #d4edda;
  color: #155724;
  padding: 12px;
  border-radius: 4px;
  margin-bottom: 16px;
  border: 1px solid #c3e6cb;
}

.contact__error {
  background-color: #f8d7da;
  color: #721c24;
  padding: 12px;
  border-radius: 4px;
  margin-bottom: 16px;
  border: 1px solid #f5c6cb;
}

.contact__button:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}
</style>