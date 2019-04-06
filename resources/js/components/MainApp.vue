<template>
  <div id="main">
    <Header v-if="showHeader"></Header>
    <div class="content">
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
import Header from './Header.vue';

export default {
  name: 'main-app',

  props: ['showHeader'],

  data () {
    return {
    }
  },

  created () {

  },

  components: { Header }
}
</script>
