<template>
  <div>
    <!-- Recent Project  -->
    <div class="box">
      <div class="box-header">
        <h2 class="box-title">Recent Projects</h2>
      </div>
      <div class="box-content">
        <div class="row">
          <div class="col-6">
            <div class="project-pic">
              <a href="#"><img src="../assets/images/project-simple.jpg"></a>
            </div>
          </div>
          <div class="col-6">
            <div class="project-info">
              <h3>VueCMS后台管理系统<span><a href="#">查看详细<i class="iconfont">&#xe651;</i></a></span></h3>
              <ul class="project-content">
                <li><span>概述：</span>The Day One Edition of NieR:Automata released in Asia comes with a mask accessory, four pod skins (Grimoire Weiss, Retro Grey, Retro Red and Cardboard) and also includes the Steam exclusive Valve character Accessory. Secure your Day One Edition today as this bonus content will be available for a limited time only!</li>
                <li><span>标签：</span>Vuejs 2.0, Laravel 5.4</li>
                <li><span>创建时间：</span>2016-12-12</li>
                <li><span>当前版本：</span>Version 1.0.0</li>
                <li><span>仓库地址：</span><a href="#" class="btn btn-sm btn-primary"><i class="iconfont">&#xe70b;</i>Fork me on GitHub</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="box-footer">
        <p><a href="#" class="more-btn">More Projects<i class="iconfont">&#xe651;</i></a></p>
      </div>
    </div>
    <!-- END Recent Project -->

    <!-- Recent Articles -->
    <div class="box">
      <div class="box-header">
        <h2 class="box-title">Recent Articles</h2>
      </div>
      <div class="box-content">
        <div class="row">
          <a class="col-4 article-link" href="#">
            <div class="article-pic">
              <img src="../assets/images/article-simple.jpg">
              <div class="pic-guide">
                Secure your Day One Edition today as this bonus content will be available for a limited time only!
              </div>
            </div>
            <div class="article-info">
              <h3><a href="#">为美好的世界献上祝福</a></h3>
              <ul class="article-content">
                <li><span>栏目：</span>前端开发</li>
                <li><span>标签：</span>JavaScript,Css</li>
              </ul>
              <ul class="article-group">
                <li><a href="#"><i class="iconfont">&#xe651;</i></a></li>
                <li><a href="#"><i class="iconfont">&#xe64c;</i></a></li>
              </ul>
              <p class="article-time"><span>2017.04.06</span></p>
            </div>
          </a>
          <a class="col-4 article-link" href="#">
            <div class="article-pic">
              <img src="../assets/images/article-simple.jpg">
              <div class="pic-guide">
                Secure your Day One Edition today as this bonus content will be available for a limited time only!
              </div>
            </div>
            <div class="article-info">
              <h3><a href="#">为美好的世界献上祝福</a></h3>
              <ul class="article-content">
                <li><span>栏目：</span>前端开发</li>
                <li><span>标签：</span>JavaScript,Css</li>
              </ul>
              <ul class="article-group">
                <li><a href="#"><i class="iconfont">&#xe651;</i></a></li>
                <li><a href="#"><i class="iconfont">&#xe64c;</i></a></li>
              </ul>
              <p class="article-time"><span>2017.04.06</span></p>
            </div>
          </a>
          <a class="col-4 article-link" href="#">
            <div class="article-pic">
              <img src="../assets/images/article-simple.jpg">
              <div class="pic-guide">
                Secure your Day One Edition today as this bonus content will be available for a limited time only!
              </div>
            </div>
            <div class="article-info">
              <h3><a href="#">为美好的世界献上祝福</a></h3>
              <ul class="article-content">
                <li><span>栏目：</span>前端开发</li>
                <li><span>标签：</span>JavaScript,Css</li>
              </ul>
              <ul class="article-group">
                <li><a href="#"><i class="iconfont">&#xe651;</i></a></li>
                <li><a href="#"><i class="iconfont">&#xe64c;</i></a></li>
              </ul>
              <p class="article-time"><span>2017.04.06</span></p>
            </div>
          </a>
        </div>
      </div>
      <div class="box-footer">
        <p><a href="#" class="more-btn">More Articles<i class="iconfont">&#xe651;</i></a></p>
      </div>
    </div>
    <!-- END Recent Articles -->
  </div>
