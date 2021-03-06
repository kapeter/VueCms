<template>
  <transition name="dialog-pop">
    <div class="el-dialog__wrapper" v-show="visible" @click.self="handleWrapperClick">
      <div
        class="modal-dialog"
        :class="[{ 'is-fullscreen': fullscreen, 'el-dialog--center': center }, customClass]"
        ref="dialog"
        :style="style">
        <div class="modal-content">
          <div class="block block-themed">
            <div class="block-header bg-info">
              <ul class="block-options">
                <li>
                  <button type="button" aria-label="Close" v-if="showClose" @click="handleClose">
                    <i class="el-dialog__close el-icon el-icon-close"></i>
                  </button>
                </li>
              </ul>
              <slot name="title">
                <h3 class="block-title">{{title}}</h3>
              </slot>
            </div>
            <div class="block-content" v-if="rendered"><slot></slot></div>
          </div>
          <div class="modal-footer" v-if="$slots.footer">
            <slot name="footer"></slot>
          </div>
        </div>        
      </div>
    </div>
  </transition>
</template>

<script>
  import Popup from 'element-ui/src/utils/popup';
  import Migrating from 'element-ui/src/mixins/migrating';
  import emitter from 'element-ui/src/mixins/emitter';

  export default {
    name: 'ElDialog',

    mixins: [Popup, emitter, Migrating],

    props: {
      title: {
        type: String,
        default: ''
      },

      modal: {
        type: Boolean,
        default: true
      },

      modalAppendToBody: {
        type: Boolean,
        default: true
      },

      appendToBody: {
        type: Boolean,
        default: false
      },

      lockScroll: {
        type: Boolean,
        default: true
      },

      closeOnClickModal: {
        type: Boolean,
        default: true
      },

      closeOnPressEscape: {
        type: Boolean,
        default: true
      },

      showClose: {
        type: Boolean,
        default: true
      },

      width: String,

      fullscreen: Boolean,

      customClass: {
        type: String,
        default: ''
      },

      top: {
        type: String,
        default: '15vh'
      },
      beforeClose: Function,
      center: {
        type: Boolean,
        default: false
      }
    },

    data() {
      return {
        closed: false
      };
    },

    watch: {
      visible(val) {
        if (val) {
          this.closed = false;
          this.$emit('open');
          this.$el.addEventListener('scroll', this.updatePopper);
          this.$nextTick(() => {
            this.$refs.dialog.scrollTop = 0;
          });
          if (this.appendToBody) {
            document.body.appendChild(this.$el);
          }
        } else {
          this.$el.removeEventListener('scroll', this.updatePopper);
          if (!this.closed) this.$emit('close');
        }
      }
    },

    computed: {
      style() {
        let style = {};
        let winH = 0;
        if (window.innerWidth){
          winH = window.innerWidth;
        }else if ((document.body) && (document.body.clientWidth)){
          winH = document.body.clientWidth;
        }
        if (winH > 1024){
          if (this.width) {
            style.width = this.width;
          }
          if (!this.fullscreen) {
            style.marginTop = this.top;
          } 
        }else{
          style = {
            width: '90%',
            height: '2vh'
          }
        }
        return style;
      }
    },

    methods: {
      getMigratingConfig() {
        return {
          props: {
            'size': 'size is removed.'
          }
        };
      },
      handleWrapperClick() {
        if (!this.closeOnClickModal) return;
        this.handleClose();
      },
      handleClose() {
        if (typeof this.beforeClose === 'function') {
          this.beforeClose(this.hide);
        } else {
          this.hide();
        }
      },
      hide(cancel) {
        if (cancel !== false) {
          this.$emit('update:visible', false);
          this.$emit('close');
          this.closed = true;
        }
      },
      updatePopper() {
        this.broadcast('ElSelectDropdown', 'updatePopper');
        this.broadcast('ElDropdownMenu', 'updatePopper');
      }
    },

    mounted() {
      if (this.visible) {
        this.rendered = true;
        this.open();
        if (this.appendToBody) {
          document.body.appendChild(this.$el);
        }
      }
    }
  };
</script>

<style>
  .v-modal-enter {
    animation:v-modal-in .12s ease-out;
  }
  .v-modal-leave {
    animation:v-modal-out .12s ease-out forwards
  }
  @keyframes v-modal-in {
    0% {
      opacity:0
    }
  }
  @keyframes v-modal-out {
    100% {
      opacity:0
    }
  }
  .v-modal {
    position:fixed;
    left:0;
    top:0;
    width:100%;
    height:100%;
    opacity:.5;
    background:#000
  }
  .el-dialog {
    position:absolute;
    left:50%;
    -ms-transform:translateX(-50%);
    transform:translateX(-50%);
    background:#fff;
    border-radius:2px;
    box-shadow:0 1px 3px rgba(0,0,0,.3);
    box-sizing:border-box;
    margin-bottom:50px
  }
  .el-dialog__wrapper {
    top:0;
    right:0;
    bottom:0;
    left:0;
    position:fixed;
    overflow:auto;
    margin:0
  }
  .dialog-pop-enter-active {
    animation:dialog-pop-in .12s ease-out;
  }
  .dialog-pop-leave-active {
    animation:dialog-pop-out .12s ease-out;
  }
  .modal-dialog .block.block-themed > .block-header {
    padding: 15px 20px;
  }
  @keyframes dialog-pop-in {
    0% {
      -webkit-transform: scale(0.9);
      -ms-transform: scale(0.9);
      transform: scale(0.9);
      opacity:0
    }
    100% {
      -webkit-transform: scale(1);
      -ms-transform: scale(1);
      transform: scale(1);
      opacity:1
    }
  }
  @keyframes dialog-pop-out {
    0% {
      -webkit-transform: scale(1);
      -ms-transform: scale(1);
      transform: scale(1);
      opacity:1
    }
    100% {
      -webkit-transform: scale(0.9);
      -ms-transform: scale(0.9);
      transform: scale(0.9);
      opacity:0
    }
  }  
</style>
