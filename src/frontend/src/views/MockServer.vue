<template>
  <mock-server-layout>
    <header-bar/>
    <div class="environment">
    </div>
    <footer-space/>
  </mock-server-layout>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import MockServerLayout from '@/layouts/MockServerLayout.vue';
import HeaderBar from "@/components/mock-server/header/HeaderBar.vue";
import FooterSpace from "@/components/mock-server/footer/FooterSpace.vue";

@Component({
  components: {
    MockServerLayout,
    HeaderBar,
    FooterSpace,
  },
})
export default class MockServer extends Vue {}
</script>