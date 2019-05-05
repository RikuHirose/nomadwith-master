<template>
  <div>
    <div class="card-header">Matched Users</div>
    <div
      id="message-card-body"
      class="card-body">
        <template v-if="matchedUsers.fail">
        </template>
        <template v-else>
          <div class="users" v-for="user in matchedUsers">
              <router-link
                v-if="user.user.profile"
                :to="`/chats/${user.match_id}`"
                @click.native="fetchMessages(user.match_id)"
                class="">{{ user.user.profile.name }}</router-link>
          </div>
        </template>
    </div>
  </div>
</template>
<script>
export default {
  name: 'matched-users',
  components: {

  },
  data (){
    return {
    }
  },
  created () {
    this.fetchMatchedUsers()
    if (this.$route.params.id) {
      this.fetchMessages(this.$route.params.id)
    }
  },

  computed: {
    currentUser() {
      return this.$store.getters.currentUser
    },

    matchedUsers() {
      return this.$store.getters.matchedUsers
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
  }
}
</script>

<style lang="scss" scoped>
</style>