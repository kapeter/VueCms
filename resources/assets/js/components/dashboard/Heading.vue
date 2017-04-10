<template>
    <!-- Page Header -->
    <div class="content bg-gray-lighter">
        <div class="row items-push">
            <div class="col-sm-7">
                <h1 class="page-heading">
                    {{ title }} <small>{{ subTitle }}</small>
                </h1>
            </div>
            <div class="col-sm-5 text-right hidden-xs">
                <ol class="breadcrumb push-10-t">
                    <li v-for = "(crumb, index) in thisCrumbs">
                        <i class="si si-speedometer crumb-head" v-if="index == 0"></i>
                        <router-link :to="crumb.link" exact v-if= "index != thisCrumbs.length - 1" class="link-effect"> {{ crumb.name }}</router-link>
                        <span v-else>{{ crumb.name }}</span>
                    </li>
                </ol>
            </div>
        </div>
    </div>
    <!-- END Page Header -->
</template>

<script>
	export default {
		props: {
			title: {
				type: String,
				required: true
			},
			subTitle: {
				type: String
			}
		},
        computed: {
            thisCrumbs() {
                return this.$store.state.crumbs;
            }
        },
	}
</script>

<style>
    .crumb-head{
        width: 20px;
        display: inline-block;
        text-align: center;
    }
</style>