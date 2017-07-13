<template>
	<div>
		<page-heading title="用户管理" subTitle="User Management" :crumbs="crumbs"></page-heading>
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
                    {to: null, text: '用户管理'},
                ],
			}
		}
	}
</script>