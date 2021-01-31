<template>
  <div class="header-bar">
    <nav class="navbar is-fixed-top" role="navigation" aria-label="main navigation">
      <div class="navbar-brand">
        <a class="navbar-item" href="https://bulma.io">
          <img src="../../../assets/logo.svg">
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
              <img src="../../../assets/planform_logos/php.svg"> PHP
            </a>

            <div class="navbar-dropdown">
              <a class="navbar-item is-active">
                <img src="../../../assets/planform_logos/php.svg"> PHP
              </a>
              <hr class="navbar-divider">
              <a class="navbar-item is-disabled has-tooltip-arrow has-tooltip-right has-tooltip-info"
                 data-tooltip="Coming in next update">
                <span class="badge is-warning">Coming soon</span>
                <img src="../../../assets/planform_logos/mysql.svg">
                <span>MYSQL</span>
              </a>
              <a class="navbar-item is-disabled has-tooltip-arrow has-tooltip-right has-tooltip-info"
                 data-tooltip="Coming in next update">
                <span class="badge is-warning">Coming soon</span>
                <img src="../../../assets/planform_logos/python.svg">
                <span>PYTHON
                </span>
              </a>
              <a class="navbar-item is-disabled has-tooltip-arrow has-tooltip-right has-tooltip-info"
                 data-tooltip="Coming in next update">
                <span class="badge is-warning">Coming soon</span>
                <img src="../../../assets/planform_logos/go.svg">
                <span>GO</span>
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
              <a class="button is-info" @click="getInstanceList">
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
            <div class="buttons has-tooltip-bottom has-tooltip-info"
                 data-tooltip="Coming in next update">
              <a class="button is-info is-outlined" disabled>
                <span class="icon is-small">
                  <i class="fas fa-share"></i>
                </span>
              </a>
              <a class="button is-info is-outlined" disabled>
                <span class="icon is-small">
                  <i class="fas fa-adjust"></i>
                </span>
              </a>
              <a class="button is-info" disabled>
                <strong>Sign up</strong>
              </a>
              <a class="button is-light" disabled>
                Log in
              </a>
            </div>
          </div>
          <div
            class="navbar-item has-dropdown is-mega"
            :class="{'is-active': showSettingsBar}"
          >
            <div class="buttons">
              <a
                class="button is-info"
                :class="{'is-outlined': !showSettingsBar}"
                @click="showSettingsBar = !showSettingsBar"
              >
                  <span class="icon is-small">
                    <i class="fas fa-cogs"></i>
                  </span>
              </a>
              <div class="navbar-dropdown">
                <div class="container">
                  <div class="columns">
                    <div class="column is-one-fifth has-tooltip-bottom has-tooltip-info"
                         data-tooltip="Coming in next update">
                      <label class="checkbox">
                        <input type="checkbox" disabled>
                        Only auto-run code that validates
                      </label>
                      <label class="checkbox">
                        <input type="checkbox" checked disabled>
                        Run code on CTRL+S
                      </label>
                      <label class="checkbox">
                        <input type="checkbox" checked disabled>
                        Run code on CTRL/ALT + ENTER
                      </label>
                    </div>
                    <div class="column">
                    </div>
                    <div class="column">
                      <p>Editor layout:</p>
                      <div class="field has-addons has-tooltip-bottom has-tooltip-info"
                           data-tooltip="Coming in next update">
                        <p class="control">
                          <button class="button is-info is-disabled">
                            <span>Rows</span>
                          </button>
                        </p>
                        <p class="control">
                          <button class="button is-disabled" disabled>
                            <span>Columns</span>
                          </button>
                        </p>
                        <p class="control">
                          <button class="button is-disabled" disabled>
                            <span>Bottom results</span>
                          </button>
                        </p>
                        <p class="control">
                          <button class="button is-disabled" disabled>
                            <span>Tabs (columns)</span>
                          </button>
                        </p>
                        <p class="control">
                          <button class="button is-disabled" disabled>
                            <span>Tabs (rows)</span>
                          </button>
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </nav>
  </div>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';
import {PhpHubApi} from "@/providers/php-hub-api";

@Component
export default class HeaderBar extends Vue {
  private showSettingsBar = false;
  protected phpHubApiClient = new PhpHubApi();

  getInstanceList() {
    console.log(this.phpHubApiClient.getListPhpInstances());
  }
}
</script>

<style lang="scss">
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

      &.is-mega {
        & .navbar-dropdown {
          z-index: 19;
        }
      }
    }
  }
}
</style>
