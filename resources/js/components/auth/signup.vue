<template>
  <div>
    <div class="card-header">
      <router-link
        :to="`/login`"
        class="dropdown-item">login</router-link>
      <router-link
        :to="`/signup`"
        class="dropdown-item active">signup</router-link>
    </div>
    <form class="mt-5 mb-5">
      <div class="form-group row">
          <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

          <div class="col-md-6">
              <input
                v-model="name"
                id="name"
                type="text"
                class="form-control"
                required autofocus>
          </div>
      </div>

      <div class="form-group row">
          <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

          <div class="col-md-6">
              <input
                v-model="email"
                id="email"
                type="email"
                class="form-control"
                required>
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
          <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>

          <div class="col-md-6">
              <input
                id="password-confirm"
                type="password"
                class="form-control"
                v-model="password_confirmation"
                required>
          </div>
      </div>

      <div class="form-group row mb-0">
          <div class="col-md-6 offset-md-4">
              <button
                @click="postRegister()"
                type="button"
                class="btn btn-primary">
                  Register
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
      name: '',
      email: '',
      password: '',
      password_confirmation: ''
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
    postRegister () {
      axios
        .post(`/register`, {
          name: this.name,
          email: this.email,
          password: this.password,
          password_confirmation: this.password_confirmation,
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