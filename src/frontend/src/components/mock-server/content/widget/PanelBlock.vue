<template>
  <nav
    class="panel"
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
        <row-panel-block v-if="getWhoIsActive(row)" :is-active='true' :row='row' @clicked-to-delete="onClickToDelete(row)"/>
        <row-panel-block v-else :is-active='false' :row='row' @clicked-to-delete="onClickToDelete(row)"/>
      </div>
    </div>
    <div class="panel-block panel-buttons">
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
  @Prop({ default: undefined })
  protected selected: NObject | undefined;
  @Prop()
  protected listRow: RowPanelBlockObject[] | undefined;

  onClickToRow (row: RowPanelBlockObject) {
    this.$emit('clicked-to-row', row)
  }
  onClickToDelete (row: RowPanelBlockObject) {
    this.$emit('clicked-to-delete', row)
  }
  getWhoIsActive(row: RowPanelBlockObject) {
    return (this.isNObject(this.selected)) && (row.id === this.selected.id)
  }
  /* eslint-disable */
  isNObject(arg: any): arg is NObject {
    return arg && arg.id && typeof(arg.id) == 'string';
  }
  /* eslint-enable */
}
</script>

<style lang="scss">
.full-height-panel {
  min-height: 100%;
}
.middle-height-panel {
  min-height: 50%;
  margin-bottom: 20px;
}
.full-scrollable-body {
  overflow-y: auto;
  overflow-x: hidden;
  height: 718px;
  max-height: 718px;
}
.middle-scrollable-body {
  overflow-y: auto;
  overflow-x: hidden;
  height: 289px;
  max-height: 289px;
}
.panel-buttons {
  flex-wrap: wrap;
}
</style>