<template>
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-8">
                <form @submit="formSubmit">
                    <div class="form-row mb-4">
                        <div class="col-12 col-md-8 mb-2 mb-md-0">
                            <input v-model="long_url" type="text" class="form-control form-control-lg" id="destinationUrl"
                                   placeholder="Enter your link (required)">
                        </div>
                        <div class="col-12 col-md-4 mb-2 mb-md-0">
                            <input v-model="short_tag" type="text" class="form-control form-control-lg" id="shortCode"
                                   placeholder="Slug (optional)">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-12 col-md-3">
                            <button type="submit" class="btn btn-block btn-lg btn-primary">Shorten</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-12 result">
                <h5 id="resultTitle"></h5>
                <p id="resultDescription"></p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        props: {
            long_url: '',
            short_tag: ''
        },
        methods: {
            formSubmit(e) {
                e.preventDefault();

                axios.post('/api/links', {
                    long_url: this.long_url,
                    short_tag: this.short_tag
                }).then((response) => {
                    console.log(response)
                }).catch((error) => {
                    console.log(error);
                });
            }
        }
    }
</script>
