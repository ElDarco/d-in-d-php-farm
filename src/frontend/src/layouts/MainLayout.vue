<template>
  <div class="basic-layout">
    <slot></slot>
  </div>
</template>


<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import HeaderBar from "@/components/php-sandbox/header/HeaderBar.vue";

@Component({
  components: {
    HeaderBar,
  }
})
export default class MainLayout extends Vue {}
</script>

<style>

</style>