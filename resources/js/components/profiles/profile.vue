<template>

  <div class="mt-3">
    <div class="container">
      <div class="text-center mb-3">
        <img src="https://pbs.twimg.com/profile_images/1086579114029461505/qrD4Sdco_400x400.jpg" class="rounded-circle" style="width: 150px; height: 150px;">
        <p class="mt-3 mb-3">{{ profile.user.name }}</p>
      </div>

      <div class="w-75 mx-auto text-center">
        <p class="mt-3 mb-3">{{ profile.introduce }}</p>
      </div>

      <table class="table">
        <tbody>
          <tr>
            <th scope="row">居住地</th>
            <td>{{ profile.address }}</td>
          </tr>
          <tr>
            <th scope="row">職業</th>
            <td>{{ profile.job }}</td>
          </tr>
          <tr>
            <th scope="row">年収</th>
            <td>{{ profile.salary }}</td>
          </tr>
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
          <tr>
            <th scope="row">アルコール</th>
            <td v-if="profile.alcohol_flag == 1">飲む</td>
            <td v-if="profile.alcohol_flag == 2">飲まない</td>
          </tr>
        </tbody>
      </table>
    </div>
    <button @click="showModal = true">モーダル表示</button>
    <contact
    v-if="showModal"
    @close="showModal = false"
    :profileId="profile.id"
    ></contact>

  </div>

</template>

<script>
import contact from './contact/contact.vue'

export default {
  components: {
    'contact': contact,
  },
  name: 'profile-show',

  data () {
    return {
      showModal: false,
      message: ''
    }
  },

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
    // sendContact (profileId) {
    //   axios
    //     .post(`/api/v1/profiles/${profileId}/contact`)
    //     .then((response) => {
          
    //     })
    //     .catch((err) => {
    //       alert(err)
    //     })
    // }
  },
}
</script>