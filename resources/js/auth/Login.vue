<template>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Login</div>

                    <div class="card-body">
                        <form>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right" for="email">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input :class="[{'is-invalid':errorFor('email') }]" autocomplete="email" autofocus
                                           class="form-control " id="email" name="email"
                                           required type="email" v-model="email">

                                    <v-errors :errors="errorFor('email')"/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right" for="password">Password</label>

                                <div class="col-md-6">
                                    <input :class="[{'is-invalid':errorFor('password') }]" autocomplete="current-password" class="form-control "
                                           id="password" name="password"
                                           required type="password" v-model="password">

                                    <v-errors :errors="errorFor('password')"/>

                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" id="remember" name="remember" type="checkbox">

                                        <label class="form-check-label" for="remember">
                                            Remember Me
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button  @click.prevent="login" class=" btn btn-primary " type="submit">
                                        Login
                                    </button>

                                    <div>
                                        <hr/>
                <span>
                    No account yet?
                    <router-link :to="{name:'register'}" class="font-weight-bolder"> register</router-link>
                </span>
                                        <hr/>
                                        <span>
                    forgot password?
                    <router-link :to="{name:'home'}" class="font-weight-bolder"> recover</router-link>
                </span>
                                    </div>
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
        name: 'Login',
        data() {
            return {
                email: null,
                password: null,
                loading: false
            };
        },

        methods: {
            async login() {
                this.errors = null;
                this.loading = true;

                try {

                    await axios.get("/sanctum/csrf-cookie");
                    await axios.post("/login", {
                        email: this.email,
                        password: this.password
                    })

                    logIn();
                    this.$store.dispatch("loadUser");

                    if(sessionStorage.getItem('redirectPath') ){
                        this.$router.push(sessionStorage.getItem('redirectPath'));
                    }
                    else {
                        this.$router.push({name:'home'});
                    }

                    sessionStorage.removeItem('redirectPath');
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
