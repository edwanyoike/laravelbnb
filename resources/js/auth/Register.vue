<template>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Register</div>

                <div class="card-body">
                    <form>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right" for="name">Name</label>

                            <div class="col-md-6">
                                <input :class="[{'is-invalid':errorFor('name') }]" autocomplete="name" autofocus
                                       class="form-control" id="name" name="name"
                                       placeholder="enter your name" required
                                       type="text" v-model="user.name">

                                <v-errors :errors="errorFor('name')"/>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right" for="email">E-Mail Address</label>

                            <div class="col-md-6">
                                <input :class="[{'is-invalid':errorFor('email') }]" autocomplete="email" class="form-control" id="email" name="email"
                                       placeholder="enter your email"
                                       required type="email"
                                       v-model="user.email">
                                <v-errors :errors="errorFor('email')"/>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right" for="password">Password</label>

                            <div class="col-md-6">
                                <input :class="[{'is-invalid':errorFor('password') }]" autocomplete="new-password" class="form-control " id="password"
                                       name="password" placeholder="enter your password"
                                       required
                                       type="password" v-model="user.password">

                                <v-errors :errors="errorFor('password')"/>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right" for="password-confirm">Confirm
                                Password</label>

                            <div class="col-md-6">
                                <input autocomplete="new-password" class="form-control" :class="[{'is-invalid':errorFor('password_confirmation') }]" id="password-confirm"
                                       name="password_confirmation" placeholder="re-enter password"
                                       required type="password" v-model="user.password_confirmation">
                                <v-errors :errors="errorFor('password_confirmation')"/>

                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button :disabled="loading" @click.prevent="register" class=" btn btn-primary " type="submit">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    import validationError from '../shared/mixins/validationError';
    import {logIn} from '../shared/utilis/auth';

    export default {
        mixins: [validationError],
        name: 'register',
        data() {
            return {
                user: {
                    email: null,
                    password: null,
                    password_confirmation: null,
                    name: null,
                },
                loading: false
            };
        },

        methods: {

            async register() {
                this.errors = null;
                this.loading = true;

                try {
                    const response = await axios.post("/register", this.user);

                    if(response.status === 201){
                        logIn();
                        this.$store.dispatch("loadUser");
                        this.$router.push({name: "home"});
                    }

                } catch (error) {
                    this.errors = error.response && error.response.data.errors;
                }

                this.loading = false;

            }
        },
    };
</script>

<style scoped>

</style>
