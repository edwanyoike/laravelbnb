<template>
    <div>
        <nav class="navbar bg-white border-bottom  navbar-expand-lg navbar-light">
            <router-link
                class="navbar-brand mr-auto"
                to="/"
            >
                home
            </router-link>

            <ul class="navbar-nav ">
                <li class="nav-item">
                    <router-link :to="{name:'basket'}" class="nav-link">
                        basket
                        <span class="badge badge-secondary" v-if="itemsInBasket"> {{ itemsInBasket }} </span>
                    </router-link>
                </li>

                <li class="nav-item" v-if="!isLoggedIn">
                    <router-link :to="{name:'register'}" class="nav-link">Register</router-link>

                </li>

                <li class="nav-item" v-if="!isLoggedIn">
                    <router-link :to="{name:'login'}" class="nav-link">Login</router-link>

                </li>

                <li class="nav-item" v-if="isLoggedIn">
                    <a @click.prevent="logout" class="nav-link" href="#">Logout</a>
                </li>


            </ul>


        </nav>

        <div class="container mt-4  mb-4 pr-4 pl-4 ">
            <router-view/>
        </div>
    </div>
</template>

<script>
    import {mapGetters, mapState} from 'vuex';

    export default {
        name: 'index',
        data() {
            return {
                lastSearch: this.$store.state.lastSearch
            };
        },


        computed: {
            ...mapState({
                lastSearchComputed: 'lastSearch',
                isLoggedIn: 'isLoggedIn'
            }),
            ...mapGetters({
                itemsInBasket: 'itemsInBasket'
            })
        },

        methods: {
            async logout() {
                try {
                    axios.post("/logout");
                    this.$store.dispatch("logout");
                } catch (e) {

                }
            }
        },
        beforeCreate() {

        }
    };


</script>

<style scoped>

</style>
