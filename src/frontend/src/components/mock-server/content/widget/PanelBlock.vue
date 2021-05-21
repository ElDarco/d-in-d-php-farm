<template>
  <nav
    class="panel full-height-panel"
    v-bind:class="{ 'full-height-panel': type === 'full', 'middle-height-panel': type === 'middle' }"
  >
    <p class="panel-heading">
      {{ title }}
    </p>
    <div class="panel-block">
      <p class="control has-icons-left">
        <input class="input" type="text" placeholder="Search">
        <span class="icon is-left">
          <i class="fas fa-search" aria-hidden="true"></i>
        </span>
      </p>
    </div>
    <div
      v-if="listRow !== undefined"
      v-bind:class="{ 'full-scrollable-body': type === 'full', 'middle-scrollable-body': type === 'middle' }"
    >
      <div v-for="(row, index) in listRow" :key="index" @click="onClickToRow(row)">
        <row-panel-block :row='row' />
      </div>
    </div>
    <div class="panel-block">
      <slot></slot>
    </div>
  </nav>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';
import RowPanelBlock from "@/components/mock-server/content/widget/RowPanelBlock.vue";
@Component({
  components: {
    RowPanelBlock
  }
})
export default class PanelBlock extends Vue {
  @Prop({ default: 'NSpace' })
  protected title: string | undefined;
  @Prop({ default: 'middle' })
  protected type: string | undefined;
  @Prop()
  protected listRow: RowPanelBlockObject[] | undefined;

  onClickToRow (row: RowPanelBlockObject) {
    this.$emit('clicked-to-row', row)
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