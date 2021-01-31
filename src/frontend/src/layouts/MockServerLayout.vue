<template>
  <div class="mock-server-layout">
    <slot></slot>
  </div>
</template>


<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';

@Component({
  components: {
  }
})
export default class MockServerLayout extends Vue {}
</script>

<style>

</style>