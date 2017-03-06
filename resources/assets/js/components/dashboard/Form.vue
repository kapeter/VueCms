<template>
	<form>
		<div class="form-group">
			<label for="material-text2">标题</label>
           	<input class="form-control" type="text" id="material-text2" name="material-text2">   
		</div>	
		<div class="form-group">
			<label for="material-text2">摘要</label>
            <textarea class="form-control" rows="3"></textarea>
		</div>	
		<div class="form-group">
			<label for="material-text2">正文内容</label>
            <textarea id="editor"></textarea>
		</div>				
	</form>
</template>

<script>
	import { default as SimpleMDE } from 'simplemde/dist/simplemde.min.js'

	export default {
		props: {
			actionUrl: {
				type: String,
				default: ''
			},
		},
        data() {
            return {
                simplemde: '',
            }
        },
		mounted() {
            this.simplemde = new SimpleMDE({
                element: document.getElementById("editor"),
                autoDownloadFontAwesome: true,
                tabSize: 4
            });
		}
	}
</script>

<style>
	.form-group > label{
		font-size: 15px;
		font-weight: 400;
	}
</style>