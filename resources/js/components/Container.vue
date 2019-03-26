<template>
  <div class="container pt-2">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card card-default">
          <router-view></router-view>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'container'
  }
</script>