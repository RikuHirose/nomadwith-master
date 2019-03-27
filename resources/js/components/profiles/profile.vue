<template>
  <div>
    dd
  </div>
</template>

<script>
export default {
  name: 'profile-show',

  created() {

    this.fetch()
  },

  computed: {
    currentUser() {
      return this.$store.getters.currentUser
    },
    profile() {
      return this.$store.getters.profile
    }
  },

  methods: {
    fetch () {
      this.$store.dispatch('getProfiles', {profileId: this.$route.params.id})
    },
  },
}
</script>