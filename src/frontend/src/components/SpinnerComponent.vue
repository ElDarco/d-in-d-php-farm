<template>
  <div v-if="visible" class="shim">
    <div v-if="!isGlobal" class="spinner"></div>
    <div v-else class="global-spinner"></div>
  </div>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';

@Component({})
export default class SpinnerComponent extends Vue {
  @Prop({ default: false })
  public visible!: boolean;
  @Prop({ default: false })
  public isGlobal!: boolean;
}
</script>

<style lang="scss" >
.spinner,
.global-spinner
{
  display: inline-block;
  position: absolute;
  top: calc(50% - 27px);
  left: calc(50% - 27px);
  width: 54px;
  height: 54px;

  &::after {
    content: '';
    display: block;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border-width: 7px;
    border-style: solid;
    border-color: #535353 transparent #2a2b2a transparent;
    animation: rotate 1.5s ease infinite;
  }
}

.global-spinner {
  position: fixed;
  top: calc(50vh - 27px);
}

@keyframes rotate {
  from {
    transform: rotate(0deg);
  }
  50% {
    transform: rotate(360deg);
  }
  to {
    transform: rotate(0deg);
  }
}

.shim {
  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  z-index: 999;
  background-color: rgba(255, 255, 255, 0.7);
}
</style>
