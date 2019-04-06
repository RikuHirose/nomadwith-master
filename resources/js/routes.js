import Container from './components/Container.vue'

import Top from './components/Top.vue'
import Profile from './components/profiles/profile.vue'
import Contact from './components/profiles/contact/contact.vue'

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
        component: Profile,
        children: [
          {
            path: '/contact',
            component: Contact
          },
        ]
      },
      // {
      //   path: 'factories/:id',
      //   component: Factory
      // }
    ]
  }
]