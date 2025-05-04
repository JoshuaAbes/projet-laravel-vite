<script setup>
  import { ref } from 'vue';
  import TheHeader from '@/components/TheHeader.vue';
</script>

<template>
  <div class="app-container">
    <TheHeader />
    <main>
      <router-view />
    </main>
  </div>
</template>

<style scoped>
.app-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
  font-family: 'Arial', sans-serif;
}
</style>