<template>
  <monaco-editor :style="styleEditorHeight" v-model="code" language="php"></monaco-editor>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';
import MonacoEditor from 'vue-monaco'

@Component({
  components: {
    MonacoEditor
  },
})
export default class Editor extends Vue {
  @Prop() private styleEditorHeight: string | undefined;

  private code = "<"+"?php"+"\n"+"\n";

  public getCode() {
    return this.code
  }
}
</script>