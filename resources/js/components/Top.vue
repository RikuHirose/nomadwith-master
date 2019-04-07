<template>
  <profileIndex></profileIndex>

</template>

<script>

import profileIndex from './profiles/index.vue'

export default {
  components: {
    'profileIndex': profileIndex,
  },
  name: 'top',

  data () {
    return {

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

    },

  },
}
</script>