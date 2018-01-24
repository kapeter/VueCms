<template>
	<div>
		<transition mode="out-in" enter-active-class="animated fadeInRight" leave-active-class="animated fadeOutRight">
	    	<router-view></router-view>
	    </transition>		
	</div>
</template>