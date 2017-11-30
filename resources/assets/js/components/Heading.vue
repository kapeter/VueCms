<template>
    <!-- Page Header -->
    <div class="content">
        <div class="row">
            <div class="col-sm-7">
                <h1 class="page-heading">
                    {{ title }} <small>{{ subTitle }}</small>
                </h1>
            </div>
            <div class="col-sm-5 text-right hidden-xs">
                <Breadcrumb>
                    <li>
                        <BreadcrumbItem :to="{ path: '/' }"><i class="si si-speedometer crumb-head"></i> 仪表盘</BreadcrumbItem>
                    </li>
                    <li v-for="crumb in crumbs" class="el-breadcrumb__item">
                        <BreadcrumbItem :to="{ path: crumb.to }">{{ crumb.text }}</BreadcrumbItem>
                    </li>
                </Breadcrumb>
            </div>
        </div>
    </div>
    <!-- END Page Header -->
</template>

<script>
    import Breadcrumb from '../components/breadcrumb';
    import BreadcrumbItem from '../components/breadcrumb-item';

	export default {
        components: {
            Breadcrumb,
            BreadcrumbItem,
        },
		props: {
			title: {
				type: String,
				required: true
			},
			subTitle: {
				type: String
			},
            crumbs: {
                type: Array
            }
		},
        computed: {
            thisCrumbs() {
                return this.$store.state.crumbs;
            }
        },
        mounted() {
        }
	}
</script>

<style>
    .crumb-head{
        width: 20px;
        display: inline-block;
        text-align: center;
    }
</style>