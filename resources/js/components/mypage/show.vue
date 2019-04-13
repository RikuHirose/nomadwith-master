<template>
<div class="mt-3">
    <div class="container">
      <form>
        <div class="text-center mb-3">
          <img :src="profile.img_url" class="rounded-circle" style="width: 150px; height: 150px;">
          <p class="mt-3 mb-3">
            <input v-model="profileName" placeholder="edit me">
          </p>
        </div>

        <div class="w-75 mx-auto text-center">
          <p class="mt-3 mb-3">
            <textarea v-model="profileIntroduce" placeholder="add multiple lines"></textarea>
          </p>
        </div>

        <table class="table">
          <tbody>
            <tr>
              <th scope="row">居住地</th>
              <td>
                <input v-model="profileAddress" placeholder="edit me">
              </td>
            </tr>
            <tr>
              <th scope="row">職業</th>
              <td>
                <input v-model="profileJob" placeholder="edit me">
              </td>
            </tr>
            <tr>
              <th scope="row">年収</th>
              <td>
                <input v-model="profileSalary" placeholder="edit me">
              </td>
            </tr>
            <tr>
              <th scope="row">ノマド</th>
              <td>
                <select v-model="profileNomad_flag">
                  <option disabled value="">Please select one</option>
                  <option :value="1">ノマド達成済み</option>
                  <option :value="2">目指している</option>
                  <option :value="3">ノマドではない</option>
                </select>
              </td>

            </tr>
            <tr>
              <th scope="row">タバコ</th>
              <td>
                <select v-model="profileSmoke_flag">
                  <option disabled value="">Please select one</option>
                  <option :value="1">吸う</option>
                  <option :value="2">吸わない</option>
                </select>
              </td>
            </tr>
            <tr>
              <th scope="row">アルコール</th>
              <td>
                <select v-model="profileAlcohol_flag">
                  <option disabled value="">Please select one</option>
                  <option :value="1">飲む</option>
                  <option :value="2">飲まない</option>
                </select>
              </td>
            </tr>
          </tbody>
        </table>
        <div class="text-center mb-3">
          <button @click="updateProfile()" type="button" class="btn btn-secondary">プロフィールを編集</button>
        </div>
      </form>
    </div>
    <modal
      v-if="showModal"
      @close="showModal = false"
      :profileId="profile.id"
    ></modal>
  </div>
</template>

<script>
import modal from '../Modal.vue'

export default {
  name: 'mypage',
  components: {
    'modal': modal,
  },
  data (){
    return {
      profileName: '',
      showModal: false,
    }
  },

  created () {
    this.profileName = this.profile.name
    this.profileIntroduce = this.profile.introduce
    this.profileAddress = this.profile.address
    this.profileJob = this.profile.job
    this.profileSalary = this.profile.salary
    this.profileNomad_flag = this.profile.nomad_flag
    this.profileSmoke_flag = this.profile.smoke_flag
    this.profileAlcohol_flag = this.profile.alcohol_flag
  },

  methods: {

  },

  computed: {
    currentUser() {
      return this.$store.getters.currentUser
    },
    profile() {
      return this.$store.getters.currentUser.profile
    }
  },
  methods: {
    updateProfile () {
      this.$store.dispatch('updateProfile', {data: [{
        id: this.profile.id,
        name: this.profileName,
        introduce: this.profileIntroduce,
        address: this.profileAddress,
        job: this.profileJob,
        salary: this.profileSalary,
        nomad_flag: this.profileNomad_flag,
        smoke_flag: this.profileSmoke_flag,
        alcohol_flag: this.profileAlcohol_flag,
      }]})
      this.showModal = true
    }
  }
}
</script>