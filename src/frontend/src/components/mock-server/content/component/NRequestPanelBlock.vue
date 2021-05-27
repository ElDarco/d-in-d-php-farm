<template>
  <div>
    <spinner-component :visible="loadNRequestIndicator"/>
    <panel-block type="middle" title="NRequest" :selected="getSelectedNRequest" :list-row='getListRow' @clicked-to-row="clickByRow">
      <button class="button is-fullwidth" @click="refresh">
        <span class="icon">
          <i class="fas fa-sync-alt"></i>
        </span>
        <span>
          Refresh
        </span>
      </button>
    </panel-block>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import PanelBlock from "@/components/mock-server/content/widget/PanelBlock.vue";
import {settingsMockServerModule} from "@/store/settings-mock-server";
import {MockServerApi} from "@/providers/clients/mock-server-api";
import SpinnerComponent from "@/components/SpinnerComponent.vue";
@Component({
  components: {
    SpinnerComponent,
    PanelBlock
  }
})
export default class NRequestPanelBlock extends Vue {
  protected mockServerApi = new MockServerApi();
  protected loadNRequestIndicator = false;

  get getListRow() {
    const listRow = [] as RowPanelBlockObject[];
    settingsMockServerModule.state.nRequests.forEach((element) => {
      let queryString = '';
      if (element.queryString != '') {
        queryString = '?' + element.queryString;
      }
      listRow.push({
        "id": element.id,
        "type": 'nrequest',
        "prefix": element.method,
        "title": element.uri + queryString
      } as RowPanelBlockObject)
    })
    return listRow;
  }
  async refresh() {
    const currentNSpace = settingsMockServerModule.state.selectedNSpace;
    if (this.isNSpace(currentNSpace)) {
      this.loadNRequestIndicator = true;
      await settingsMockServerModule.actions.refreshSingleNSpace({
        'nSpace' : currentNSpace,
        'doneCallback': () => {
          this.loadNRequestIndicator = false;
        }
      });
    }
  }
  clickByRow(row: RowPanelBlockObject) {
    const nRequest = settingsMockServerModule.getters.getNRequestByID(row.id)
    if (this.isNRequest(nRequest)) {
      settingsMockServerModule.mutations.useNRequest(nRequest)
    }
  }
  get getSelectedNRequest(): NRequest {
    this.selectedNRequest = settingsMockServerModule.getters.getSelectedNRequest();
    return this.selectedNRequest;
  }
  /* eslint-disable */
  isNRequest(arg: any): arg is NRequest {
    return arg && arg.id && typeof(arg.id) == 'string';
  }
  /* eslint-enable */

  /* eslint-disable */
  isNSpace(arg: any): arg is NSpace {
    return arg && arg.id && typeof(arg.id) == 'string';
  }
  /* eslint-enable */
}
</script>

<style lang="scss">
</style>