<template>
  <div class="footer">
    <div class="footer-element"></div>
    <div class="footer-element"></div>
    <div class="footer-element"><a href="https://secure.php.net/">php.net</a> Official documentation</div>
  </div>
</template>

<style scoped>
  .footer {
    display: flex;
    width: 100%;
    justify-content: space-between;
  }
  .footer-element {
    margin: auto;
    text-align: center;
  }
  .footer-element a {
    cursor: pointer;
    text-decoration: none;
    color: #007cd7;
  }
  .footer-element:first-child {
    margin-left: 0px;
    text-align: center;
  }
  .footer-element:last-child {
    margin-right: 0px;
    text-align: center;
  }
</style>
