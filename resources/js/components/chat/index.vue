<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-4">
          <div class="card">
              <div class="card-header">Matched Users</div>
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
  name: 'chat-index',
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
    this.fetchMatchedUsers()
  },
  computed: {
    currentUser() {
      return this.$store.getters.currentUser
    },
    profile() {
      return this.$store.getters.currentUser.profile
    },
    matchedUsers() {
      return this.$store.getters.matchedUsers
    }
  },
  methods: {
    fetchMatchedUsers () {
      this.$store.dispatch('matchedUsers', {
        currentUser: this.currentUser,
      })
    }
  }
}
</script>