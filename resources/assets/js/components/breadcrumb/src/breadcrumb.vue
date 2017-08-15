<template>
  <ol class="breadcrumb push-10-t">
    <slot></slot>
  </ol>
</template>
<script>
  export default {
    name: 'ElBreadcrumb',
  };
</script>
<style>
  .el-breadcrumb__item:last-child .el-breadcrumb__item__inner,
  .el-breadcrumb__item:last-child .el-breadcrumb__item__inner a,
  .el-breadcrumb__item:last-child .el-breadcrumb__item__inner a:hover,
  .el-breadcrumb__item:last-child .el-breadcrumb__item__inner:hover{
    color:#999;
    cursor:text;
  }
  .el-breadcrumb__item__inner,.el-breadcrumb__item__inner a{
    transition:color .15s linear;
  }
  .el-breadcrumb__item__inner a,.el-breadcrumb__item__inner{
    color:#66ccff;
    cursor:pointer
  }
  .el-breadcrumb__item__inner a:hover,.el-breadcrumb__item__inner:hover{
    color: #4ca7e6;
  }

</style>
