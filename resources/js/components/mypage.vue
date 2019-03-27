<template>

</template>

<script>
export default {
  name: 'mypage',

  methods: {

  },

  computed: {
    currentUser() {
      return this.$store.getters.currentUser
    }
  }
}
</script>