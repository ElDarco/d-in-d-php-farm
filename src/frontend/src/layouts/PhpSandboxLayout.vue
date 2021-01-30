<template>
  <div>
    <header-bar/>
    <div class="php-sandbox-layout">
      <slot></slot>
    </div>
  </div>
</template>


<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import HeaderBar from "@/components/header/HeaderBar.vue";

@Component({
  components: {
    HeaderBar,
  }
})
export default class PhpSandboxLayout extends Vue {}
</script>

<style scoped>

</style>