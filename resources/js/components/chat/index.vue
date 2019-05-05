<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-4">
          <div class="card">
            <matched-users></matched-users>
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
import matchedUsers from './matchedUsers.vue'
import chatForm from './chatForm.vue'
import chatMessages from './chatMessages.vue'

export default {
  name: 'chat-index',
  components: {
    'matchedUsers': matchedUsers,
    'chatForm': chatForm,
    'chatMessages': chatMessages
  },
  data (){
    return {
    }
  },
  created () {

  },
  // updated () {
  //   if (this.lastMessage) {
  //     this.scrollToLastMessage(`chat-message-${this.lastMessage.id}`)
  //   }
  // },
  computed: {
    currentUser() {
      return this.$store.getters.currentUser
    },
    // profile() {
    //   return this.$store.getters.currentUser.profile
    // },
    matchedUsers() {
      return this.$store.getters.matchedUsers
    },
    // messages() {
    //     return this.$store.getters.messages
    // },
    // lastMessage() {
    //   return this.$store.getters.lastMessage
    // },
  },
  methods: {

  }
}
</script>

<style lang="scss" scoped>
</style>