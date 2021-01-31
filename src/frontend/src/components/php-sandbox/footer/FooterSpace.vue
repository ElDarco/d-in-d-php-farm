<template>
  <footer class="footer">
    <div class="content has-text-centered">
      <p>
        Created with:
      </p>
      <div class="support-logos">
        <a href="https://bulma.io/">
          <img src="https://bulma.io/images/bulma-logo.png" alt="bulma">
        </a>
        <a href="https://microsoft.github.io/monaco-editor/">
          <img src="https://opensource.microsoft.com/assets/images/Microsoft_logo.svg" alt="monaco-editor">
        </a>
        <a href="https://github.com/GoogleChromeLabs/dark-mode-toggle">
          <img src="https://avatars.githubusercontent.com/u/31970254?s=200&v=4" alt="google-chrome-labs">
        </a>
        <a href="https://www.php.net/">
          <img src="https://www.php.net/images/logos/php-logo.svg" alt="php-net">
        </a>
      </div>
    </div>
  </footer>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
@Component
export default class FooterSpace extends Vue {
}
</script>

<style lang="scss">
.footer {
  position: fixed;
  bottom: 0;
  width: 100%;
}
.support-logos {
  height: 15px;
  & a {
    padding-left: 15px;
    & img {
      height: 15px;
    }
  }
}
</style>
