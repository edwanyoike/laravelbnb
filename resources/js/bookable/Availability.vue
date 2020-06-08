<template>
    <div>


            <h6 class="text-uppercase text-secondary font-weight-bolder ">check availability

                <transition name="fade">
            <span v-if="hasAvailability" class="text-success">(AVAILABLE)</span>
            <span v-if="noAvailability" class="text-danger">(NOT AVAILABLE)</span>
                </transition>

        </h6>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="from"> From</label>
                <input type="text" id="from" name="from" class="form-control form-control-sm" placeholder="From Date"
                       v-model="from"
                       :class="[{ 'is-invalid':this.errorFor('from')}]"

                />

                <v-errors :errors="errorFor('from')"></v-errors>


            </div>


            <div class="form-group col-md-6">
                <label for="to">To</label>
                <input type="text" id="to" name="to" class="form-control form-control-sm" placeholder="To Date"
                       v-model="to"
                       :class="[{ 'is-invalid':errorFor('to')}]"

                />

                <v-errors :errors="errorFor('to')"></v-errors>


            </div>

        </div>

        <button class="btn btn-secondary btn-block" @click="check" :disabled="loading">

            <LoadingAnimation :loading ="loading"> <span v-if="!loading">Check </span> <span v-if="loading">Checking</span> </LoadingAnimation>

        </button>


    </div>

</template>

<script>
    import {is422} from "../shared/utilis/response";
    import validationError from "../shared/mixins/validationError";
    import LoadingAnimation from "../shared/components/slots/LoadingAnimation";

    export default {
        name: "Availability",
        components: {LoadingAnimation},
        mixins: [validationError],
        props: {
            bookableId: {
                type: String,
            },
        },
        data() {
            return {
                from: this.$store.state.lastSearch.from,
                to: this.$store.state.lastSearch.to,
                loading: false,
                status: null,
            }
        },
        methods: {
            check() {
                this.loading = true;
                this.errors = null;

                this.$store.dispatch('setLastSearch',{
                    from: this.from,
                    to: this.to
                })


                axios.get(`/api/bookables/${this.bookableId}/availability?from=${this.from}&to=${this.to}`)
                    .then(
                        response => {
                            this.status = response.status;

                        }
                    ).catch(error => {
                    if (is422(error)) {
                        this.errors = error.response.data.errors;
                    }
                    this.status = error.response.status;

                }).then(() => (this.loading = false));
            },

        },
        computed: {
            hasErrors() {
                return this.status === 422 & this.errors != null;
            },
            hasAvailability() {
                return this.status === 200;
            },
            noAvailability() {
                return this.status === 404;
            }
        },

    }
</script>

<style scoped>
    label {
        font-size: 0.7rem;
        text-transform: uppercase;
        color: grey;
        font-weight: bolder;
    }

    .is-invalid {
        border-color: #bb2222;
        background-image: none;
    }

    .invalid-feedback {
        border-color: #bb2222;

    }
</style>
