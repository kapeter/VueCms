<template>
    <footer id="page-footer" class="content-mini content-mini-full font-s12 bg-white clearfix">
        <div class="pull-left">
        	{{ year }} &copy; <a href="https://www.github.com/kapeter">Kapeter.com</a>
        </div>
    </footer>
</template>

<script>
	export default {
		computed: {
			year() {
				return (new Date()).getFullYear();
			}
		}
	}
</script>