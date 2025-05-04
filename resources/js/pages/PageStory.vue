<script setup>
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useFetchJson } from '@/composables/useFetchJson';

const route = useRoute();
const router = useRouter();
const storyId = route.params.id;

// Récupérer les détails de l'histoire
const { data: storyData, error, loading } = useFetchJson({
  url: `/v1/stories/${storyId}`,
  immediate: true
});

// Fonction pour démarrer l'histoire (aller au premier chapitre)
function startStory() {
  if (storyData.value && storyData.value.data && storyData.value.data.chapters.length > 0) {
    // On considère que le premier chapitre est le début de l'histoire
    const firstChapterId = storyData.value.data.chapters[0].id;
    router.push(`/chapter/${firstChapterId}`);
  }
}
</script>

<template>
  <div class="story-page">
    <div v-if="loading" class="loading">Chargement de l'histoire...</div>
    
    <div v-else-if="error" class="error">
      <p>Impossible de charger l'histoire</p>
      <router-link to="/" class="back-btn">
        Retour à l'accueil
      </router-link>
    </div>
    
    <div v-else-if="storyData && storyData.data" class="story-details">
      <h1>{{ storyData.data.title }}</h1>
      
      <div class="story-description">
        <p>{{ storyData.data.description }}</p>
      </div>
      
      <div class="story-actions">
        <button @click="startStory" class="start-btn">
          Commencer l'aventure
        </button>
        
        <router-link to="/" class="back-btn">
          Retour à l'accueil
        </router-link>
      </div>
    </div>
  </div>
</template>

<style scoped>
.story-page {
  padding: 20px 0;
}

.story-details {
  max-width: 800px;
  margin: 0 auto;
}

.story-description {
  margin: 20px 0;
  line-height: 1.6;
}

.story-actions {
  display: flex;
  gap: 10px;
  margin-top: 30px;
}

.start-btn {
  background-color: #4CAF50;
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 4px;
  cursor: pointer;
  font-size: 16px;
}

.back-btn {
  display: inline-block;
  background-color: #f5f5f5;
  color: #333;
  padding: 10px 20px;
  border-radius: 4px;
  text-decoration: none;
}

.loading, .error {
  text-align: center;
  margin: 40px 0;
}
</style>