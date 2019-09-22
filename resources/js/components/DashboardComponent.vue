<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-6 col-md-10">
                <div class="card mb-2" v-for="link in links">
                    <div class="card-body">
                        Long url: {{link.long_url}}<br />
                        Short tag: {{link.short_tag}}<br />
                        Total hits: {{link.hits}}<br />
                        Expiration date: {{link.expiration_date ? link.expiration_date : '-' }}<br />
                        Deleted: {{!!link.deleted_at}}<br />
                        Created at: {{link.created_at}}, Updated at: {{link.created_at}}<br />
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
