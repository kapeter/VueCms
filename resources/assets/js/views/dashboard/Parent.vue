<template>
	<div>
		<transition mode="out-in" enter-active-class="animated slideInRight" leave-active-class="animated slideOutRight">
	    	<router-view></router-view>
	    </transition>		
	</div>
</template>