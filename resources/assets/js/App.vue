<template>
	<div>
	    <div class="loading" v-show="isLoading">
	        <div class="loading-box">
	            <img src="/img/loading.gif">
	            <p>加载什么的最讨厌啦！</p>                
	        </div>
	    </div>
	    <transition>
	    	<router-view></router-view>
	    </transition>		
	</div>
</template>


<script>
    export default {
        computed: {
            isLoading() {
                return this.$store.state.isLoading;
            }
        }
    }
</script>

<style>
    .loading{
        width: 100%;
        height: 100%;
        position: fixed;
        left: 0;
        top: 0;
        z-index: 9999;
        text-align: center;
        background: #fff;
    }
    .loading-box{
        width: 160px;
        height: 180px;
        position: absolute;
        left:50%;
        top: 50%;
        margin-top: -90px;
        margin-left: -80px;
    }
</style>
