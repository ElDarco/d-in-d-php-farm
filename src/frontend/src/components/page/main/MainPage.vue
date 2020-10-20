<template>
    <div>
      <layout-basic>
        <div class="container">
          <div class="editor-area">
            <monaco-editor ref="monacoEditor" v-bind:theme="themeName" class="editor" v-model="code" language="php"/>
          </div>
          <div class="result-area">
            <div class="result">{{result}}</div>
            <div class="result-status">
              <div class="time">Time to execution: <div class="value time-value">{{exec_time}}</div></div>
              <div class="memory">Use memory (MB): <div class="value memory-value">{{use_memory_mb}}</div></div>
              <div class="version">PHP version: <div class="value version-value">{{version}}</div></div>
            </div>
          </div>
        </div>
      </layout-basic>
    </div>
</template>

<style scoped>
  .value {
    display: inline-block;
  }

  .time-value {
    display: contents;
  }
  .memory-value {
    display: contents;
  }
  .version-value {
    display: contents;
  }

  .container h3 {
    margin: 10px 0px 10px;
  }

  .editor-area {
    margin-top: 10px;
    border: 1px solid #111111;
  }

  .editor {
    background-color: #2b2b2b;
    width: 100%;
    min-height: 45vh;
  }

  .result-area {
    margin-top: 10px;
    border: 1px solid #111111;
    position: relative;
    height: 41vh;
    overflow-y: auto;
    overflow-x: hidden;
  }

  .result {
    margin: 5px;
    width: 100%;
  }

  .result-status {
    border-top: 1px solid #111111;
    position: absolute;
    display: flex;
    justify-content: space-between;
    bottom: 0;
    padding-left: 5px;
    width: 100%;
  }

  .result-status > div {
    width: 33%;
  }

  /* width */
  ::-webkit-scrollbar {
    width: 5px;
  }

  /* Track */
  ::-webkit-scrollbar-track {
    box-shadow: inset 0 0 5px grey;
    border-radius: 4px 0 0 4px;
  }

  /* Handle */
  ::-webkit-scrollbar-thumb {
    background: #007cd7;
    border-radius: 4px 0 0 4px;
  }
</style>

<script>
import LayoutBasic from '@/components/layouts/Basic'
import MonacoEditor from 'vue-monaco'
import SandboxConnector from '@/providers/SandboxConnector'
import { eventBus } from '../../../main.js'
export default {
  name: 'MainPage',
  components: {
    LayoutBasic,
    MonacoEditor
  },
  data () {
    return {
      exec_time: '',
      use_memory_mb: '',
      version: '',
      eventBus: eventBus,
      result: 'Result here...',
      client: new SandboxConnector(),
      code: this.$store.getters['user/getCode'] || '<?php'
    }
  },
  watch: {
    code: function () {
      this.$store.dispatch('user/saveSetCode', this.code)
    }
  },
  computed: {
    themeName: function () {
      if (this.$store.getters['user/getNightMode']) {
        return 'vs-dark'
      } else {
        return 'vs'
      }
    },
    themeButton: function () {
      if (this.$store.getters['user/getNightMode']) {
        return 'black'
      } else {
        return 'white'
      }
    }
  },
  mounted: function () {
    this.eventBus.$on('runCode', this.runCode)
    this.$refs['monacoEditor'].getMonaco().focus()
    this.$refs['monacoEditor'].getMonaco().setPosition({
      column: this.$refs['monacoEditor'].getMonaco().getModel().getLineLength(
        this.$refs['monacoEditor'].getMonaco().getModel().getLineCount()
      ),
      lineNumber: this.$refs['monacoEditor'].getMonaco().getModel().getLineCount() + 1
    })
  },
  methods: {
    runCode: function () {
      this.client.run(this.code).then(response => {
        if (response) {
          this.exec_time = response.exec_time + ' sec'
          this.use_memory_mb = response.use_memory_mb
          this.version = response.version
          this.result = response.result
        }
      })
    }
  }
}
</script>
