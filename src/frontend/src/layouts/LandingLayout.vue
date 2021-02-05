<template>
  <div class="landing-layout">
    <slot></slot>
  </div>
</template>


<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';

@Component({})
export default class LandingLayout extends Vue {}
</script>

<style>

</style>