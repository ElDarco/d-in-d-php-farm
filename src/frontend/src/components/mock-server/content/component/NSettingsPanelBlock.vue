<template>
  <div>
    <panel-block type="middle" title="NSettings" :list-row='getListRow' @clicked-to-row="clickByRow">
      <button class="button is-fullwidth" @click="clickOnCreate">
        <span class="icon">
          <i class="fas fa-plus"></i>
        </span>
        <span>Add NSettings</span>
      </button>
    </panel-block>
    <spinner-component :visible="loadNSettingsIndicator"/>
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
export default class NSettingsPanelBlock extends Vue {
  protected mockServerApi = new MockServerApi();
  protected loadNSettingsIndicator = false;
  get getListRow() {
    const listRow = [] as RowPanelBlockObject[];
    settingsMockServerModule.state.nSettings.forEach((element) => {
      listRow.push({
        "id": element.id,
        "type": 'nsettings',
        "prefix": element.method,
        "title": element.uri
      } as RowPanelBlockObject)
    })
    return listRow;
  }
  clickByRow(row: RowPanelBlockObject) {
    const nRequest = settingsMockServerModule.getters.getNRequestByID(row.id)
    if (this.isNRequest(nRequest)) {
      settingsMockServerModule.mutations.useNRequest(nRequest)
    }
  }
  clickOnCreate() {
    settingsMockServerModule.mutations.useCreateNSettings();
  }
  /* eslint-disable */
  isNSettings(arg: any): arg is NSettings {
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
.modal-card-medium {
  width: 50%;
}
</style>