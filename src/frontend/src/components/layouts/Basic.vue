<template>
  <div class="basic" v-bind:class="[ isNight ? 'theme-dark' : 'theme-white' ]">
    <div class="wrapper">
      <header-basic></header-basic>
      <slot/>
      <br />
      <footer-basic></footer-basic>
    </div>
  </div>
</template>
<script>
import HeaderBasic from '@/components/header/HeaderBasic'
import FooterBasic from '@/components/footer/FooterBasic'
export default {
  name: 'BasicLayout',
  components: {
    HeaderBasic,
    FooterBasic
  },
  computed: {
    isNight: function () {
      return this.$store.getters['user/getNightMode'] || false
    }
  }
}
</script>
<style>
  div.wrapper {
    padding: 12px 30px;
    max-width: 1200px;
    margin: auto;
  }
  div.basic {
    min-height: 100vh;
  }
  .theme-dark {
    background-color: #313335;
    color: #ffffff;
  }
  .theme-white {
    background-color: #f0f0f0;
    color: #313335;
  }
</style>
