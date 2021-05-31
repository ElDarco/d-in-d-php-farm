<template>
  <div>
    <div class="columns">
      <div class="column">
        <div class="field">
          <label class="label">Method</label>
          <div class="control">
            <input class="input method-input" :class="{'is-danger': nSettingsMethodFailure}" v-model="nSettingsMethod" type="text" placeholder="Method for mock">
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
    <div class="field">
      <label class="label">Headers (coming soon)</label>
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
      </div>
    </div>
    <hr>
      <div class="field">
        <label class="label">Syntax</label>
        <div class="control">
          <div class="select">
            <select @change="setNSettingsEditorLang">
              <option>json</option>
              <option>xml</option>
              <option>html</option>
            </select>
          </div>
        </div>
      </div>
      <div class="field">
        <label class="label">Response body</label>
      </div>
      <div>
        <monaco-editor :style="styleEditorHeight" v-model="nSettingsResponseBody" :language="getNSettingsEditorLang"></monaco-editor>
      </div>
    <slot></slot>
  </div>
</template>

<script lang="ts">
import {Component, Prop, Vue} from 'vue-property-decorator';
import {settingsMockServerModule} from "@/store/settings-mock-server";
import MonacoEditor from 'vue-monaco'

@Component({
  components: {
    MonacoEditor
  }
})
export default class NSettingsEditor extends Vue {
  @Prop({})
  protected nSettings: NSettings | undefined;

  mounted() {
    this.initNSettings()
  }

  updated() {
    this.initNSettings()
  }

  initNSettings() {
    if (this.nSettings !== undefined) {
      this.nSettingsResponseBody = this.nSettings.responseBody;
      this.nSettingsMethod = this.nSettings.method;
      this.nSettingsUri = this.nSettings.uri;
      this.nSettingsQueryString = this.nSettings.queryString;
      this.nSettingsStatusCode = this.nSettings.responseCode;
    }
  }

  public nSettingsEditorLang = '';

  private styleEditorHeight = "height: " + (document.documentElement.clientHeight-160)/10*2 + "px;";

  protected nSettingsResponseBody = '';

  protected nSettingsMethod = '';
  protected nSettingsMethodFailure = false;

  protected nSettingsUri = '';
  protected nSettingsUriFailure = false;

  protected nSettingsQueryString = '';
  protected nSettingsQueryStringFailure = false;

  protected nSettingsStatusCode = 200;
  protected nSettingsStatusCodeFailure = false;

  setNSettingsEditorLang(event: Event): void {
    const target = event.target as HTMLInputElement;
    settingsMockServerModule.mutations.switchNSettingsEditorToLang(target.value);
  }

  get getNSettingsEditorLang(): string {
    this.nSettingsEditorLang = settingsMockServerModule.getters.getNSettingsEditorLand();
    return this.nSettingsEditorLang;
  }

  public getNSettingsStatusCode(): number {
    return this.nSettingsStatusCode
  }
  public getNSettingsMethod(): string {
    return this.nSettingsMethod
  }
  public getNSettingsQueryString(): string {
    return this.nSettingsQueryString
  }
  public getNSettingsUri(): string {
    return this.nSettingsUri
  }
  public getNSettingsResponseBody(): string {
    return this.nSettingsResponseBody
  }
}
</script>

<style lang="scss">
.method-input {
  text-transform: uppercase;
}
</style>