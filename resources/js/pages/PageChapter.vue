<script setup>
import { ref, onMounted, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useFetchJson } from '@/composables/useFetchJson';

const route = useRoute();
const router = useRouter();
const chapterId = ref(route.params.id);

// Récupérer les détails du chapitre
const { data: chapterData, error, loading, execute: fetchChapter } = useFetchJson({
  url: `/v1/chapters/${chapterId.value}`,
  immediate: true
});

// État pour stocker la progression
const savedProgress = ref(false);
const progressError = ref(null);

// Fonction pour faire un choix et naviguer vers le chapitre suivant
const makeChoice = async (choiceId, nextChapterId) => {
  // Si c'est un chapitre de fin, retourner à l'accueil
  if (chapterData.value.data.is_ending) {
    router.push('/');
    return;
  }

  // Sauvegarde de la progression si l'utilisateur est connecté
  try {
    const { execute: saveProgress } = useFetchJson({
      url: 'v1/progress',
      method: 'POST',
      body: {
        story_id: chapterData.value.data.story_id,
        current_chapter_id: nextChapterId
      }
    });
    
    await saveProgress();
    savedProgress.value = true;
    
    // Naviguer vers le prochain chapitre
    router.push(`/chapter/${nextChapterId}`);
  } catch (err) {
    // Si l'utilisateur n'est pas connecté ou autre erreur, continuer sans sauvegarder
    progressError.value = err.message;
    router.push(`/chapter/${nextChapterId}`);
  }
};

// Réinitialiser les états quand le paramètre d'URL change
watch(() => route.params.id, (newId) => {
  if (newId !== chapterId.value) {
    chapterId.value = newId;
    savedProgress.value = false;
    progressError.value = null;
    fetchChapter();
  }
});
</script>

<template>
  <div class="chapter-page">
    <div v-if="loading" class="loading">
      Chargement du chapitre...
    </div>
    
    <div v-else-if="error" class="error">
      <p>Impossible de charger le chapitre</p>
      <p>{{ error }}</p>
      <button @click="fetchChapter" class="retry-btn">Réessayer</button>
      <router-link to="/" class="home-btn">Retour à l'accueil</router-link>
    </div>
    
    <div v-else-if="chapterData && chapterData.data" class="chapter-content">
      <h1>{{ chapterData.data.title }}</h1>
      
      <div class="chapter-text">
        <!-- Division du contenu en paragraphes -->
        <p v-for="(paragraph, index) in chapterData.data.content.split('\n')" 
           :key="index" 
           v-html="paragraph"></p>
      </div>
      
      <!-- Affichage des choix si le chapitre n'est pas une fin -->
      <div v-if="!chapterData.data.is_ending && chapterData.data.choices && chapterData.data.choices.length > 0" 
           class="choices-container">
        <h3>Que souhaitez-vous faire ?</h3>
        <div class="choices-list">
          <button v-for="choice in chapterData.data.choices" 
                  :key="choice.id" 
                  @click="makeChoice(choice.id, choice.next_chapter_id)"
                  class="choice-btn">
            {{ choice.text }}
          </button>
        </div>
      </div>
      
      <!-- Message pour les fins d'histoire -->
      <div v-else-if="chapterData.data.is_ending" class="ending">
        <p class="ending-message">Fin de l'histoire</p>
        <router-link to="/" class="home-btn">Retour à l'accueil</router-link>
      </div>

      <!-- Message d'erreur pour la sauvegarde de progression -->
      <div v-if="progressError" class="progress-error">
        <p>{{ progressError }}</p>
      </div>
    </div>
  </div>
</template>

<style scoped>
.chapter-page {
  max-width: 800px;
  margin: 0 auto;
  padding: 20px;
}

.chapter-content {
  background: #fff;
  border-radius: 8px;
  padding: 30px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.chapter-text {
  font-size: 18px;
  line-height: 1.8;
  margin: 20px 0 30px;
}

.choices-container {
  margin-top: 40px;
}

.choices-list {
  display: flex;
  flex-direction: column;
  gap: 15px;
  margin-top: 20px;
}

.choice-btn {
  background-color: #4a6fa5;
  color: white;
  border: none;
  padding: 15px 20px;
  border-radius: 6px;
  font-size: 16px;
  cursor: pointer;
  transition: all 0.3s ease;
  text-align: left;
}

.choice-btn:hover {
  background-color: #3a5985;
  transform: translateY(-3px);
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.ending {
  margin-top: 40px;
  text-align: center;
}

.ending-message {
  font-size: 24px;
  margin-bottom: 20px;
  color: #4a6fa5;
}

.home-btn, .retry-btn {
  display: inline-block;
  background-color: #f5f5f5;
  color: #333;
  padding: 10px 20px;
  border-radius: 4px;
  text-decoration: none;
  margin-top: 20px;
  text-align: center;
}

.loading, .error {
  text-align: center;
  margin: 40px 0;
}

.error {
  color: #e53935;
}

.progress-error {
  margin-top: 20px;
  padding: 10px;
  background-color: #fff3cd;
  color: #856404;
  border-left: 4px solid #ffeeba;
  font-size: 14px;
}

@media (max-width: 768px) {
  .chapter-page {
    padding: 10px;
  }
  
  .chapter-content {
    padding: 20px;
  }
  
  .chapter-text {
    font-size: 16px;
  }
}
</style>