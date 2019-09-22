<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10">
                <div class="form-group row">
                    <div class="col-md-6">
                        <input v-model="searchTermLongUrl" type="text" @keyup="searchLinks"
                               class="form-control" name="searchTermLongUrl" placeholder="Search by long url">
                    </div>
                    <div class="col-md-6">
                        <input v-model="searchTermShortTag" type="text" @keyup="searchLinks"
                               class="form-control" name="searchTermShortTag" placeholder="Search by short tag">
                    </div>
                </div>

                <div class="card mb-2" v-for="link in links">
                    <div class="card-body">
                        Long url: {{link.long_url}}<br/>
                        Short tag: {{link.short_tag}}<br/>
                        Total hits: {{link.hits}}<br/>
                        Expiration date: {{link.expiration_date ? link.expiration_date : '-' }}<br/>
                        Deleted: {{!!link.deleted_at}}<br/>
                        Created at: {{link.created_at}}, Updated at: {{link.created_at}}<br/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            if (!this.$cookies.get('api_token')) {
                this.$router.push('/login');
            }
        },
        data() {
            return {
                links: [],
                searchTermLongUrl: '',
                searchTermShortTag: ''
            }
        },
        methods: {
            searchLinks() {
                if (this.timeout) clearTimeout(this.timeout);
                this.timeout = setTimeout(() => {
                    this.getLinks();
                }, 500);
            },
            getLinks() {
                let apiEndpoint = '/api/dashboard/search?api_token=' + this.$cookies.get('api_token');

                if (this.searchTermLongUrl.length) {
                    apiEndpoint += '&long_url=' + this.searchTermLongUrl;
                }

                if (this.searchTermShortTag.length) {
                    apiEndpoint += '&short_tag=' + this.searchTermShortTag;
                }

                axios.get(apiEndpoint).then(response => {
                    this.links = response.data;
                }).catch((error) => {
                    if (error.response && error.response.status === 401) {
                        this.$router.push('/login');
                    }
                });
            }
        },
        created() {
            this.getLinks();
        }
    }
</script>
