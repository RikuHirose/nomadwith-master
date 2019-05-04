<template>
  <div>
    <div class="card-header">
      <router-link
        :to="`/login`"
        class="dropdown-item active">login</router-link>
      <router-link
        :to="`/signup`"
        class="dropdown-item">signup</router-link>
    </div>
    <form class="mt-5 mb-5">
      <div class="form-group row">
          <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

          <div class="col-md-6">
              <input
              id="email"
              type="email"
              class="form-control"
              v-model="email"
              required autofocus>
          </div>
      </div>

      <div class="form-group row">
          <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

          <div class="col-md-6">
              <input
                id="password"
                type="password"
                class="form-control"
                v-model="password"
                required>
          </div>
      </div>

      <div class="form-group row">
          <div class="col-md-6 offset-md-4">
              <div class="form-check">
                  <input
                    class="form-check-input"
                    type="checkbox"
                    v-model="remember"
                    id="remember">

                  <label class="form-check-label" for="remember">
                      Remember Me
                  </label>
              </div>
          </div>
      </div>

      <div class="form-group row mb-0">
          <div class="col-md-8 offset-md-4">
              <button
                @click="postLogin()"
                type="button"
                class="btn btn-primary">
                  Login
              </button>
          </div>
      </div>
    </form>
  </div>
</template>

<script>

export default {
  components: {
  },

  name: 'auth-login',

  data () {
    return {
      email: '',
      password: '',
      remember: '',
    }
  },

  created() {
    this.fetch()
  },

  computed: {
    currentUser() {
      return this.$store.getters.currentUser
    },


  },

  methods: {
    fetch () {
      this.$store.dispatch('getProfiles')
    },
    postLogin () {
      axios
        .post(`/login`, {
          email: this.email,
          password: this.password,
          remember: this.remember,
        })
        .then((response) => {
          window.location.href = '/'

        })
        .catch((err) => {
          alert(err)
        })
    }
  }
}
</script>