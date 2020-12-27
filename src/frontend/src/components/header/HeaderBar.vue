<template>
  <div class="header-bar">
    <nav class="navbar is-fixed-top" role="navigation" aria-label="main navigation">
      <div class="navbar-brand">
        <a class="navbar-item" href="https://bulma.io">
          <img src="../../assets/logo.svg">
        </a>

        <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
          <span aria-hidden="true"></span>
          <span aria-hidden="true"></span>
          <span aria-hidden="true"></span>
        </a>
      </div>

      <div id="navbarBasicExample" class="navbar-menu">
        <div class="navbar-start">
          <div class="navbar-item has-dropdown is-hoverable">
            <a class="navbar-link" style="width: 120px">
              <img src="../../assets/planform_logos/php.svg"> PHP
            </a>

            <div class="navbar-dropdown">
              <a class="navbar-item is-active">
                <img src="../../assets/planform_logos/php.svg"> PHP
              </a>
              <hr class="navbar-divider">
              <a class="navbar-item is-disabled">
                <span class="badge is-warning">Coming soon</span>
                <img src="../../assets/planform_logos/python.svg">
                <span
                    class="has-tooltip-arrow has-tooltip-right has-tooltip-info"
                    data-tooltip="Coming in next update">PYTHON
                </span>
              </a>
              <a class="navbar-item is-disabled">
                <span class="badge is-warning">Coming soon</span>
                <img src="../../assets/planform_logos/go.svg">
                <span
                    class="has-tooltip-arrow has-tooltip-right has-tooltip-info"
                    data-tooltip="Coming in next update">GO
                </span>
              </a>
            </div>
          </div>
          <div class="navbar-item has-dropdown is-hoverable">
            <a class="navbar-link">7.3</a>
            <div class="navbar-dropdown">
              <a class="navbar-item is-active">7.3</a>
              <a class="navbar-item">7.2</a>
              <a class="navbar-item">7.1</a>
              <a class="navbar-item">7.0</a>
            </div>
          </div>
          <div class="navbar-item">
            <div class="buttons">
              <a class="button is-info">
                <strong>RUN</strong>
                <span class="icon is-small">
                  <i class="fas fa-play"></i>
                </span>
              </a>
            </div>
          </div>
          <div class="navbar-item is-disabled">
            <span class="has-tooltip-bottom has-tooltip-info"
              data-tooltip="(Ctrl/Alt + Enter or Ctrl + S)">
              <i class="fas fa-question-circle"></i>
            </span>
          </div>
        </div>

        <div class="navbar-end">
          <div class="navbar-item">
            <div class="buttons">
              <a class="button is-info is-outlined">
                <span class="icon is-small">
                  <i class="fas fa-adjust"></i>
                </span>
              </a>
              <a class="button is-info is-outlined">
                <span class="icon is-small">
                  <i class="fas fa-cogs"></i>
                </span>
              </a>
              <a class="button is-info">
                <strong>Sign up</strong>
              </a>
              <a class="button is-light">
                Log in
              </a>
            </div>
          </div>
        </div>
      </div>
    </nav>
  </div>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';

@Component
export default class HeaderBar extends Vue {}
</script>

<style scoped lang="scss">
.header-bar {
  & .navbar {
    box-shadow: 0 0 10px rgba(0,0,0,0.5);
    & .navbar-item {
      & .badge {
        height: 16px;
      }
      & .is-disabled {
        cursor: default;
        pointer-events: all !important;
        & span {
          cursor: default;
          pointer-events: all !important;
        }
      }
      & span[data-tooltip] {
        border-bottom: 0;
        &:before {
          margin-bottom: -10px;
        }
        &:after {
          margin-bottom: -10px;
        }
      }
    }
  }
}
</style>
