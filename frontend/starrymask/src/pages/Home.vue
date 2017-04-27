<template>
  <div>
    <div class="box">
      <h2 class="box-title">Recent Project</h2>
      <div class="box-content">
        <div class="row">
          <div class="col-6">
            <div class="project-pic">
              <img src="../assets/images/project-simple.jpg">
            </div>
          </div>
          <div class="col-6">
            <div class="project-info">
              <h3>VueCMS后台管理系统</h3>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {}
</script>

<style>
  .home-content{
    font-size: 100px;
    font-weight: 300;
    text-align: center;
    vertical-align: center
  }
  .box-title{
    font-family: 'Satisfy','Roboto',Arial,sans-serif;
    font-size: 24px;
    text-align: center;
    color: #666;
    font-weight: normal;
  }
  .box-title:before{
    content: '/';
    margin-right: 15px;
  }
  .box-title:after{
    content: '/';
    margin-left: 15px;
  }
  .box-content{
    margin-top: 30px;
  }
  .project-pic{
    width: 100%;
    height: 400px;
    overflow: hidden;
  }
  .project-pic > img{
    width: 100%;
  }
  .project-info{

  }
</style>
