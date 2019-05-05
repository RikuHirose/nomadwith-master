<template>
  <div class="c-chat-messages__wrap">
    <div
      v-for="message in this.messages"
      class="c-chat-message__box"
      :class="{ 'self': message.selfMessage }">
      <template
        v-if="message.send_from.id === currentUser.id">
        <p
          v-if="message.id"
          :id="`chat-message-${message.id}`"
          class="c-chat-message__box--body c-chat-message__box--body--to">{{ message.message }}</p>
      </template>
      <template
        v-else>
        <strong class="c-chat-message__box--user">{{ message.send_from.profile.name }}</strong>
        <p
          v-if="message.id"
          :id="`chat-message-${message.id}`"
          class="c-chat-message__box--body c-chat-message__box--body--from">{{ message.message }}</p>
      </template>
    </div>
  </div>
</template>

<script>
  import isMobile from '../../utils/DeviceUtility.js'
  // isMobile.isMobile()
  export default {
    name: 'chat-messages',
    props: [],
    data() {
      return {
      }
    },
    created () {

      if (this.$route.params.id) {
        this.fetchMessages(this.$route.params.id)
      }
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

      messages() {
          return this.$store.getters.messages
      },
      lastMessage() {
        return this.$store.getters.lastMessage
      },
    },
    methods: {
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