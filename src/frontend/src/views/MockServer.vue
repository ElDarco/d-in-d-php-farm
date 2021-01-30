<template>
  <mock-server-layout>
    <div class="environment">
    </div>
  </mock-server-layout>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import MockServerLayout from '@/layouts/MockServerLayout.vue';

@Component({
  components: {
    MockServerLayout,
  },
})
export default class MockServer extends Vue {}
</script>