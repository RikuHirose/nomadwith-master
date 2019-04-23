<template>
  <div class="c-chat-messages__wrap" ref="message">
      <div
        v-for="message in this.messages"
        class="c-chat-message__box"
        :class="{ 'self': message.selfMessage }">
        <strong class="c-chat-message__box--user">hoge</strong>
        <p class="c-chat-message__box--body c-chat-message__box--body--from">{{ message.body }}</p>
      </div>
  </div>
</template>

<script>
  export default {
    name: 'chat-messages',
    data() {
      return {
      }
    },
    created () {
      this.fetchMessages()
    },
    mounted() {
    },
    computed: {
      currentUser() {
        return this.$store.getters.currentUser
      },
      messages() {
        return this.$store.getters.messages
      },
    },
    methods: {
      fetchMessages () {
        this.$store.dispatch('getMessages', {
          currentUser: this.currentUser,
        })
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