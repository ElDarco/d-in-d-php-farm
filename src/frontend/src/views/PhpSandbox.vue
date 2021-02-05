<template>
  <php-sandbox-layout>
    <header-bar :load-instances="loadInstances" :instance-list="instanceList"/>
    <div class="container environment">
      <div class="box editor">
        <editor :style-editor-height="styleEditorHeight"></editor>
      </div>
      <div :style="styleResultHeight" class="box result">
        <pre>123</pre>
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
import {PhpHubApi} from "@/providers/php-hub-api";

@Component({
  components: {
    FooterSpace,
    Editor,
    PhpSandboxLayout,
    HeaderBar,
  },
})
export default class PhpSandbox extends Vue {
  private styleEditorHeight = "height: " + (document.documentElement.clientHeight-160)/10*4 + "px;";
  private styleResultHeight = "height: " + (document.documentElement.clientHeight-160)/10*3 + "px;";
  protected phpHubApiClient = new PhpHubApi();
  protected instanceList: PhpInstance[] | undefined = [];
  protected loadInstances = true;

  getInstanceList() {
    this.phpHubApiClient.getListPhpInstances()
      .then((response) => {
        this.instanceList = response.data.phpInstances as PhpInstance[];
      })
      .catch((e) => {
        console.error(e);
      })
      .finally(() => {
        this.loadInstances = false;
      });
  }

  mounted() {
    this.getInstanceList();
  }
}
</script>

<style>
.environment {
  padding-top: 20px;
  padding-bottom: 20px;
  min-height: 100%;
}

.result {
  overflow-y: auto;
}

.editor {
  min-width: 100%;
  min-height: 100%;
}
</style>