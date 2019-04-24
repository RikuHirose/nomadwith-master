<template>
  <form class="form">
      <textarea
        id="body"
        cols="28"
        rows="5"
        class="form-input"
        @keydown="typing"
        v-model="message">
      </textarea>
      <span class="notice">
          Hit Return to send a message
      </span>
  </form>
</template>

<script>
  export default {
    data() {
      return {
          message: null
      }
    },
    computed: {
      currentUser() {
        return this.$store.getters.currentUser
      }
    },
    methods: {
      typing(e) {
        if(e.keyCode === 13 && !e.shiftKey) {
            e.preventDefault();
            this.sendMessage();
        }
      },
      sendMessage() {
        if(!this.message || this.message.trim() === '') {
            return
        }
        // let messageObj = this.buildMessage();

        this.$store.dispatch('sendMessage', {
          currentUser: this.currentUser,
          matchId: this.$route.params.id,
          message: this.message.trim()
        })
        this.message = null;
      },
      buildMessage() {
        return {
          id: Date.now(),
          message: this.message,
          selfMessage: true,
          user: {
              name: ''
          }
        }
      }
    }
  }
</script>

<style>
    .form {
        padding: 8px;
    }
    .form-input {
        width: 100%;
        border: 1px solid #d3e0e9;
        padding: 5px 10px;
        outline: none;
    }
    .notice {
        color: #aaa
    }
    
</style>
