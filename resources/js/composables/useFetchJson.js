import { ref } from 'vue';

export function useFetchJson({ url, method = 'GET', body = null, immediate = false }) {
  const data = ref(null);
  const error = ref(null);
  const loading = ref(false);

  const execute = async (overrideBody = null) => {
    loading.value = true;
    error.value = null;
    
    try {
      const options = {
        method,
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
        },
        credentials: 'include', // Important pour les cookies d'authentification
      };

      if (body || overrideBody) {
        options.body = JSON.stringify(overrideBody || body);
      }

      const response = await fetch(`/api/${url}`, options);
      const json = await response.json();
      
      if (!response.ok) {
        throw new Error(json.message || 'Une erreur est survenue');
      }
      
      data.value = json;
      return json;
    } catch (e) {
      error.value = e.message;
      throw e;
    } finally {
      loading.value = false;
    }
  };

  if (immediate) {
    execute();
  }

  return { data, error, loading, execute };
}