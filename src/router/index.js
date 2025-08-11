// src/router/index.js
import { createRouter, createWebHistory } from 'vue-router';
import Dashboard from '../components/Dashboard.vue';
import CreatePost from '../components/CreatePost.vue';

const routes = [
  { path: '/', name: 'Dashboard', component: Dashboard },
  { path: '/create', name: 'CreatePost', component: CreatePost },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
