<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Login</div>

                    <div class="card-body">
                        <form @submit="formSubmit">

                            <div class="row" v-if="errors">
                                <div class="col-12">
                                    <div class="alert alert-warning" role="alert" v-text="errors"></div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input v-model="email" id="email" type="email"
                                           class="form-control" name="email"
                                           required autocomplete="email" autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                                <div class="col-md-6">
                                    <input v-model="password" id="password" type="password"
                                           class="form-control " name="password"
                                           required autocomplete="current-password">
                                </div>
                            </div>


                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Login
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            email: '',
            password: ''
        },
        data() {
            return {
                errors: ''
            }
        },
        methods: {
            formSubmit(e) {
                e.preventDefault();

                axios.post('/api/login', {
                    email: this.email,
                    password: this.password
                }).then((response) => {
                    this.$cookies.set('api_token', response.data.api_token);
                    this.$router.push('/dashboard');
                }).catch((errors) => {
                    this.errors = errors.response.data;
                });
            }
        }
    };
</script>
