<script setup>
import { ref, onMounted } from 'vue';
import { useFetchJson } from '@/composables/useFetchJson';

// Récupérer toutes les histoires
const { data: stories, error, loading, execute: fetchStories } = useFetchJson({
  url: '/v1/stories',
  immediate: true
});
</script>

<template>
  <div class="home-page">
    <h1>Fictions Interactives</h1>
    
    <div v-if="loading" class="loading">Chargement des histoires...</div>
    
    <div v-else-if="error" class="error">
      <p>Impossible de charger les histoires</p>
      <button @click="fetchStories">Réessayer</button>
    </div>
    
    <div v-else-if="stories && stories.data && stories.data.length" class="stories-list">
      <div v-for="story in stories.data" :key="story.id" class="story-card">
        <h2>{{ story.title }}</h2>
        <p>{{ story.description }}</p>
        <router-link :to="`/story/${story.id}`" class="start-btn">
          Commencer l'histoire
        </router-link>
      </div>
    </div>
    
    <div v-else class="no-stories">
      <p>Aucune histoire disponible pour le moment.</p>
    </div>
  </div>
</template>

<style scoped>
.home-page {
  padding: 20px 0;
}

.stories-list {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 20px;
  margin-top: 20px;
}

.story-card {
  border: 1px solid #ddd;
  border-radius: 8px;
  padding: 16px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  transition: transform 0.2s, box-shadow 0.2s;
}

.story-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 5px 10px rgba(0,0,0,0.15);
}

.start-btn {
  display: inline-block;
  background-color: #4CAF50;
  color: white;
  padding: 10px 15px;
  border-radius: 4px;
  text-decoration: none;
  font-weight: bold;
  margin-top: 10px;
}

.loading, .error, .no-stories {
  text-align: center;
  margin: 40px 0;
}
</style>