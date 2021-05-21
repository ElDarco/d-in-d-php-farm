<template>
  <mock-server-layout>
    <header-bar/>
    <div class="container environment is-hidden-touch is-fluid">
      <div class="columns">
        <div class="column is-one-fifth">
          <n-space-panel-block/>
        </div>
        <div class="column is-one-fifth">
          <nav class="panel middle-height-panel">
            <p class="panel-heading">
              NRequests
            </p>
            <div class="panel-block">
              <p class="control has-icons-left">
                <input class="input" type="text" placeholder="Search">
                <span class="icon is-left">
              <i class="fas fa-search" aria-hidden="true"></i>
            </span>
              </p>
            </div>
            <!--<p class="panel-tabs">
              <a class="is-active">All</a>
              <a>Public</a>
              <a>Private</a>
              <a>Sources</a>
              <a>Forks</a>
            </p>-->
            <div class="middle-scrollable-body">
              <a class="panel-block">
                <span class="panel-icon">
                  <i class="fas fa-level-down-alt" aria-hidden="true"></i>
                </span>
                <p class="post-style">POST</p><p class="t-o">/v1.3/fines/123</p>
              </a>
              <a class="panel-block">
                <span class="panel-icon">
                  <i class="fas fa-level-down-alt" aria-hidden="true"></i>
                </span>
                <p class="get-style">GET</p><p class="t-o">/v1.3/fines</p>
              </a>
              <a class="panel-block">
                <span class="panel-icon">
                  <i class="fas fa-level-down-alt" aria-hidden="true"></i>
                </span>
                <p class="put-style">PUT</p><p class="t-o">/v1.3/fines/123</p>
              </a>
              <a class="panel-block">
                <span class="panel-icon">
                  <i class="fas fa-level-down-alt" aria-hidden="true"></i>
                </span>
                <p class="patch-style">PATCH</p><p class="t-o">/v1.3/fines/123</p>
              </a>
              <a class="panel-block">
                <span class="panel-icon">
                  <i class="fas fa-level-down-alt" aria-hidden="true"></i>
                </span>
                <p class="delete-style">DELETE</p><p class="t-o">/v1.3/fines/123</p>
              </a>
              <a class="panel-block">
                <span class="panel-icon">
                  <i class="fas fa-level-down-alt" aria-hidden="true"></i>
                </span>
                <p class="other-style">OTHER</p><p class="t-o">/v1.3/fines/any</p>
              </a>
            </div>
          </nav>
          <nav class="panel middle-height-panel">
            <p class="panel-heading">
              NSettings
            </p>
            <div class="panel-block">
              <p class="control has-icons-left">
                <input class="input" type="text" placeholder="Search">
                <span class="icon is-left">
              <i class="fas fa-search" aria-hidden="true"></i>
            </span>
              </p>
            </div>
            <!--<p class="panel-tabs">
              <a class="is-active">All</a>
              <a>Public</a>
              <a>Private</a>
              <a>Sources</a>
              <a>Forks</a>
            </p>-->
            <div class="middle-scrollable-body">
              <row-panel-block type="nsetting" :row='{"type": "POST", "title": "/v1.3/fines/123"}'/>
              <row-panel-block type="nsetting" :row='{"type": "GET", "title": "/v1.3/fines/123"}'/>
              <row-panel-block type="nsetting" :row='{"type": "PUT", "title": "/v1.3/fines/123"}'/>
              <row-panel-block type="nsetting" :row='{"type": "PATCH", "title": "/v1.3/fines/123"}'/>
              <row-panel-block type="nsetting" :row='{"type": "DELETE", "title": "/v1.3/fines/123"}'/>
              <row-panel-block type="nsetting" :row='{"type": "OPTIONS", "title": "/v1.3/fines/123"}'/>
              <row-panel-block type="nsetting" :row='{"type": "UPDATE", "title": "/v1.3/fines/123"}'/>
            </div>
            <div class="panel-block">
              <button class="button is-link is-outlined is-fullwidth">
                Add NSetting
              </button>
            </div>
          </nav>
        </div>
        <div class="column is-two-thirds">
          <div class="box">
            <template v-if="getSelectedEntityType === 'nspace'">
              <p>NSpace</p>
              <p>{{this.getSelectedNSpace.id}}</p>
              <p>{{this.getSelectedNSpace.name}}</p>
            </template>
            <template v-else>
              Third column
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

@Component({
  components: {
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
  get getSelectedNSpace(): NSpace {
    return settingsMockServerModule.getters.getSelectedNSpaces();
  }
}
</script>
<style lang="scss">
.environment {
  padding-top: 20px;
  padding-bottom: 20px;
  min-height: 100%;
  overflow-y: auto;
}
.column.is-one-fifth, .column.is-one-fifth-tablet {
  flex: none;
  width: 15%;
}
.column.is-two-thirds, .column.is-two-thirds-tablet {
  flex: none;
  width: 70%;
}
</style>