<template>
  <header class="header">
    <div class="container">
      <div class="logo">
        <img src="../assets/images/logo-lg.png">
      </div>
      <div class="slogan">
        <p>Kapeter.com, A frontend blog built with VueCms.</p>
      </div>
      <nav class="nav">
        <ul>
          <li><a href="#">首页</a></li>
          <li><a href="#">关于</a></li>
          <li><a href="#">文章</a></li>
          <li><a href="#">相册</a></li>
          <li><a href="#">项目</a></li>
          <li><a href="#">联系我</a></li>
        </ul>
      </nav>
    </div>
  </header>
</template>

<script>
  export default {}
</script>

<style>
  .header{
    padding: 60px 0;
  }
  .logo, .slogan{
    width: 100%;
    text-align: center;
  }
  .slogan{
    color: #666;
    font-size: 16px;
    font-style: italic;
    letter-spacing: 1px;
    margin-top: 25px;
  }
  .nav{
    width: 100%;
    height: 60px;
    margin-top: 30px;
    text-align: center;
    border-top: 1px #ddd solid;
    border-bottom: 1px #ddd solid;
  }
  .nav > ul {
    display: inline-block;
    line-height: 60px;
  }
  .nav > ul:after{
    content: '';
    display: block;
    clear: both;
    height: 0;
  }
  .nav > ul > li {
    margin: 0 15px;
    float: left;
    text-align: center;
  }
</style>
