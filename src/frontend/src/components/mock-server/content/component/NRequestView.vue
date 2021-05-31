<template>
  <div>
    <p class="is-size-5"><b>NRequest</b></p>
    <hr>
    <p class="is-size-6"><b>UUID:</b> {{ this.getSelectedNRequest.id }}</p>
    <p class="is-size-6"><b>Method:</b> {{ this.getSelectedNRequest.method }}</p>
    <p class="is-size-6"><b>URI:</b> {{ this.getSelectedNRequest.uri }}</p>
    <p class="is-size-6"><b>Query String:</b> {{ this.getSelectedNRequest.queryString }}</p>
    <p class="is-size-6"><b>Body:</b> {{ this.getSelectedNRequest.body }}</p>
    <p class="is-size-6"><b>Created At:</b> {{ this.getSelectedNRequest.createdAt }}</p>
    <template v-if="this.getSelectedNRequest.proxyResponse.responseCode">
      <hr>
      <div class="box mb-3">
        <p class="is-size-5"><b>NProxyResponse</b></p>
        <hr>
        <p class="is-size-6"><b>ResponseCode:</b> {{ this.getSelectedNRequest.proxyResponse.responseCode }}</p>
        <p class="is-size-6"><b>ResponseBody:</b> {{ this.getSelectedNRequest.proxyResponse.responseBody }}</p>
        <p class="is-size-6"><b>Headers:</b> {{ this.getSelectedNRequest.proxyResponse.headers }}</p>
      </div>
    </template>
    <hr>
    <div class="columns">
      <div class="column">
        <button class="button" @click="frezzeToNSettings">
          <span class="icon">
            <i class="fas fa-snowflake"></i>
          </span>
          <span>Freeze to NSettings</span>
        </button>
      </div>
      <div class="column"></div>
    </div>
  </div>
</template>

<script lang="ts">
import {Component, Vue} from 'vue-property-decorator';
import {settingsMockServerModule} from "@/store/settings-mock-server";
import {MockServerApi} from "@/providers/clients/mock-server-api";
import SpinnerComponent from "@/components/SpinnerComponent.vue";

@Component({
  components: {
    SpinnerComponent
  }
})
export default class NRequestView extends Vue {
  protected mockServerApi = new MockServerApi();

  protected selectedNRequest: NRequest | undefined;

  frezzeToNSettings() {
    let responseBody = '';
    let responseCode = 200;
    if (this.isNObject(this.getSelectedNRequest.proxyResponse)) {
      responseBody = this.getSelectedNRequest.proxyResponse.responseBody
      responseCode = this.getSelectedNRequest.proxyResponse.responseCode
    }

    settingsMockServerModule.mutations.addTemplateNSettings({
      uri: this.getSelectedNRequest.uri,
      method: this.getSelectedNRequest.method,
      queryString: this.getSelectedNRequest.queryString,
      responseBody: responseBody,
      responseCode: responseCode
    } as NSettings)
    settingsMockServerModule.mutations.useCreateNSettings();
  }

  /* eslint-disable */
  isNObject(arg: any): arg is NObject {
    return arg && arg.id && typeof(arg.id) == 'string';
  }
  /* eslint-enable */
  get getSelectedNRequest(): NRequest {
    this.selectedNRequest = settingsMockServerModule.getters.getSelectedNRequest();
    return this.selectedNRequest;
  }
}
</script>

<style lang="scss">
</style>