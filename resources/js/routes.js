import Container from './components/Container.vue'

import Top from './components/Top.vue'
// import Machine from './components/factory/Machine.vue'
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
      // {
      //   path: 'machines/:id',
      //   component: Machine
      // },
      // {
      //   path: 'factories/:id',
      //   component: Factory
      // }
    ]
  }
]