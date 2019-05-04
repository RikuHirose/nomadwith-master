import Container from './components/Container.vue'

import Top from './components/Top.vue'
import Profile from './components/profiles/profile.vue'
import Contact from './components/profiles/contact/contact.vue'
import Mypage from './components/mypage/show.vue'

import Chat from './components/chat/index.vue'
import ChatMessages from './components/chat/chatMessages.vue'

import Login from './components/auth/login.vue'
import Signup from './components/auth/signup.vue'



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
            path: 'contact',
            component: Contact
          },
        ]
      },
      {
        path: 'mypage',
        component: Mypage
      },
      {
        path: 'chats',
        component: Chat,
        children: [
          {
            path: ':id',
            component: Chat
          },
        ]
      },
      {
        path: 'login',
        component: Login
      },
      {
        path: 'signup',
        component: Signup
      }
    ]
  }
]