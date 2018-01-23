<template>
	<div>
		<transition mode="out-in" enter-active-class="animated lightSpeedIn" leave-active-class="animated lightSpeedOut">
	    	<router-view></router-view>
	    </transition>		
	</div>
</template>