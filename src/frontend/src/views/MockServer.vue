<template>
  <mock-server-layout>
    <header-bar/>
    <div class="container environment is-hidden-touch is-fluid">
      <div class="columns">
        <div class="column is-one-fifth">
          <n-space-panel-block/>
        </div>
        <div class="column is-one-fifth">
          <n-request-panel-block/>
          <n-settings-panel-block/>
        </div>
        <div class="column is-two-thirds">
          <div class="box full-height-panel full-scrollable-body without-bottom-margin">
            <template v-if="getSelectedEntityType === 'nspace'">
              <n-space-view/>
            </template>
            <template v-else-if="getSelectedEntityType === 'nrequest'">
              <n-request-view/>
            </template>
            <template v-else-if="getSelectedEntityType === 'nsettings'">
              <n-settings-view/>
            </template>
            <template v-else-if="getSelectedEntityType === 'createnspace'">
              <create-n-space-view/>
            </template>
            <template v-else-if="getSelectedEntityType === 'creatensettings'">
              <create-n-settings-view/>
            </template>
            <template v-else-if="getSelectedEntityType === 'creatensettingsfromtemplate'">
              <create-n-settings-from-template-view/>
            </template>
            <template v-else-if="getSelectedEntityType === 'whiteboard'"></template>
            <template v-else>
              Please, selected interesting section by left
            </template>
          </div>
        </div>
      </div>
    </div>
    <footer-space/>
  </mock-server-layout>
</template>

<script lang="ts">
import {Component, Vue} from 'vue-property-decorator';
import MockServerLayout from '@/layouts/MockServerLayout.vue';
import HeaderBar from "@/components/mock-server/header/HeaderBar.vue";
import RowPanelBlock from "@/components/mock-server/content/widget/RowPanelBlock.vue";
import FooterSpace from "@/components/mock-server/footer/FooterSpace.vue";
import PanelBlock from "@/components/mock-server/content/widget/PanelBlock.vue";
import NSpacePanelBlock from "@/components/mock-server/content/component/NSpacePanelBlock.vue";
import {settingsMockServerModule} from "@/store/settings-mock-server";
import NRequestPanelBlock from "@/components/mock-server/content/component/NRequestPanelBlock.vue";
import NSettingsPanelBlock from "@/components/mock-server/content/component/NSettingsPanelBlock.vue";
import NSpaceView from "@/components/mock-server/content/component/NSpaceView.vue";
import CreateNSpaceView from "@/components/mock-server/content/component/CreateNSpaceView.vue";
import CreateNSettingsView from "@/components/mock-server/content/component/CreateNSettingsView.vue";
import NRequestView from "@/components/mock-server/content/component/NRequestView.vue";
import NSettingsView from "@/components/mock-server/content/component/NSettingsView.vue";
import CreateNSettingsFromTemplateView
  from "@/components/mock-server/content/component/CreateNSettingsFromTemplateView.vue";

@Component({
  components: {
    CreateNSettingsFromTemplateView,
    NSettingsView,
    NRequestView,
    CreateNSettingsView,
    CreateNSpaceView,
    NSpaceView,
    NSettingsPanelBlock,
    NRequestPanelBlock,
    NSpacePanelBlock,
    PanelBlock,
    MockServerLayout,
    RowPanelBlock,
    HeaderBar,
    FooterSpace,
  },
})
export default class MockServer extends Vue {

  get getSelectedEntityType(): string {
    return settingsMockServerModule.getters.getSelectedEntityType();
  }
}
</script>
<style lang="scss">
.without-bottom-margin {
  margin-bottom: 0;
}
.environment {
  padding-top: 20px;
  padding-bottom: 20px;
  min-height: 100%;
  overflow-y: auto;
}
.column.is-one-fifth, .column.is-one-fifth-tablet {
  flex: none;
  width: 17%;
}
.column.is-two-thirds, .column.is-two-thirds-tablet {
  flex: none;
  width: 66%;
}
.box.full-scrollable-body {
  overflow-y: auto;
  overflow-x: hidden;
  height: 700px;
  max-height: 700px;
}
.box.full-height-panel {
  min-height: 98%;
  padding-bottom: 0;
}
</style>