<template>
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-10 mb-4">
                <form @submit="formSubmit">
                    <div class="form-row mb-2">
                        <div class="col-12 col-md-6 mb-2 mb-md-0">
                            <input v-model="long_url"
                                   type="text"
                                   class="form-control form-control-lg"
                                   id="destinationUrl"
                                   placeholder="Enter your link (required)">
                        </div>
                        <div class="col-12 col-md-4 mb-2 mb-md-0">
                            <input v-model="short_tag"
                                   type="text"
                                   class="form-control form-control-lg"
                                   id="shortCode"
                                   placeholder="Slug (optional)">
                        </div>
                    </div>
                    <div class="form-row mb-4">
                        <div class="col-12 col-md-5 mb-2 mb-md-0">
                            <datetime v-model="expiration_date"
                                      input-class="form-control form-control-lg"
                                      type="datetime"
                                      :placeholder="'Expiration time (optional)'">
                            </datetime>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-12 col-md-3">
                            <button type="submit"
                                    class="btn btn-block btn-lg btn-primary">Shorten
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row" v-if="errors">
            <div class="col-12">
                <div class="alert alert-warning" role="alert" v-text="errors"></div>
            </div>
        </div>


        <div class="row" v-if="message">
            <div class="col-12">
                <div class="alert alert-success" role="alert" v-html="message"></div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        data() {
            return {
                errors: '',
                message: '',
                long_url: '',
                short_tag: '',
                expiration_date: ''
            }
        }
        ,
        methods: {
            fixUrl() {
                let regex = /^(http|https)/;
                if (this.long_url.length > 3 && !this.long_url.match(regex)) {
                    this.long_url = 'http://' + this.long_url;
                }
            },
            formSubmit(e) {
                e.preventDefault();

                if(!this.long_url.length) {
                    this.errors = 'Please fill the url you need to shorten.';
                    return;
                }

                this.fixUrl();

                axios.post('/api/links', {
                    long_url: this.long_url,
                    short_tag: this.short_tag,
                    expiration_date: this.expiration_date
                }).then((response) => {
                    const newShortLink = window.location.href + response.data.short_tag;
                    this.message = 'Short tag created! Ready to share: <a target="_blank" href="' + newShortLink + '">' + newShortLink + '</a>';
                    this.errors = '';


                    this.long_url = '';
                    this.short_tag = '';
                    this.expiration_date = '';
                }).catch((errors) => {
                    this.message = '';
                    this.errors = '';
                    Object.keys(errors.response.data.errors).forEach(error => {
                        this.errors = this.errors + ' ' + errors.response.data.errors[error];
                    });
                });
            }
        }
    }
</script>
