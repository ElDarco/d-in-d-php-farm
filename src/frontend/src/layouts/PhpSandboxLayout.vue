<template>
  <div class="layout">
    <div class="php-sandbox-layout">
      <slot></slot>
    </div>
  </div>
</template>


<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';

@Component({
  components: {
  }
})
export default class PhpSandboxLayout extends Vue {}
</script>

<style>

</style>