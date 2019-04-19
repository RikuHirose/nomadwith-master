<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-4">
          <div class="card">
              <div class="card-header">Users</div>
              <div class="card-body">
                  <div class="users" v-for="user in users" :key="user.id">
                      <a href="#">{{ user.name }}</a>
                  </div>
              </div>
          </div>
      </div>
      <div class="col-md-8">
          <div class="card">
              <div class="card-header">Chats</div>
              <div class="card-body">
                  <chat-messages></chat-messages>
                  <chat-form></chat-form>
              </div>
          </div>
      </div>
    </div>
  </div>
</template>

<script>
import chatMessages from './chatMessages.vue'
import chatForm from './chatForm.vue'

export default {
  name: 'mypage',
  components: {
    'chatMessages': chatMessages,
    'chatForm': chatForm,
  },
  data (){
    return {
      profileName: '',
    }
  },

  created () {
    this.profileName = this.profile.name
  },

  methods: {

  },

  computed: {
    currentUser() {
      return this.$store.getters.currentUser
    },
    profile() {
      return this.$store.getters.currentUser.profile
    }
  },
  methods: {

  }
}
</script>