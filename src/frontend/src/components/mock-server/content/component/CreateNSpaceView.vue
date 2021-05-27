<template>
  <div>
    <spinner-component :visible="loadCreateNSpacesIndicator"/>
    <p class="is-size-5"><b>Create NSpace</b></p>
    <hr>
    <div class="columns">
      <div class="column">
        <div class="field">
          <label class="label">Name</label>
          <div class="control">
            <input
              class="input"
              v-model="nSpaceName"
              type="text"
              placeholder="Some name for NSpace"
            >
          </div>
        </div>
        <div class="field">
          <label class="label">Url to proxy</label>
          <div class="control">
            <input class="input" type="text" placeholder="https://to-proxy.url">
          </div>
        </div>
        <div class="field">
          <div class="control">
            <label class="checkbox">
              <input type="checkbox">
              Enable proxy
            </label>
          </div>
        </div>
      </div>
      <div class="column"></div>
    </div>
    <hr>
    <div class="columns">
      <div class="column">
        <button class="button" @click="addNewNSpace">
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

@Component({
  components: {
    SpinnerComponent
  }
})
export default class CreateNSpaceView extends Vue {
  protected mockServerProvider = new MockServerProvider();
  protected loadCreateNSpacesIndicator = false;
  protected nSpaceName = '';

  addNewNSpace() {
    this.loadCreateNSpacesIndicator = true;
    this.mockServerProvider.createNewNSpace(
        this.nSpaceName,
        async (response: AxiosResponse) => {
          response.data.urlToMock = process.env.VUE_APP_MOCK_SERVER_HOST_URL + '/n/' + response.data.id
          settingsMockServerModule.mutations.addNSpace(response.data as NSpace)
          await settingsMockServerModule.actions.persistNSpaceToCache();
          settingsMockServerModule.mutations.useNSpace(response.data as NSpace)
        },
        undefined,
        () => {
          this.loadCreateNSpacesIndicator = false;
        }
    )
  }
}
</script>

<style lang="scss">
</style>