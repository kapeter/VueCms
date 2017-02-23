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
                    <li>UI Elements</li>
                    <li><a class="link-effect" href="">Widgets</a></li>
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
		}
	}
</script>