<template>
  <php-sandbox-layout>
    <header-bar
      :load-instances="loadInstances"
      :instance-list="instanceList"
      v-on:submit-button-run="runCode"
    />
    <div class="container environment">
      <div class="box editor">
        <editor ref="editor" :style-editor-height="styleEditorHeight"></editor>
      </div>
      <div :style="styleResultHeight" class="box result">
        <pre v-if="runResponse.responseFromPhpInstance.result !== ''">{{runResponse.responseFromPhpInstance.result}}</pre>
      </div>
      <div v-if="runResponse.responseFromPhpInstance.result !== ''" class="box tech">
        <div class="columns">
          <div v-if="runResponse.responseFromPhpInstance.execTime !== 0" class="column">
            Time to execution: {{runResponse.responseFromPhpInstance.execTime}}
          </div>
          <div v-if="runResponse.responseFromPhpInstance.useMemoryMb !== 0" class="column">
            Use memory (MB): {{runResponse.responseFromPhpInstance.useMemoryMb}}
          </div>
          <div v-if="runResponse.responseFromPhpInstance.version !== ''" class="column">
            PHP version: {{runResponse.responseFromPhpInstance.version}}
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
import SpinnerComponent from "@/components/SpinnerComponent.vue";
import {PhpHubApi} from "@/providers/php-hub-api";
import { settingsPhpModule } from '@/store/settings-php';

@Component({
  components: {
    FooterSpace,
    Editor,
    PhpSandboxLayout,
    HeaderBar,
    SpinnerComponent,
  },
})
export default class PhpSandbox extends Vue {
  private styleEditorHeight = "height: " + (document.documentElement.clientHeight-160)/10*4 + "px;";
  private styleResultHeight = "height: " + (document.documentElement.clientHeight-160)/10*3 + "px;";
  protected phpHubApiClient = new PhpHubApi();
  protected instanceList: PhpInstance[] | undefined = [];
  protected runResponse: RunResponseFromHub | undefined = {
    responseCodeFromPhpInstance: 0,
    responseFromPhpInstance: {
      responseCode: 0,
      result: '',
      execTime: 0,
      useMemoryMb: 0,
      version: '',
    },
  };
  protected loadInstances = true;
  protected loadCodeResult = false;

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

  runCode() {
    const instance = settingsPhpModule.state.selectedPhpInstance;
    const editor = this.$refs['editor'] as Editor;
    const code = editor.getCode();
    this.loadCodeResult = true;
    this.phpHubApiClient.postCodeToRunner(instance.runUrl, code)
      .then((response) => {
        this.runResponse = response.data as RunResponseFromHub;
      })
      .catch((e) => {
        console.error(e);
      })
      .finally(() => {
        this.loadCodeResult = false;
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