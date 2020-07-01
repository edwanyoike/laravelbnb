<template xmlns="http://www.w3.org/1999/html">
    <div>

        <div v-if="success">
            <success v-if="success" >
                Booking successful
            </success>
        </div>
        <div class="row" v-else>
            <div class="col-md-8 " v-if="itemsInBasket">

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="firstname">firstname </label>
                        <input :class="[{ 'is-invalid':errorFor('customer.firstname')}]" class="form-control" id="firstname" name="firstname"
                               type="text"
                               v-model="customer.firstname">

                        <v-errors :errors="errorFor('customer.firstname')"/>

                    </div>


                    <div class="col-md-6 form-group">
                        <label for="lastname">Last name </label>
                        <input :class="[{ 'is-invalid':errorFor('customer.lastname')}]" class="form-control" id="lastname" name="lastname"
                               type="text"
                               v-model="customer.lastname">

                        <v-errors :errors="errorFor('customer.lastname')"/>

                    </div>

                </div>

                <div class="row">

                    <div class="col-md-12 form-group">
                        <label for="email">Email address </label>
                        <input :class="[{ 'is-invalid':errorFor('customer.email')}]" class="form-control" id="email" name="email" type="email"
                               v-model="customer.email">

                        <v-errors :errors="errorFor('customer.email')"/>

                    </div>

                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="street">street </label>
                        <input :class="[{ 'is-invalid':errorFor('customer.street')}]" class="form-control" id="street" name="street" type="text"
                               v-model="customer.street">

                        <v-errors :errors="errorFor('customer.street')"/>

                    </div>

                    <div class="col-md-6 form-group">
                        <label for="city">city </label>
                        <input :class="[{ 'is-invalid':errorFor('customer.city')}]" class="form-control" id="city" name="city" type="text"
                               v-model="customer.city">

                        <v-errors :errors="errorFor('customer.city')"/>
                    </div>

                </div>


                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="country">country </label>
                        <input :class="[{ 'is-invalid':errorFor('customer.country')}]" class="form-control" id="country" name="country" type="text"

                               v-model="customer.country">

                        <v-errors :errors="errorFor('customer.country')"/>
                    </div>

                    <div class="col-md-4 form-group">
                        <label for="state">state </label>
                        <input :class="[{ 'is-invalid':errorFor('customer.state')}]" class="form-control" id="state" name="state" type="text"
                               v-model="customer.state">

                        <v-errors :errors="errorFor('customer.state')"/>
                    </div>

                    <div class="col-md-2 form-group">
                        <label for="zip">zip </label>
                        <input :class="[{ 'is-invalid':errorFor('customer.zip')}]" class="form-control" id="zip" name="zip" type="text"

                               v-model="customer.zip">

                        <v-errors :errors="errorFor('customer.zip')"/>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-12 form-group">

                        <button :disabled="loading" @click.prevent="book" class="btn btn-lg btn-primary btn-block"
                                type="submit">
                            BOOK NOW!
                        </button>
                    </div>

                </div>

            </div>

            <div class="col-md-8 " v-else>

                <div class="jumbotron-fluid text-center jumbotron">
                    <h1> Cart is Empty</h1>
                </div>

            </div>


            <div class="col-md-4">
                <div class="d-flex justify-content-between">
                    <h6 class="text-uppercase text-secondary font-weight-bolder ">
                        Your Cart
                    </h6>
                    <h6 class="badge badge-secondary text-uppercase">
                        <span v-if="itemsInBasket"> Items {{ itemsInBasket }} </span>
                        <span v-else>Cart is empty</span>
                    </h6>

                </div>
                <transition-group name="fade">
                    <div :key="item.bookable.id" v-for="item in basket">

                        <div class="pt-2 pb-2 border-top d-flex justify-content-between">
                    <span>
                        <router-link
                            :to="{ name:'bookable', params: {id: item.bookable.id} }"> {{item.bookable.title}}</router-link>
                    </span>

                            <span class="font-weight-bold">
                            {{item.price.total}}
                        </span>
                        </div>

                        <div class="pt-2 pb-2  d-flex justify-content-between">
                    <span>
                        From:  {{item.dates.from}}
                    </span>

                            <span>
                            To: {{item.dates.to}}
                        </span>
                        </div>

                        <div class="pt-2 pb-2 text-right">
                            <button @click="$store.dispatch('removeFromBasket',item.bookable.id)"
                                    class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-trash-alt">

                                </i>
                            </button>

                        </div>

                    </div>
                </transition-group>
            </div>
        </div>

    </div>
</template>

<script>
    import {mapGetters, mapState} from 'vuex';
    import validationError from '../shared/mixins/validationError';

    export default {
        name: 'Basket',
        mixins: [validationError],
        data() {
            return {
                loading: false,
                bookingAttempted: false,
                customer: {
                    firstname: null,
                    lastname: null,
                    email: null,
                    street: null,
                    city: null,
                    country: null,
                    state: null,
                    zip: null
                }
            };
        },
        computed: {
            ...mapGetters(['itemsInBasket']),
            ...mapState({
                basket: state => state.basket.items
            }),
            success() {
                return this.loading === false && this.bookingAttempted === true && this.itemsInBasket === 0;

            }

        },
        methods: {
            async book() {
                this.loading = true;
                this.errors = null;
                this.bookingAttempted = false;

                try {

                    await axios.post(`/api/checkout`, {

                        customer: this.customer,
                        bookings: this.basket.map(
                            basketItem => ({
                                bookable_id: basketItem.bookable.id,
                                from: basketItem.dates.from,
                                to: basketItem.dates.to
                            })
                        )

                    });

                    this.$store.dispatch('clearBasket');
                    this.bookingAttempted = true;
                } catch (err) {
                    this.errors = err.response && err.response.data.errors;
                }

                this.loading = false;
            }
        },
    };
</script>

<style scoped>

    h6.badge {
        font-size: 100%;
    }

    a {
        color: black;
    }

</style>
