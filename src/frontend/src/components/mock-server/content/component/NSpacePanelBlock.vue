<template>
  <div>
    <panel-block
        type="full"
        title="NSpace"
        :list-row='getListRow'
        @clicked-to-row="clickByRow"
        @clicked-to-delete="clickByDelete"
    >
      <button class="button is-link is-outlined is-fullwidth" @click="refresh">
        <span class="icon">
          <i class="fas fa-sync-alt"></i>
        </span>
        Refresh
      </button>
      <button class="button is-link is-outlined is-fullwidth" @click="addNewNSpace">
        Get new NSpace
      </button>
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
  /* eslint-disable */
  isNSpace(arg: any): arg is NSpace {
    return arg && arg.id && typeof(arg.id) == 'string';
  }
  /* eslint-enable */
  addNewNSpace() {
    this.loadNSpacesIndicator = true;
    this.mockServerProvider.createNewNSpace(
        async (response: AxiosResponse) => {
          settingsMockServerModule.mutations.addNSpace(response.data as NSpace)
          await settingsMockServerModule.actions.persistNSpaceToCache();
        },
        undefined,
        () => {
          this.loadNSpacesIndicator = false
        }
    )
  }
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
</style>