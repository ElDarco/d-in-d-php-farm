<template>
  <monaco-editor :style="styleEditorHeight" v-model="code" language="php"></monaco-editor>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';
import MonacoEditor from 'vue-monaco'
import Cookies from 'js-cookie'

@Component({
  components: {
    MonacoEditor
  },
})
export default class Editor extends Vue {
  @Prop() private styleEditorHeight: string | undefined;

  private code = "";

  public getCode() {
    Cookies.set('code', this.code);
    return this.code
  }

  mounted() {
    this.code = "<"+"?php"+"\n"+"\n";
    const cookieCode = Cookies.get('code');
    if (cookieCode) {
      this.code = Cookies.get('code');
    }
  }
}
</script>