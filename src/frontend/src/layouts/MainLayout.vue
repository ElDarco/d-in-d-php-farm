<template>
  <div>
    <header-bar/>
    <div class="basic-layout">
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
export default class MainLayout extends Vue {}
</script>

<style scoped>

</style>