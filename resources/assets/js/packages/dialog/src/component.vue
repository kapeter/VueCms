<template>
  <transition name="dialog-pop">
    <div class="el-dialog__wrapper" v-show="visible" @click.self="handleWrapperClick">
      <div class="modal-dialog" :class="[sizeClass, customClass]" :style="style">
        <div class="modal-content">
          <div class="block block-themed" ref="dialog" >
            <div class="block-header bg-primary-dark">
              <ul class="block-options">
                <li>
                  <button v-if="showClose" @click='close()'><i class="si si-close"></i></button>
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
  import emitter from 'element-ui/src/mixins/emitter';

  export default {
    name: 'ElDialog',

    mixins: [Popup, emitter],

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

      size: {
        type: String,
        default: 'small'
      },

      customClass: {
        type: String,
        default: ''
      },

      top: {
        type: String,
        default: '12%'
      }
    },
    data() {
      return {
        visible: false
      };
    },

    watch: {
      value(val) {
        this.visible = val;
      },
      visible(val) {
        this.$emit('input', val);
        if (val) {
          this.$emit('open');
          this.$el.addEventListener('scroll', this.updatePopper);
          this.$nextTick(() => {
            this.$refs.dialog.scrollTop = 0;
          });
        } else {
          this.$el.removeEventListener('scroll', this.updatePopper);
          this.$emit('close');
        }
      }
    },

    computed: {
      sizeClass() {
        return `el-dialog--${ this.size }`;
      },
      style() {
        return this.size === 'full' ? {} : { 'top': this.top };
      }
    },

    methods: {
      handleWrapperClick() {
        if (this.closeOnClickModal) {
          this.close();
        }
      },
      updatePopper() {
        this.broadcast('ElSelectDropdown', 'updatePopper');
        this.broadcast('ElDropdownMenu', 'updatePopper');
      }
    },

    mounted() {
      if (this.value) {
        this.rendered = true;
        this.open();
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
  .el-dialog--tiny {
    width:30%
  }
  .el-dialog--small {
    width:50%
  }
  .el-dialog--large {
    width:90%
  }
  .el-dialog--full {
    width:100%;
    top:0;
    margin-bottom:0;
    height:100%;
    overflow:auto
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
