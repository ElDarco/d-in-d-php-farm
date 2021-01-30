<template>
  <div class="welcome">
    123
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import LandingLayout from '@/layouts/LandingLayout.vue';

@Component({
  components: {
    LandingLayout,
  },
})
export default class Welcome extends Vue {}
</script>
