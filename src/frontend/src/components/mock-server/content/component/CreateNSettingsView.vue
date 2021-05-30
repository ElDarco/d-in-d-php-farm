<template>
  <div>
    <spinner-component :visible="loadCreateNSettingsIndicator"/>
    <p class="is-size-5"><b>Create NSettings</b></p>
    <hr>
    <div class="columns">
      <div class="column">
        <div class="field">
          <label class="label">Method</label>
          <div class="control">
            <input class="input" :class="{'is-danger': nSettingsMethodFailure}" v-model="nSettingsMethod" type="text" placeholder="Method for mock">
          </div>
        </div>
        <div class="field">
          <label class="label">Uri (with first slash)</label>
          <div class="control">
            <input class="input" :class="{'is-danger': nSettingsUriFailure}" v-model="nSettingsUri" type="text" placeholder="Uri for mock">
          </div>
        </div>
      </div>
      <div class="column">
        <div class="field">
          <label class="label">Query string (without first char ?)</label>
          <div class="control">
            <input class="input" :class="{'is-danger': nSettingsQueryStringFailure}" v-model="nSettingsQueryString" type="text" placeholder="Query string">
          </div>
        </div>
      </div>
    </div>
    <hr>
    <div class="columns">
      <div class="column">
        <div class="field">
          <label class="label">Return status code</label>
          <div class="control">
            <input class="input" :class="{'is-danger': nSettingsStatusCodeFailure}" v-model="nSettingsStatusCode" type="text" placeholder="Status code for return">
          </div>
        </div>
      </div>
      <div class="column">
        <div class="field">
          <label class="label">Headers (coming soon)</label>
        </div>
      </div>
    </div>
    <hr>
      <div class="field">
        <label class="label">Response body</label>
      </div>
      <div>
        <monaco-editor :style="styleEditorHeight" v-model="nSettingsResponseBody" :language="getNSettingsEditorLand"></monaco-editor>
      </div>
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
  </div>
</template>

<script lang="ts">
import {Component, Vue} from 'vue-property-decorator';
import {settingsMockServerModule} from "@/store/settings-mock-server";
import SpinnerComponent from "@/components/SpinnerComponent.vue";
import {MockServerProvider} from "@/providers/gateway/mock-server-provider";
import {AxiosResponse} from "axios";
import MonacoEditor from 'vue-monaco'

@Component({
  components: {
    SpinnerComponent,
    MonacoEditor
  }
})
export default class CreateNSettingsView extends Vue {
  protected mockServerProvider = new MockServerProvider();
  protected loadCreateNSettingsIndicator = false;
  protected nSettingsEditorLand = 'json';

  private styleEditorHeight = "height: " + (document.documentElement.clientHeight-160)/10*4 + "px;";

  protected nSettingsResponseBody = '';

  protected nSettingsMethod = '';
  protected nSettingsMethodFailure = false;

  protected nSettingsUri = '';
  protected nSettingsUriFailure = false;

  protected nSettingsQueryString = '';
  protected nSettingsQueryStringFailure = false;

  protected nSettingsStatusCode = '200';
  protected nSettingsStatusCodeFailure = false;


  get getNSettingsEditorLand(): string {
    this.nSettingsEditorLand = settingsMockServerModule.getters.getNSettingsEditorLand();
    return this.nSettingsEditorLand;
  }

  addNewNSettings() {
    const selectedNSpace = settingsMockServerModule.getters.getSelectedNSpace();
    this.loadCreateNSettingsIndicator = true;
    this.mockServerProvider.createNSettings(
        selectedNSpace,
        this.nSettingsResponseBody,
        this.nSettingsUri,
        this.nSettingsMethod,
        this.nSettingsStatusCode,
        this.nSettingsQueryString,
        async (response: AxiosResponse) => {
          response.data.urlToMock = process.env.VUE_APP_MOCK_SERVER_HOST_URL + '/n/' + response.data.id
          settingsMockServerModule.mutations.addNSpace(response.data as NSpace)
          await settingsMockServerModule.actions.persistNSpaceToCache();
          settingsMockServerModule.mutations.useNSpace(response.data as NSpace)
        },
        undefined,
        () => {
          this.loadCreateNSettingsIndicator = false;
        }
    )
  }
}
</script>

<style lang="scss">
</style>