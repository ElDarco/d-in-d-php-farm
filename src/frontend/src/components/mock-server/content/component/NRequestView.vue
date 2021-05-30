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
    <hr>
    <div class="box mb-3" v-if="this.getSelectedNRequest.proxyResponse.responseCode">
      <p class="is-size-5"><b>NProxyResponse</b></p>
      <hr>
      <p class="is-size-6"><b>ResponseCode:</b> {{ this.getSelectedNRequest.proxyResponse.responseCode }}</p>
      <p class="is-size-6"><b>ResponseBody:</b> {{ this.getSelectedNRequest.proxyResponse.responseBody }}</p>
      <p class="is-size-6"><b>Headers:</b> {{ this.getSelectedNRequest.proxyResponse.headers }}</p>
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

  get getSelectedNRequest(): NRequest {
    this.selectedNRequest = settingsMockServerModule.getters.getSelectedNRequest();
    return this.selectedNRequest;
  }
}
</script>

<style lang="scss">
</style>