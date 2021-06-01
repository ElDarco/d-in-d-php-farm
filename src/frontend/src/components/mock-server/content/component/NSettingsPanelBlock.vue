<template>
  <div>
    <panel-block
      type="middle"
      title="NSettings"
      :selected="getSelectedNSettings"
      :list-row='getListRow'
      @clicked-to-row="clickByRow"
    >
      <div class="buttons is-fullwidth">
        <button class="button is-fullwidth" @click="clickOnCreate" :disabled="getSelectedNSpace === undefined">
          <span class="icon">
            <i class="fas fa-plus"></i>
          </span>
          <span>Add NSettings</span>
        </button>
        <button class="button is-fullwidth" @click="clickOnClear" :disabled="getSelectedNSpace === undefined">
          <span class="icon">
            <i class="fas fa-trash"></i>
          </span>
          <span>Clear NSettings</span>
        </button>
      </div>
    </panel-block>
    <spinner-component :visible="loadNSettingsIndicator"/>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import PanelBlock from "@/components/mock-server/content/widget/PanelBlock.vue";
import {settingsMockServerModule} from "@/store/settings-mock-server";
import SpinnerComponent from "@/components/SpinnerComponent.vue";
import {MockServerProvider} from "@/providers/gateway/mock-server-provider";
import {AxiosResponse} from "axios";
@Component({
  components: {
    SpinnerComponent,
    PanelBlock
  }
})
export default class NSettingsPanelBlock extends Vue {
  protected mockServerProvider = new MockServerProvider();
  protected loadNSettingsIndicator = false;
  protected selectedNSpace: NSpace | undefined;
  protected selectedNSettings: NSettings | undefined;
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
    const nSettings = settingsMockServerModule.getters.getNSettingsByID(row.id)
    if (this.isNSettings(nSettings)) {
      settingsMockServerModule.mutations.useNSettings(nSettings)
    }
  }
  get getSelectedNSpace(): NSpace {
    this.selectedNSpace = settingsMockServerModule.getters.getSelectedNSpace();
    return this.selectedNSpace;
  }
  get getSelectedNSettings(): NSettings {
    this.selectedNSettings = settingsMockServerModule.getters.getSelectedNSettings();
    return this.selectedNSettings;
  }
  async clickOnCreate() {
    await settingsMockServerModule.mutations.clearTemplateNSettings();
    settingsMockServerModule.mutations.clearSelectedNSettings();
    settingsMockServerModule.mutations.clearSelectedEntityType();
    settingsMockServerModule.mutations.useCreateNSettings();
  }
  clickOnClear() {
    if (this.selectedNSpace !== undefined) {
      this.loadNSettingsIndicator = true;
      this.mockServerProvider.clearNSettings(
          this.selectedNSpace,
          async (response: AxiosResponse) => {
            response.data.urlToMock = process.env.VUE_APP_MOCK_SERVER_HOST_URL + '/n/' + response.data.id
            await settingsMockServerModule.actions.refreshSingleNSpace({nSpace: this.selectedNSpace});
          },
          undefined,
          () => {
            this.loadNSettingsIndicator = false;
          }
      )
    }
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