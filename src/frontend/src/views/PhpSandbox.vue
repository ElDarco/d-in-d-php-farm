<template>
  <php-sandbox-layout>
    <header-bar
      :load-instances="loadInstances"
      :instance-list="instanceList"
      v-on:submit-button-run="runCode"
      v-on:profiler-toggle:update="profilerToggle = $event"
    />
      <div class="container environment is-hidden-touch">
        <div class="box editor">
          <editor
              ref="editor"
              :style-editor-height="styleEditorHeight"
          />
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
              <a
                class="is-pulled-right"
                v-if="runResponse.responseDebugGUIUrl && runResponse.responseDebugGUIUrl !== ''"
                @click="showProfilerModal = !showProfilerModal"
              >
                Show profiler
              </a>
              <div class="modal" :class="{'is-active': showProfilerModal, 'is-clipped': true}">
                <div class="modal-background"></div>
                <div class="modal-card">
                  <header class="modal-card-head">
                    <p class="modal-card-title">Profiler</p>
                    <button class="delete" aria-label="close" @click="showProfilerModal = !showProfilerModal"></button>
                  </header>
                  <section class="modal-card-body is-clipped" :style="styleProfilerHeight">
                    <iframe :src="getUrlForProfilerFrame(runResponse.responseDebugGUIUrl)" width="100%" height="100%"></iframe>
                  </section>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="container environment is-hidden-desktop">
        <h1>Sorry, but this page dont work in your device</h1>
        <h2>Please, use your desktop for work</h2>
        <h3>But we are working on a mobile version of your sandbox!</h3>
        <h3>Comming soon!</h3>
      </div>
      <spinner-component :visible="loadCodeResult"/>
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
  private styleProfilerHeight = "height: " + (document.documentElement.clientHeight-160)/10*8 + "px;";
  protected phpHubApiClient = new PhpHubApi();
  protected instanceList: PhpInstance[] | undefined = [];
  protected runResponse: RunResponseFromHub | undefined = {
    responseCodeFromPhpInstance: 0,
    responseDebugGUIUrl: '',
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

  protected showProfilerModal = false;


  protected profilerToggle = true;

  clearRunResult() {
    this.runResponse = {
      responseCodeFromPhpInstance: 0,
      responseDebugGUIUrl: '',
      responseFromPhpInstance: {
        responseCode: 0,
        result: '',
        execTime: 0,
        useMemoryMb: 0,
        version: '',
      },
    };
  }

  getUrlForProfilerFrame(url: string) {
    return process.env.VUE_APP_PROFILER_HOST_URL + url
  }

  getInstanceList() {
    this.phpHubApiClient.getListPhpInstances()
      .then((response) => {
        this.instanceList = response.data.phpInstances as PhpInstance[];
      })
      .catch((e) => {
        console.log(e);
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
    this.phpHubApiClient.postCodeToRunner(instance.runUrl, code, this.profilerToggle)
      .then((response) => {
        this.runResponse = response.data as RunResponseFromHub;
      })
      .catch(() => {
        this.clearRunResult();
        this.runResponse = {
          responseCodeFromPhpInstance: 500,
          responseFromPhpInstance: {
            responseCode: 500,
            result: 'Something Went Wrong',
            execTime: 0,
            useMemoryMb: 0,
            version: '',
          }
        } as RunResponseFromHub;
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