<template>
  <div>
    <search></search>

    <div class="row">
      <div
      v-for="(profile, index) in profiles"
      class="col-md-4 col-sm-6 col-xs-12">
        <div
        class="card">
          <img class="card-img-top" src="https://pbs.twimg.com/profile_images/1086579114029461505/qrD4Sdco_400x400.jpg" alt="Card image cap">
          <div class="card-body">
            <h5 class="card-title">{{ profile.user.name }}</h5>
            <table class="table">
              <tbody>
                <tr>
                  <th scope="row">ノマド</th>
                  <td v-if="profile.nomad_flag == 1">ノマド達成済み</td>
                  <td v-if="profile.nomad_flag == 2">目指している</td>
                  <td v-if="profile.nomad_flag == 3">ノマドではない</td>
                </tr>
                <tr>
                  <th scope="row">タバコ</th>
                  <td v-if="profile.smoke_flag == 1">吸う</td>
                  <td v-if="profile.smoke_flag == 2">吸わない</td>
                </tr>
              </tbody>
            </table>

            <router-link :to="`/profiles/${profile.id}`" class="btn btn-primary">Go somewhere</router-link>
          </div>
        </div>
      </div>
    </div>

  </div>

</template>

<script>
import search from '../search/search.vue'

export default {
  components: {
    'search': search,
  },

  name: 'profile-index',

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

    profiles() {
      return this.$store.getters.profiles
    }

  },

  methods: {
    fetch () {
      this.$store.dispatch('getProfiles')
    },

  },
}
</script>