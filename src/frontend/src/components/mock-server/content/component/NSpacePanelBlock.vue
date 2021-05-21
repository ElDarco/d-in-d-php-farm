<template>
  <div>
    <panel-block type="full" title="NSpace" :list-row='getListRow' @clicked-to-row="clickByRow">
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
import Cookies from 'js-cookie'
import {MockServerApi} from "@/providers/mock-server-api";
import SpinnerComponent from "@/components/SpinnerComponent.vue";
@Component({
  components: {
    SpinnerComponent,
    PanelBlock
  }
})
export default class NSpacePanelBlock extends Vue {
  protected mockServerApi = new MockServerApi();

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
    console.log(this.isNSpace(nSpace));
    if (this.isNSpace(nSpace)) {
      settingsMockServerModule.mutations.useNSpace(nSpace)
    }
  }
  isNSpace(arg: any): arg is NSpace {
    return arg && arg.id && typeof(arg.id) == 'string';
  }
  addNewNSpace() {
    this.loadNSpacesIndicator = true;
    this.mockServerApi.createNSpace()
      .then((response) => {
        settingsMockServerModule.mutations.addNSpace(response.data as NSpace);
        Cookies.set('nspaces', settingsMockServerModule.state.nSpaces)
      })
      .finally(() => {
        this.loadNSpacesIndicator = false;
      });
  }
  mounted() {
    const rawNSpace = JSON.parse(Cookies.get('nspaces') ?? '[]') as NSpace[];
    rawNSpace.forEach((element) => {
      settingsMockServerModule.mutations.addNSpace(element);
    })
  }
}
</script>

<style lang="scss">
.full-height-panel {
  min-height: 100%;
}
.middle-height-panel {
  min-height: 48.8%;
}
.full-scrollable-body {
  overflow-y: auto;
  overflow-x: hidden;
  height: 825px;
  max-height: 825px;
}
.middle-scrollable-body {
  overflow-y: auto;
  overflow-x: hidden;
  height: 313px;
  max-height: 313px;
}
</style>