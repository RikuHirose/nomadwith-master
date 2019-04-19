<template>
  <div class="message-area" ref="message">
      <div
        v-for="message in messages"
        class="message"
        :class="{ 'self': message.selfMessage }">
        <strong class="user">{{ message.user.name }}</strong>
        <p class="body">{{ message.body }}</p>
      </div>
  </div>
</template>

<script>
  export default {
    data() {
      return {
          messages: []
      }
    },
    mounted() {
      axios.get('/message').then((response) => {
          this.messages = response.data;
      });
    }
  }
</script>
<style>
  .message-area {
      height: 400px;
      max-height: 400px;
      overflow-y: scroll;
      padding: 15px;
      border-bottom: 1px solid #eee;
  }
</style>