<template>
    <!-- Error Content -->
    <div class="content bg-white text-center pulldown">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                <!-- Error Titles -->
                <h1 class="font-s128 font-w300 text-city animated flipInX">404</h1>
                <h2 class="h3 font-w300 push-50 animated fadeInUp">We are sorry but the page you are looking for was not found..</h2>
                <!-- END Error Titles -->
            </div>
        </div>
        <div class="row push-60-t">
            <router-link to="/" class="btn btn-info">Back to Dashboard</router-link>
        </div>
        <div class="content pulldown text-muted text-center">
            &copy; {{ thisYear }} Kapeter.com
        </div>
    </div>
    <!-- END Error Content -->
</template>

<script>
    export default {
        computed: {
            thisYear() {
                return (new Date()).getFullYear();
            }
        },
    }
</script>