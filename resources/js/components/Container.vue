<template>
  <div class="container pt-2">
    <div class="row justify-content-center">
      <div class="col-md-8 col-xs-12">
        <div class="card card-default">
          <router-view></router-view>
        </div>
      </div>
    </div>
    <v-dialog/>
  </div>
</template>

<script>
  import Event from '../event.js';
  export default {
    name: 'container',
    mounted() {
      Event.$on('show-dialog', (message) => {
        this.$modal.show('dialog', {
          title: 'Alert!',
          text: message,
          buttons: [
            {
              title: 'Close'
            }
          ]
        })
      })
    }
  }

</script>