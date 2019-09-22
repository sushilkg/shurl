<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Register</div>

                    <div class="card-body">
                        <form @submit="formSubmit">
                            <div class="row" v-if="errors">
                                <div class="col-12">
                                    <div class="alert alert-warning" role="alert" v-text="errors"></div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                                <div class="col-md-6">
                                    <input v-model="name" id="name" type="text"
                                           class="form-control" name="name"
                                           required autocomplete="name" autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input v-model="email" id="email" type="email"
                                           class="form-control" name="email"
                                           required autocomplete="email">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                                <div class="col-md-6">
                                    <input v-model="password" id="password" type="password"
                                           class="form-control" name="password"
                                           required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm
                                    Password</label>

                                <div class="col-md-6">
                                    <input v-model="password_confirmation" id="password-confirm" type="password"
                                           class="form-control"
                                           name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Register
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
            name: '',
            email: '',
            password: '',
            password_confirmation: ''
        },
        data() {
            return {
                errors: ''
            }
        },
        methods: {
            formSubmit(e) {
                e.preventDefault();

                axios.post('/api/register', {
                    name: this.name,
                    email: this.email,
                    password: this.password,
                    password_confirmation: this.password_confirmation
                }).then((response) => {
                    this.$router.push('/login');
                }).catch((errors) => {
                    this.errors = '';
                    Object.keys(errors.response.data.errors).forEach(error => {
                        this.errors = this.errors + ' ' + errors.response.data.errors[error];
                    });
                });
            }
        }
    };
</script>
