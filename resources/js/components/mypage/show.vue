<template>
<div class="mt-3">
    <div class="container">
      <form>
        <div class="text-center mb-3">
          <img
            :src="profile.img_url"
            class="rounded-circle"
            style="width: 150px;
            height: 150px;">
             <input
              style="display: none;"
              type="file"
              id="avator-input"
              accept="image/png,image/jpeg,image/gif"
              v-on:change="uploadImage" />
          <p class="mt-3 mb-3">
            <button
              type="button"
              class="btn btn-primary"
              @click="showImageUpdateModal()">プロフィール写真を変更する</button>
          </p>
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
                <select v-model="profileNomadFlag">
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
                <select v-model="profileSmokeFlag">
                  <option disabled value="">Please select one</option>
                  <option :value="1">吸う</option>
                  <option :value="2">吸わない</option>
                </select>
              </td>
            </tr>
            <tr>
              <th scope="row">アルコール</th>
              <td>
                <select v-model="profileAlcoholFlag">
                  <option disabled value="">Please select one</option>
                  <option :value="1">飲む</option>
                  <option :value="2">飲まない</option>
                </select>
              </td>
            </tr>
          </tbody>
        </table>
        <div class="text-center mb-3">
          <button
            @click="updateProfile()"
            type="button"
            class="btn btn-secondary">プロフィールを編集</button>
        </div>
      </form>
    </div>
    <modal
      name="imageChangeModal"
      :width="400"
      :height="200">
      <button
        type="button"
        class="btn btn-primary btn-lg btn-block"
        @click="selectImage()">写真をアップロード</button>
      <button type="button" class="btn btn-secondary btn-lg btn-block">現在の写真を削除</button>
    </modal>
  </div>
</template>

<script>
// import modal from '../Modal.vue'
import Event from '../../event.js';

export default {
  name: 'mypage',
  components: {
    // 'modal': modal,
  },
  data (){
    return {
      profileName: '',
      showEditBtn: true,
      profileName: '',
      profileIntroduce: '',
      profileAddress: '',
      profileJob: '',
      profileSalary: '',
      profileNomadFlag: '',
      profileSmokeFlag: '',
      profileAlcoholFlag: '',
    }
  },
  created () {
    this.fetch()
  },
  beforeMount() {
    this.profileName = this.profile.name
    this.profileIntroduce = this.profile.introduce
    this.profileAddress = this.profile.address
    this.profileJob = this.profile.job
    this.profileSalary = this.profile.salary
    this.profileNomadFlag = this.profile.nomad_flag
    this.profileSmokeFlag = this.profile.smoke_flag
    this.profileAlcoholFlag = this.profile.alcohol_flag
    console.log(this.profile.name, this.profileName)
  },
  computed: {
    currentUser() {
      return this.$store.getters.currentUser
    },
    profile() {
      return this.$store.getters.profile
    }
  },
  updated () {
  },
  methods: {
    fetch () {
      this.$store.dispatch('getProfile', {profileId: this.currentUser.profile.id})
    },
    updateProfile () {
      this.$store.dispatch('updateProfile', {data: [{
        id: this.profile.id,
        name: this.profileName,
        introduce: this.profileIntroduce,
        address: this.profileAddress,
        job: this.profileJob,
        salary: this.profileSalary,
        nomad_flag: this.profileNomadFlag,
        smoke_flag: this.profileSmokeFlag,
        alcohol_flag: this.profileAlcoholFlag,
      }]})
      Event.$emit('show-dialog', 'プロフィールを編集しました')
    },
    showImageUpdateModal () {
       this.$modal.show('imageChangeModal');
       // Event.$emit('show-dialog', 'プロフィールを編集しました')
    },
    selectImage () {
      const input = document.querySelector('#avator-input');
      input.click();
    },
    uploadImage(e) {
      e.preventDefault();

      if (e.target.files.length === 0) {
        return null;
      }
      const imagefile = e.target.files[0]
      this.$store.dispatch('updateProfileImage',
      {
        profileId: this.profile.id,
        image: imagefile
      })
      Event.$emit('show-dialog', 'プロフィール画像を編集しました')
    },
  }
}
</script>