import {createRouter,createWebHistory} from 'vue-router'
import Home from '../views/Home.vue'



const router = createRouter({
  history:createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: Home
    },
    {
      path:'/info',
      name:'info',
      component: import('../components/Info.vue'),
    },
    {
      path:'/books/add',
      name:'addbook',
      component: import('../views/AddBook.vue'),
    },
    {
      path:'/books/:id',
      name:'bookurl',
      component: import('../views/Book.vue'),
    }
  ]
})

export default router;