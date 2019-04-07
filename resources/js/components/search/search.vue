<template>
  <div id="c-search-form" class="panel-primary panel" style="border: .5px solid #337ab7; padding: 15px;">
    <div class="panel-heading row">
      <div class="col-sm-4 col-xs-12"><h3 class="panel-title">検索項目</h3></div>
      <div class="col-sm-4 col-xs-12"></div>
      <div class="col-sm-4 col-xs-12">
        <div class="pull-right">
          <button type="button" class="btn btn-light btn-xs" @click="resetInput()">検索リセット</button>
        </div>
      </div>
    </div>
    <div class="panel-body">
      <div class="row">
        <div class="col-xs-12">
          <div class="fl hidden"><p></p></div>
        </div>
      </div>
      <div class="row">
        <div class="form-group col-sm-6 col-xs-12">
          <div class="row">
            <div class="form-group col-sm-6 col-xs-12">
              <select
              v-model="smoke_flag"
              type="number"
              class="form-control">
                <option value="" disabled>タバコ</option>
                <option v-bind:value="1">吸う</option>
                <option v-bind:value="2">吸わない</option>
              </select>
            </div>
            <div class="form-group col-sm-6 col-xs-12">
              <select
              v-model="nomad_flag"
              type="number"
              class="form-control">
                <option value="" disabled>ノマド</option>
                <option v-bind:value="1">ノマド達成済み</option>
                <option v-bind:value="2">目指している</option>
                <option v-bind:value="3">ノマドではない</option>
              </select>
            </div>
          </div>
        </div>
        <div class="form-group col-sm-6 col-xs-12">
          <input
          v-model="profile_name"
          class="form-control" placeholder="名前">
        </div>
      </div>

    </div>
  </div>

</template>

<script>


export default {
  name: 'search',

  data () {
    return {
      profile_name: '',
      smoke_flag: '',
      nomad_flag: '',
    }
  },

  created() {
    // this.fetch()
  },

  watch: {
    profile_name: "fetch",
    smoke_flag: "fetch",
    nomad_flag: "fetch",
  },

  computed: {
    currentUser() {
      return this.$store.getters.currentUser
    },

  },

  methods: {
    fetch () {

      this.$store.dispatch('searchProfiles', {data: [{
        smoke_flag: this.smoke_flag,
        nomad_flag: this.nomad_flag,
        profile_name: this.profile_name
      }]})
    },
    resetInput() {
      this.smoke_flag = ''
      this.nomad_flag = ''
      this.profile_name = []
    }

  },
}
</script>

<style lang="scss">
  #c-search-form {
    .panel-heading {
      display: flex;
    }
  }
</style>