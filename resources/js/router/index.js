import { createRouter, createWebHistory } from 'vue-router';

const routes = [
  {
    path: '/',
    name: 'home',
    component: () => import('@/pages/PageHome.vue')
  },
  {
    path: '/story/:id',
    name: 'story',
    component: () => import('@/pages/PageStory.vue')
  },
  {
    path: '/chapter/:id',
    name: 'chapter',
    component: () => import('@/pages/PageChapter.vue')
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;