<template>
  <div class="pointer panel-block" :title="row.title">
    <span v-if="row.type === 'nspace'" class="panel-icon">
      <i class="fas fa-folder" aria-hidden="true"></i>
    </span>
    <span v-else-if="row.type === 'nrequest'" class="panel-icon">
      <i class="fas fa-level-down-alt" aria-hidden="true"></i>
    </span>
    <span v-else-if="row.type === 'nsetting'" class="panel-icon">
      <i class="fas fa-cog" aria-hidden="true"></i>
    </span>
    <span v-else class="panel-icon">
      <i class="far fa-question-circle" aria-hidden="true"></i>
    </span>
    <template v-if="row.prefix === 'PUT'">
      <p class="put-style">{{row.prefix}}</p><p class="t-o">{{row.title}}</p>
    </template>
    <template v-else-if="row.prefix === 'POST'">
      <p class="post-style">{{row.prefix}}</p><p class="t-o">{{row.title}}</p>
    </template>
    <template v-else-if="row.prefix === 'GET'">
      <p class="get-style">{{row.prefix}}</p><p class="t-o">{{row.title}}</p>
    </template>
    <template v-else-if="row.prefix === 'PATCH'">
      <p class="patch-style">{{row.prefix}}</p><p class="t-o">{{row.title}}</p>
    </template>
    <template v-else-if="row.prefix === 'DELETE'">
      <p class="delete-style">{{row.prefix}}</p><p class="t-o">{{row.title}}</p>
    </template>
    <template v-else>
      <p class="other-style">{{row.prefix}}</p><p class="t-o">{{row.title}}</p>
    </template>
    <button v-if="isDeleted" class="button is-small is-pulled-right" @click="onClickToDelete(row)">
      <span class="icon is-small">
        <i class="fas fa-trash-alt"></i>
      </span>
    </button>
  </div>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';
@Component
export default class RowPanelBlock extends Vue {
  @Prop({ default: {} as RowPanelBlockObject })
  protected row: RowPanelBlockObject | undefined;
  @Prop({default: false})
  protected isDeleted = false;

  onClickToDelete (row: RowPanelBlockObject) {
    this.$emit('clicked-to-delete', row)
  }
}
</script>

<style lang="scss">
@import "src/mystyles.scss";
.pointer {
  cursor: pointer;
}
.pointer:hover {
  border-bottom: 1px solid #ededed;
  background-color: whitesmoke;
}
.t-o {
  width: 100%;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.post-style {
  padding-right: 3px;
  color: $turquoise
}
.get-style {
  padding-right: 3px;
  color: $green
}
.put-style {
  padding-right: 3px;
  color: $yellow
}
.patch-style {
  padding-right: 3px;
  color: $purple
}
.delete-style {
  padding-right: 3px;
  color: $red
}
.other-style {
  padding-right: 3px;
  color: $cyan
}
</style>