<template>
	<div>
		<page-heading title="系统设置" subTitle="System Settings" :crumbs="crumbs"></page-heading>
        <!-- Page Content -->
        <div class="content">
        </div>
        <!-- END Page Content -->
	</div>
</template>

<script>
	export default {
		data() {
			return {
				crumbs: [
                    {to: null, text: '系统设置'},
                ],
			}
		}
	}
</script>