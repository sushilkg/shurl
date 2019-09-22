<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body" v-for="link in links" v-text="link.long_url"></div>
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
        data() {
            return {
                links: []
            }
        },
        created() {
            if (!this.$cookies.get('api_token')) {
                this.$router.push('/login');
            }

            axios.get('/api/dashboard/all?api_token=' + this.$cookies.get('api_token')).then(response => {
                this.links = response.data;
            }).catch((error) => {
                if (error.response && error.response.status === 401) {
                    this.$router.push('/login');
                }
            })
        }
    }
</script>
