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
      <div :style="styleTechHeight" class="box tech">
        123
      </div>
    </div>
  </php-sandbox-layout>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import PhpSandboxLayout from '@/layouts/PhpSandboxLayout.vue';
import Editor from '@/components/php-sandbox/content/Editor.vue';
import HeaderBar from "@/components/php-sandbox/header/HeaderBar.vue";

@Component({
  components: {
    Editor,
    PhpSandboxLayout,
    HeaderBar,
  },
})
export default class Environment extends Vue {
  private styleEditorHeight = "height: " + (document.documentElement.clientHeight-160)/10*5 + "px;";
  private styleResultHeight = "height: " + (document.documentElement.clientHeight-160)/10*3 + "px;";
  private styleTechHeight = "height: " + (document.documentElement.clientHeight-160)/10 + "px;";
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