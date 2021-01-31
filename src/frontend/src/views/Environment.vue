<template>
  <php-sandbox-layout>
    <header-bar/>
    <div class="container environment">
      <div class="box editor">
        <editor :style-editor-height="styleEditorHeight"></editor>
      </div>
      <div :style="styleResultHeight" class="box result">
        123
      </div>
      <div class="box tech">
        <div class="columns">
          <div class="column">
            Time to execution:
          </div>
          <div class="column">
            Use memory (MB):
          </div>
          <div class="column">
            PHP version:
          </div>
        </div>
      </div>
    </div>
    <footer-space/>
  </php-sandbox-layout>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import PhpSandboxLayout from '@/layouts/PhpSandboxLayout.vue';
import Editor from '@/components/php-sandbox/content/Editor.vue';
import HeaderBar from "@/components/php-sandbox/header/HeaderBar.vue";
import FooterSpace from "@/components/php-sandbox/footer/FooterSpace.vue";

@Component({
  components: {
    FooterSpace,
    Editor,
    PhpSandboxLayout,
    HeaderBar,
  },
})
export default class Environment extends Vue {
  private styleEditorHeight = "height: " + (document.documentElement.clientHeight-160)/10*4 + "px;";
  private styleResultHeight = "height: " + (document.documentElement.clientHeight-160)/10*3 + "px;";
}
</script>

<style>
.environment {
  padding-top: 20px;
  padding-bottom: 20px;
  min-height: 100%;
}

.editor {
  min-width: 100%;
  min-height: 100%;
}
</style>