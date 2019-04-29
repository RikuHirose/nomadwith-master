<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-4">
          <div class="card">
              <div class="card-header">Matched Users</div>
              <div
                id="message-card-body"
                class="card-body">
                  <div class="users" v-for="user in matchedUsers">
                      <router-link
                        v-if="user.user.profile"
                        :to="`/chats/${user.match_id}`"
                        @click.native="fetchMessages(user.match_id)"
                        class="">{{ user.user.profile.name }}</router-link>
                        <!-- <button
                          v-if="user.user.profile"
                          @click="fetchMessages(user.match_id)"
                          type="button" class="btn btn-link">{{ user.user.profile.name }}</button> -->
                  </div>
              </div>
          </div>
      </div>
      <div class="col-md-8">
          <div class="card">
              <div class="card-header">Chats</div>
              <div class="card-body">
                  <div class="c-chat-messages__wrap">
                    <div
                      v-for="message in this.messages"
                      class="c-chat-message__box"
                      :class="{ 'self': message.selfMessage }">
                      <template
                        v-if="message.send_from == currentUser.id">
                        <p
                          v-if="message.id"
                          :id="`chat-message-${message.id}`"
                          class="c-chat-message__box--body c-chat-message__box--body--to">{{ message.message }}</p>
                      </template>
                      <template
                        v-else>
                        <strong class="c-chat-message__box--user">hoge</strong>
                        <p
                          v-if="message.id"
                          :id="`chat-message-${message.id}`"
                          class="c-chat-message__box--body c-chat-message__box--body--from">{{ message.message }}</p>
                      </template>
                    </div>
                  </div>
                  <chat-form></chat-form>
                  <chat></chat>
              </div>
          </div>
      </div>
    </div>
  </div>
</template>

<script>
import chatForm from './chatForm.vue'
import chat from './chat.vue'

export default {
  name: 'chat-index',
  components: {
    'chatForm': chatForm,
    'chat': chat
  },
  data (){
    return {
    }
  },
  created () {
    this.fetchMatchedUsers()
    this.fetchMessages(this.$route.params.id)
  },
  updated () {
    if (this.lastMessage) {
      this.scrollToLastMessage(`chat-message-${this.lastMessage.id}`)
    }
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
    },
    messages() {
        return this.$store.getters.messages
    },
    lastMessage() {
      return this.$store.getters.lastMessage
    },
  },
  methods: {
    fetchMatchedUsers () {
      this.$store.dispatch('matchedUsers', {
        currentUser: this.currentUser,
      })
    },
    fetchMessages (match_id) {
      this.$store.dispatch('getChatMessages', {
        currentUser: this.currentUser,
        matchId: match_id
      })
    },
    scrollToLastMessage(lastMessageId) {
      document.getElementById(lastMessageId).scrollIntoView()
    }
  }
}
</script>

<style lang="scss" scoped>
  .c-chat-messages__wrap {
    height: 400px;
    max-height: 400px;
    overflow-y: scroll;
    padding: 15px;
    border-bottom: 1px solid #eee;
  }
  .c-chat-message__box {
    &--user {

    }
    &--body {
      padding: 5px 20px;
      border-radius: 6px;
      font-weight: 300;
      font-size: 14px;
      line-height: 1.4;
      white-space: pre-wrap;
      -webkit-font-smoothing: subpixel-antialiased;
    }
    &--body--from {
      background-color: #f1f0f0;
      color: rgba(0, 0, 0, 1);
    }
    &--body--to {
      color: rgb(255, 255, 255);
      background-color: rgb(78, 140, 255);
    }
  }
</style>