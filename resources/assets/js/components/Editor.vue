<template>
  <div class="tiny-editor">
    <div class="editor-toolbar">
      <a href="javascript;" @click.prevent="mediaDialogVisible = true" title="上传多媒体">
        <i class="fa fa-picture-o"></i>
      </a> 
      <a href="javascript;" @click.prevent="mediaDialogVisible = true" title="对比">
        <i class="fa fa-columns"></i>
      </a> 
      <a href="javascript;" @click.prevent="mediaDialogVisible = true" title="全屏">
        <i class="fa fa-arrows-alt"></i>
      </a>     
      <a href="javascript;" class="pull-right" @click.prevent="mediaDialogVisible = true" title="Markdown语法指南">
        <i class="fa fa-question-circle"></i>
      </a>    
    </div>

    <div class="editor-content" :style="{ height: height }">
      <textarea class="form-control editor-input" v-model="content"></textarea>
      <div class="compiled-box">
        <div v-html="compiledMarkdown"></div>
      </div>
    </div>

    <ElDialog title="添加媒体" :visible.sync="mediaDialogVisible"  width="90%" top="2vh">
      <vue-media :isClosed="!mediaDialogVisible"></vue-media>
      <span slot="footer">
          <button class="btn btn-default" @click="mediaDialogVisible = false">关  闭</button>
          <button class="btn btn-info" :disabled="!$store.state.mediaIsChecked">确定选择</button>
      </span>
    </ElDialog> 
  </div>
</template>

<script>
  import marked from 'marked'

  export default {
    name: 'tiny-editor',
    props: {
      height: {
        type: String,
        default: '500px'
      },
      value: String
    },
    data() {
      return {
        content: '',
        mediaDialogVisible: false
      }
    },
    computed: {
      compiledMarkdown() {
        return marked(this.content, { sanitize: true })
      }
    },
    watch: {
      value(val) {
        this.content = val;
      },
    },
    mounted() {
      this.$emit('input', this.content);
    },
    methods: {

    }
  }
</script>

<style>
  .tiny-editor {
    width: 100%;
    color: #646464;
    border: 1px solid #e6e6e6;
  }
  .editor-toolbar{
    padding: 8px 12px;
    border-bottom: 1px solid #e6e6e6;
    font-size: 1.1em;
  }
  .editor-toolbar a{
    display: inline-block;
    text-align: center;
    text-decoration: none!important;
    color: #666 !important;
    width: 30px;
    height: 30px;
    line-height: 30px;
    margin: 0;
    border: 1px solid transparent;
    cursor: pointer;
    font-size: 1.1em;
  }
  .editor-toolbar a:hover{
    border-color: #95a5a6;
  }
  .editor-content{
    width: 100%;
    min-height: 400px;
    box-sizing: border-box;
  }
  .editor-content:after{
    content: '';
    display: block;
    clear: both;
    height: 0;
  }
  .editor-content .editor-input {
    width: 50%;
    height: 100%;
    border: none;
    box-sizing: border-box;
    float: left;
    background-color: #2c2e3e;
    color: #fff;
  }
  .editor-content .compiled-box{
    float: left;
    width: 50%;
    height: 100%;
    padding: 6px 12px;
    line-height: 1.5;
    font-size: 14px;
    overflow-y:auto;
  }
  .compiled-box p{
    margin-bottom: 0.5em;
  }
  .compiled-box h1{
    margin-top: 0.85em;
    margin-bottom: 0.85em;
  }
  .compiled-box h2, .compiled-box h3, .compiled-box h4, .compiled-box h5, .compiled-box h6 {
    margin-bottom: 0.5em;
    margin-top: 0.5em;
  }
  .compiled-box ul, .compiled-box ol{
    margin-left: 30px;
    margin-bottom: 0.85em;
    word-break: break-word;
  }
  .compiled-box ul li, .compiled-box ol li{
    list-style-type: disc;
    display: list-item;
    text-align: -webkit-match-parent;
  }
  .compiled-box a{
    color: #66ccff;
  }
  .compiled-box a:hover{
    color: #66ccff;
    text-decoration: underline;
  }
  .compiled-box pre {
    border: 1px solid #ddd;
    padding: 10px 15px;
    overflow-x: auto;
    margin-bottom: 0.85em;
    background: #f4f4f4;
  }
  .compiled-box blockquote {
    padding: 10px 15px;
    overflow-x: auto;
    margin-bottom: 0.85em;
    background: #f4f4f4;
    border-left:2px solid #66ccff;
  }
  .compiled-box blockquote p:last-child{
    margin-bottom: 0;
  }
  .compiled-box code{
    font: 13px/1.5 'Poppins','PingFang SC',"Helvetica Neue",Helvetica,Arial,sans-serif;
  }
  .compiled-box img{
    max-width: 100%;
    margin-bottom: .85em;
  }
</style>