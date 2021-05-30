<template>
  <div>
    <panel-block
        type="full"
        title="NSpace"
        :list-row='getListRow'
        :selected='getSelectedNSpace'
        @clicked-to-row="clickByRow"
        @clicked-to-delete="clickByDelete"
    >
      <div class="buttons is-fullwidth">
        <button class="button is-fullwidth" @click="refresh">
          <span class="icon">
            <i class="fas fa-sync-alt"></i>
          </span>
          <span>
            Refresh
          </span>
        </button>
        <button class="button is-fullwidth" @click="clickOnCreate">
          <span class="icon">
            <i class="fas fa-plus"></i>
          </span>
          <span>Get new NSpace</span>
        </button>
      </div>
    </panel-block>
    <spinner-component :visible="loadNSpacesIndicator"/>
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
export default class NSpacePanelBlock extends Vue {
  protected mockServerProvider = new MockServerProvider();

  protected loadNSpacesIndicator = false;
  protected selectedNSpace: NSpace | undefined;

  get getSelectedNSpace(): NSpace {
    this.selectedNSpace = settingsMockServerModule.getters.getSelectedNSpace();
    return this.selectedNSpace;
  }
  get getListRow() {
    const listRow = [] as RowPanelBlockObject[];
    settingsMockServerModule.state.nSpaces.forEach((element) => {
      listRow.push({
        "id": element.id,
        "type": 'nspace',
        "prefix": '',
        "title": element.name
      } as RowPanelBlockObject)
    })
    return listRow;
  }
  clickByRow(row: RowPanelBlockObject) {
    const nSpace = settingsMockServerModule.getters.getNSpaceByID(row.id)
    if (this.isNSpace(nSpace)) {
      settingsMockServerModule.mutations.useNSpace(nSpace)
    }
  }
  clickByDelete(row: RowPanelBlockObject) {
    const nSpace = settingsMockServerModule.getters.getNSpaceByID(row.id)
    if (this.isNSpace(nSpace)) {
      console.log('delete ' + nSpace.id)
    }
  }
  clickOnCreate() {
    settingsMockServerModule.mutations.useCreateNSpace();
  }
  /* eslint-disable */
  isNSpace(arg: any): arg is NSpace {
    return arg && arg.id && typeof(arg.id) == 'string';
  }
  /* eslint-enable */
  async refresh() {
    this.loadNSpacesIndicator = true;
    await settingsMockServerModule.actions.restoreNSpaceFromCache(() => {
      this.loadNSpacesIndicator = false
    });
  }
  mounted() {
    this.refresh()
  }
}
</script>

<style lang="scss">
.modal-card-small {
  width: 30%;
}
.buttons.is-fullwidth {
  width: 100%;
}
</style>