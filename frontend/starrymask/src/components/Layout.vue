<template>
  <div>
    <HeaderPart></HeaderPart>
    <main class="main">
      <div class="container" id="content">
        <router-view></router-view>
      </div>
    </main>
    <FooterPart></FooterPart>
  </div>
</template>

<script>
  import HeaderPart from './Header.vue'
  import FooterPart from './Footer.vue'

  export default {
    components: {
      HeaderPart,
      FooterPart
    }
  }
</script>

<style>
  .main{
    position: relative;
    width: 100%;
  }
</style>
