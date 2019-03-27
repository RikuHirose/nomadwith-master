import Container from './components/Container.vue'

import Top from './components/Top.vue'
import Profile from './components/profiles/profile.vue'
// import Factory from './components/factory/Factory.vue'

export const routes = [
  {
    path: '/',

    component: Container,

    meta: {
      requiresAuth: true
    },

    children: [
      {
        path: '/',
        component: Top
      },
      {
        path: 'profiles/:id',
        component: Profile
      },
      // {
      //   path: 'factories/:id',
      //   component: Factory
      // }
    ]
  }
]