</template>

<script>
  export default {}
</script>

<style>
  .box {
    width: 100%;
    margin-bottom: 60px;
  }
  .box-header{
    width: 100%;
    position: relative;
  }
  .box-title{
    font-family: 'Lobster','Roboto',Arial,sans-serif;
    font-size: 24px;
    text-align: center;
    color: #666;
    font-weight: normal;
  }
  .box-title:before{
    content: '-';
    margin-right: 15px;
  }
  .box-title:after{
    content: '-';
    margin-left: 15px;
  }
  .box-content{
    margin-top: 45px;
  }
  .box-footer{
    margin-top: 30px;
    text-align: center;
  }
  .project-pic{
    width: 100%;
    height: 350px;
    overflow: hidden;
  }
  .project-pic img{
    width: 100%;
    transition: all 0.25s ease-out;
  }
  .project-pic:hover img{
    transform: scale(1.1);
  }
  .project-info{
    padding-left: 30px;
    background:url('../assets/images/logo-lg.png') no-repeat;
    background-position: right bottom;
    line-height: 1.8;
  }
  .project-info > h3{
    font-size: 20px;
    font-weight: normal;
    margin-bottom: 15px;
    display: block;
    height: 24px;
    line-height: 24px;
  }
  .project-info > h3 > span{
    float: right;
    font-size: 12px;
  }
  .project-content > li {
    margin-bottom: 15px;
    word-wrap: break-word;
    word-break: break-all;
  }
  .project-content > li > span {
    font-weight: bold;
  }
  .more-btn{
    font-size: 16px;
  }
  .article-link {
    display: block;
    padding: 15px;
  }
  .article-link:hover{
    color: #666;
    letter-spacing: 1px;
    -webkit-box-shadow: 0 0px 45px rgba(0,0,0,0.15);
    box-shadow: 0 0px 45px rgba(0,0,0,0.15);
  }
  .article-pic{
    width: 100%;
    height: 285px;
    overflow:hidden;
    position: relative;
  }
  .article-pic img {
    width: 100%;
    transition: all 0.25s ease-out;
  }
  .article-info{
    width: 100%;
    padding: 15px 30px 15px 0px;
    box-sizing: border-box;
    position: relative;
  }
  .article-info > h3 {
    font-size: 18px;
    font-weight: normal;
    margin-bottom: 10px;
    display: block;
  }
  .article-content > li {
    margin-bottom: 10px;
    word-wrap: break-word;
    word-break: break-all;
  }
  .article-group > li {
    margin-right: 10px;
    float: left;
  }
  .article-group > li > a {
    display: block;
    width: 24px;
    height: 24px;
    border-radius: 24px;
    line-height: 24px;
    border: 1px solid #666;
    text-align: center;
    font-size: 16px;
  }
  .article-group > li > a:hover{
    background: #39c5bb;
    border-color: #33b0a7;
    letter-spacing: 1px;
    color: #fff;
  }
  .article-time {
    position: absolute;
    right: -35px;
    top: 45px;
    transform: rotate(90deg);
    transition: all .25s ease-out;
  }
  .pic-guide{
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    padding:30px;
    z-index: 1;
    content: "";
    color: #fff;
    background-color: rgba(57, 197, 187, 0.75);
    opacity: 0;
    visibility: none;
    -webkit-transition: all 0.25s ease-out;
    transition: all 0.25s ease-out;
  }
  .article-pic:hover .pic-guide{
    opacity: 1;
    visibility: visible;
  }
  .article-pic:hover img{
    transform: scale(1.1);
  }
</style>
