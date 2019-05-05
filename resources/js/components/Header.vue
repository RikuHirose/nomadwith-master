<template>
  <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
    <div class="container">
      <router-link class="navbar-brand" to="/"><img src="/static/user/images/logo.png" style="height: 40px;"></router-link>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
          <template v-if="!currentUser">
            <li>
              <router-link
                :to="`/login`"
                class="dropdown-item">Login</router-link>
            </li>
          </template>
          <template v-else>
            <li class="nav-item">
              <router-link
                to="/chats"
                class="">
                <i class="fas fa-comment"></i>
              </router-link>
            </li>
            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false" aria-haspopup="true">
                    {{ profile.name }} <span class="caret"></span>
                </a>

                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <router-link :to="`/mypage`" class="dropdown-item">プロフィール設定</router-link>
                    <a @click.prevent="logout" class="dropdown-item">Logout</a>
                </div>
            </li>
          </template>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script>
export default {
  name: 'app-header',

  created () {
    this.fetchMatchedUsers()
  },
  computed: {
    currentUser() {
      return this.$store.getters.currentUser
    },
    profile() {
      return this.$store.getters.currentUser.profile
    },
    matchedFirstUser() {
      return this.$store.getters.matchedFirstUser
    },
  },
  methods: {
    fetchMatchedUsers () {
      this.$store.dispatch('matchedUsers', {
        currentUser: this.currentUser,
      })
    },
    logout() {
      // this.$store.commit('logout');
      // this.$router.push('/signin');
      this.$store.dispatch('logout')
    }
  }
}
</script>