<template>
  <div>
    <div class="basic-layout">
      <slot></slot>
    </div>
  </div>
</template>


<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import HeaderBar from "@/components/php-sandbox/header/HeaderBar.vue";

@Component({})
export default class LandingLayout extends Vue {}
</script>

<style>

</style>