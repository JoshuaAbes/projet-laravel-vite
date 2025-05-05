<template>
  <nav>
    <!-- Navigation standard -->
    <div v-if="isAuthenticated">
      <!-- Menu pour utilisateurs connectés -->
      <button @click="logout">Se déconnecter</button>
      <router-link to="/profile">Mon profil</router-link>
    </div>
    <div v-else>
      <!-- Menu pour visiteurs -->
      <router-link to="/login">Se connecter</router-link>
      <router-link to="/register">S'inscrire</router-link>
    </div>
  </nav>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useFetchJson } from '@/composables/useFetchJson';

const isAuthenticated = ref(false);

// Vérifier si l'utilisateur est authentifié
onMounted(async () => {
  try {
    const response = await fetch('/api/user');
    if (response.ok) {
      isAuthenticated.value = true;
    }
  } catch (error) {
    console.error('Erreur lors de la vérification de l\'authentification:', error);
  }
});

// Fonction de déconnexion
const logout = async () => {
  try {
    await fetch('/logout', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
    });
    window.location.href = '/';
  } catch (error) {
    console.error('Erreur lors de la déconnexion:', error);
  }
};
</script>