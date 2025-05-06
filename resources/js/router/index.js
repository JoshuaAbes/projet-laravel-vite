import { createRouter, createWebHistory } from 'vue-router';
import PageHome from '@/pages/PageHome.vue';
import PageStory from '@/pages/PageStory.vue';
import PageChapter from '@/pages/PageChapter.vue';

const routes = [
  {
    path: '/',
    name: 'home',
    component: PageHome
  },
  {
    path: '/story/:id',
    name: 'story',
    component: PageStory
  },
  {
    path: '/chapter/:id',
    name: 'chapter',
    component: PageChapter
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;