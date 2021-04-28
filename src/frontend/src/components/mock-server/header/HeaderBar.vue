<template>
  <div class="header-bar">
    <nav class="navbar is-fixed-top" role="navigation" aria-label="main navigation">
      <div class="navbar-brand">
        <a class="navbar-item" href="https://codetry.club">
          <img src="../../../assets/logo.svg">
        </a>

        <a role="button" class="navbar-burger is-hidden-touch" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
          <span aria-hidden="true"></span>
          <span aria-hidden="true"></span>
          <span aria-hidden="true"></span>
        </a>
      </div>

      <div id="navbarBasicExample" class="navbar-menu">
        <div class="navbar-start">
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
        </div>
      </div>
    </nav>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';

@Component
export default class HeaderBar extends Vue {
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
