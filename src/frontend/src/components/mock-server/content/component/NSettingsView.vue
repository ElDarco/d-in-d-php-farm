<template>
  <div>
    <p class="is-size-5"><b>NSettings</b></p>
    <hr>
    <n-settings-editor ref="n-settings-editor" :n-settings="getCurrentNSettings">
      <hr>
      <div class="columns">
        <div class="column">
          <button class="button">
          <span class="icon">
            <i class="fas fa-save"></i>
          </span>
            <span>Save</span>
          </button>
        </div>
        <div class="column"></div>
      </div>
    </n-settings-editor>
  </div>
</template>

<script lang="ts">
import {Component, Vue} from 'vue-property-decorator';
import SpinnerComponent from "@/components/SpinnerComponent.vue";
import NSettingsEditor from "@/components/mock-server/content/widget/NSettingsEditor.vue";
import {settingsMockServerModule} from "@/store/settings-mock-server";

@Component({
  components: {
    NSettingsEditor,
    SpinnerComponent
  }
})
export default class NSettingsView extends Vue {
  protected currentNSettings: NSettings | undefined


  get getCurrentNSettings(): NSettings {
    this.currentNSettings = settingsMockServerModule.getters.getSelectedNSettings();
    return this.currentNSettings;
  }
}
</script>

<style lang="scss">
</style>