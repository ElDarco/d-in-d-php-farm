<template>
  <div>
    <p class="is-size-5"><b>NSpace</b></p>
    <hr>
    <p class="is-size-6"><b>UUID:</b> {{ this.getSelectedNSpace.id }}</p>
    <p v-if="this.getSelectedNSpace.urlToMock" @click="copyTextToBuffer(getSelectedNSpace.urlToMock)"
       class="is-size-6 is-spaced is-clickable">
      <b>URL:</b> {{ this.getSelectedNSpace.urlToMock }}
      <span class="icon has-text-info"><i class="fas fa-copy"></i></span> <span v-if="copied">(copied)</span>
    </p>
    <hr>
    <div class="columns">
      <div class="column">
        <div class="field">
          <label class="label">Name</label>
          <div class="control">
            <input class="input" v-model="nSpaceName" type="text" placeholder="Some name for NSpace">
          </div>
        </div>
        <div class="field">
          <label class="label">Url to proxy</label>
          <div class="control">
            <input class="input" type="text" placeholder="https://to-proxy.url">
          </div>
        </div>
        <div class="field">
          <div class="control">
            <label class="checkbox">
              <input type="checkbox">
              Enable proxy
            </label>
          </div>
        </div>
      </div>
      <div class="column"></div>
    </div>
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
  </div>
</template>

<script lang="ts">
import {Component, Vue} from 'vue-property-decorator';
import {settingsMockServerModule} from "@/store/settings-mock-server";
import {MockServerApi} from "@/providers/clients/mock-server-api";
import SpinnerComponent from "@/components/SpinnerComponent.vue";

@Component({
  components: {
    SpinnerComponent
  }
})
export default class NSpaceView extends Vue {
  protected mockServerApi = new MockServerApi();

  protected selectedNSpace: NSpace | undefined;
  protected copied = false;
  protected nSpaceName = '';

  get getSelectedNSpace(): NSpace {
    this.selectedNSpace = settingsMockServerModule.getters.getSelectedNSpace();
    this.nSpaceName = this.selectedNSpace.name;
    return this.selectedNSpace;
  }

  copyTextToBuffer (text) {
    this.copied = true;
    setTimeout(() => {
      this.copied = false;
    }, 2000);
    const tmp = document.createElement('INPUT') // Создаём новый текстовой input
    const focus = document.activeElement // Получаем ссылку на элемент в фокусе (чтобы не терять фокус)

    tmp.value = text // Временному input вставляем текст для копирования

    document.body.appendChild(tmp) // Вставляем input в DOM
    tmp.select() // Выделяем весь текст в input
    document.execCommand('copy') // Магия! Копирует в буфер выделенный текст (см. команду выше)
    document.body.removeChild(tmp) // Удаляем временный input
    focus.focus() // Возвращаем фокус туда, где был
  }
}
</script>

<style lang="scss">
</style>