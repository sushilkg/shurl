<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        You are logged in!
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Dashboard component mounted.')
        },
        created() {
            if(!this.$cookies.get('api_token')) {
                this.$router.push('/login');
            }

            axios.get('/api/dashboard/all?api_token=' + this.$cookies.get('api_token')).then(links => {
                console.log(links);
            }).catch((error) => {
                if (error.response && error.response.status === 401) {
                    this.$router.push('/login');
                }
            })
        }
    }
</script>
