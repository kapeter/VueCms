<template>
  <label class="el-radio">
    <span class="el-radio__input"
      :class="{
        'is-disabled': isDisabled,
        'is-checked': model === label,
        'is-focus': focus
      }"
    >
      <span class="el-radio__inner"></span>
      <input
        class="el-radio__original"
        :value="label"
        type="radio"
        v-model="model"
        @focus="focus = true"
        @blur="focus = false"
        :name="name"
        :disabled="isDisabled">
    </span>
    <span class="el-radio__label">
      <slot></slot>
      <template v-if="!$slots.default">{{label}}</template>
    </span>
  </label>
</template>
<script>
  import Emitter from 'element-ui/src/mixins/emitter';

  export default {
    name: 'ElRadio',

    mixins: [Emitter],

    componentName: 'ElRadio',

    props: {
      value: {},
      label: {},
      disabled: Boolean,
      name: String
    },

    data() {
      return {
        focus: false
      };
    },

    computed: {
      isGroup() {
        let parent = this.$parent;
        while (parent) {
          if (parent.$options.componentName !== 'ElRadioGroup') {
            parent = parent.$parent;
          } else {
            this._radioGroup = parent;
            return true;
          }
        }
        return false;
      },

      model: {
        get() {
          return this.isGroup ? this._radioGroup.value : this.value;
        },

        set(val) {
          if (this.isGroup) {
            this.dispatch('ElRadioGroup', 'input', [val]);
          } else {
            this.$emit('input', val);
          }
        }
      },

      isDisabled() {
        return this.isGroup
          ? this._radioGroup.disabled || this.disabled
          : this.disabled;
      }
    }
  };
</script>
<style>
   .el-radio,.el-radio__input {
    white-space:nowrap;
    cursor:pointer
  }
  .el-radio,.el-radio__inner,.el-radio__input {
    position:relative;
    display:inline-block
  }
  .el-radio {
    color:#1f2d3d;
    -moz-user-select:none;
    -webkit-user-select:none;
    -ms-user-select:none
  }
  .el-radio+.el-radio {
    margin-left:15px
  }
  .el-radio__input {
    outline:0;
    line-height:1;
    vertical-align:middle
  }
  .el-radio__input.is-focus .el-radio__inner {
    border-color:#20a0ff
  }
  .el-radio__input.is-checked .el-radio__inner {
    border-color:#20a0ff;
    background:#20a0ff
  }
  .el-radio__input.is-checked .el-radio__inner::after {
    -ms-transform:translate(-50%,-50%) scale(1);
    transform:translate(-50%,-50%) scale(1)
  }
  .el-radio__input.is-disabled .el-radio__inner {
    background-color:#eef1f6;
    border-color:#d1dbe5;
    cursor:not-allowed
  }
  .el-radio__input.is-disabled .el-radio__inner::after {
    cursor:not-allowed;
    background-color:#eef1f6
  }
  .el-radio__input.is-disabled .el-radio__inner+.el-radio__label {
    cursor:not-allowed
  }
  .el-radio__input.is-disabled.is-checked .el-radio__inner {
    background-color:#d1dbe5;
    border-color:#d1dbe5
  }
  .el-radio__inner,.el-radio__input.is-disabled.is-checked .el-radio__inner::after {
    background-color:#fff
  }
  .el-radio__input.is-disabled+.el-radio__label {
    color:#bbb;
    cursor:not-allowed
  }
  .el-radio__inner {
    border:1px solid #bfcbd9;
    width:18px;
    height:18px;
    border-radius:50%;
    cursor:pointer;
    box-sizing:border-box
  }
  .el-radio__inner:hover {
    border-color:#20a0ff
  }
  .el-radio__inner::after {
    width:6px;
    height:6px;
    border-radius:50%;
    background-color:#fff;
    content:"";
    position:absolute;
    left:50%;
    top:50%;
    -ms-transform:translate(-50%,-50%) scale(0);
    transform:translate(-50%,-50%) scale(0);
    transition:transform .15s cubic-bezier(.71,-.46,.88,.6)
  }
  .el-radio__original {
    opacity:0;
    outline:0;
    position:absolute;
    z-index:-1;
    top:0;
    left:0;
    right:0;
    bottom:0;
    margin:0
  }
  .el-radio__label {
    padding-left:5px
  }
</style>
