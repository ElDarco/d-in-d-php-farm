<template>
  <main-layout>
    <div class="environment">
    </div>
  </main-layout>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import MainLayout from '@/layouts/MainLayout.vue';

@Component({
  components: {
    MainLayout,
  },
})
export default class Environment extends Vue {}
</script>