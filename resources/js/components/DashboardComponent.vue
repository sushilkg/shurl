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
            axios.get('/api/dashboard/all').then(links => {
                console.log(links);
            }).catch((error) => {
                console.log(error.response.status);
                if (error.response && error.response.status === 401) {
                    console.log('Not logged in!');
                }
            })
        }
    }
</script>
