<template>
    <div class=" w-50 m-auto align-items-center">
        <div class="card card-body">
            <form>
                <label for="email">E-mail </label>
                <input class="form-control" id="email" placeholder="enter your email" type="email" v-model="email">

                <label for="password">Password </label>
                <input class="form-control" id="password" placeholder="enter your password" type="password"
                       v-model="password">

                <button type="submit" class="btn-primary btn-lg btn-block" > Login </button>

                <hr/>

                <span class="text-nowrap">
                    No account yet?
<!--                    <router-link :to="{name:'home'}" class="font-weight-bolder"> register</router-link>-->
                </span>

            </form>
        </div>

    </div>

</template>

<script>
    export default {
        name: 'Login',
        data() {
            return {
                email: null,
                password: null
            };
        },
    };
</script>

<style scoped>

</style>
