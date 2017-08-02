<template>
    <footer id="page-footer" class="content-mini content-mini-full font-s12 bg-white clearfix">
        <div class="pull-right">
			Powered by <i class="fa fa-heart text-city"></i> <a href="https://www.github.com/kapeter">Kapeter.com</a>
        </div>
        <div class="pull-left">
            &copy; {{ thisYear }} VueCMS
        </div>
    </footer>
</template>

<script>
	export default {
		computed: {
			thisYear() {
				return (new Date()).getFullYear();
			}
		}
	}
</script>