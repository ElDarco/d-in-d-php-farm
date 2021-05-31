<template>
  <div>
    <spinner-component :visible="loadCreateNSettingsIndicator"/>
    <p class="is-size-5"><b>Create NSettings</b></p>
    <hr>
    <n-settings-editor ref="n-settings-editor" :n-settings="getTemplateForNSettings">
      <hr>
      <div class="columns">
        <div class="column">
          <button class="button" @click="addNewNSettings">
          <span class="icon">
            <i class="fas fa-save"></i>
          </span>
            <span>Save</span>
          </button>
        </div>
        <div class="column"></div>
      </div>
    </n-settings-editor>
  </div>
</template>

<script lang="ts">
import {Component, Vue} from 'vue-property-decorator';
import {settingsMockServerModule} from "@/store/settings-mock-server";
import SpinnerComponent from "@/components/SpinnerComponent.vue";
import {MockServerProvider} from "@/providers/gateway/mock-server-provider";
import {AxiosResponse} from "axios";
import MonacoEditor from 'vue-monaco'
import NSettingsEditor from "@/components/mock-server/content/widget/NSettingsEditor.vue";

@Component({
  components: {
    NSettingsEditor,
    SpinnerComponent,
    MonacoEditor
  }
})
export default class CreateNSettingsView extends Vue {
  protected mockServerProvider = new MockServerProvider();
  protected loadCreateNSettingsIndicator = false;
  protected templateForNSettings: NSettings | undefined

  get getTemplateForNSettings(): NSettings | undefined {
    this.templateForNSettings = settingsMockServerModule.getters.getNSettingsTemplate();
    return this.templateForNSettings;
  }

  addNewNSettings() {
    const editor: NSettingsEditor = this.$refs['n-settings-editor'] as NSettingsEditor;
    const selectedNSpace = settingsMockServerModule.getters.getSelectedNSpace();
    this.loadCreateNSettingsIndicator = true;
    this.mockServerProvider.createNSettings(
        selectedNSpace,
        editor.getNSettingsResponseBody(),
        editor.getNSettingsUri(),
        editor.getNSettingsMethod(),
        editor.getNSettingsStatusCode(),
        editor.getNSettingsQueryString(),
        async (response: AxiosResponse) => {
          response.data.urlToMock = process.env.VUE_APP_MOCK_SERVER_HOST_URL + '/n/' + response.data.id
          await settingsMockServerModule.actions.refreshSingleNSpace({nSpace: response.data as NSpace});
        },
        undefined,
        () => {
          this.loadCreateNSettingsIndicator = false;
          settingsMockServerModule.mutations.clearTemplateNSettings()
        }
    )
  }
}
</script>

<style lang="scss">
.method-input {
  text-transform: uppercase;
}
</style>