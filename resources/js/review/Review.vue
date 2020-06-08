<template>

    <div>
        <fatal-error v-if="error"></fatal-error>
        <success v-if="success"></success>

        <div class="row" v-if="!success && !error">

            <div :class="[{'col-md-4': oneColumn},{'d-none':twoColumn}]">

                <div class="card">
                    <div class="card-body">
                        <div v-if="loading">
                            Loading ...

                        </div>

                        <div v-if="hasBooking">
                            <p>
                                stayed at
                                <router-link :to="{ name:'bookable', params:{id: booking.bookable.id} }">
                                    {{booking.bookable.title}}
                                </router-link>
                            </p>
                            <p>
                                from {{booking.from}} to {{booking.to}}
                            </p>

                        </div>

                    </div>


                </div>
            </div>

            <div :class="[{'col-md-8':oneColumn},{'col-md-12': twoColumn}]">
                <div v-if="loading">
                    loading ...
                </div>

                <div v-else>

                    <div v-if="alreadyReviewed">
                        a review exist already
                    </div>

                    <div v-if="hasBooking">

                        <div class="form-group">
                            <label class="text-muted">select Star rating (1-5)</label>
                            <star-rating v-model="review.rating"></star-rating>
                        </div>

                        <div class="form-group">

                            <label class="text-muted " for="content"> describe your experience with ..</label>
                            <textarea :class="[{ 'is-invalid':errorFor('content')}]" class="form-control" cols="30"
                                      id="content" name="content"
                                      rows="10"
                                      v-model="review.content"

                            ></textarea>

                            <v-errors :errors="errorFor('content')"></v-errors>

                        </div>

                        <button :disabled="sending" @click.prevent="submitReview"
                                class="btn btn-lg btn-primary btn-block">submit
                        </button>
                    </div>

                </div>

            </div>


        </div>

    </div>
</template>

<script>
    import {is404, is422} from "../shared/utilis/response";
    import validationError from "../shared/mixins/validationError";

    export default {
        name: "Review",
        mixins: [validationError],
        data() {
            return {
                review: {
                    id: null,
                    rating: 0,
                    content: null
                },
                existingReview: null,
                booking: null,
                loading: false,
                error: false,
                sending: false,
                success: false,

            }
        },

        methods: {
          async  submitReview() {
                this.loading = false;
                this.sending = true;
                this.errors = null;
              this.success = false;


              try {
                    await axios.post(`/api/reviews`, this.review);
                    this.success = true;
                }
                catch (error) {

                    if (is422(error)) {
                        const errors = error.response.data.errors;
                        if (errors["content"] && _.size(errors) === 1) {
                            this.errors = errors;
                        }


                    }

                }


              this.loading = false;
              this.sending = false;
            },
        },

        computed: {
            alreadyReviewed() {
                return this.hasReview;
            },
            hasReview() {
                return this.existingReview != null;

            },
            hasBooking() {
                return this.booking !== null;
            },
            oneColumn() {
                return this.loading || !this.alreadyReviewed
            },
            twoColumn() {
                return !this.loading && this.alreadyReviewed
            }
        },

        async created() {
            this.review.id = this.$route.params.id;
            this.loading = true;

            try {
                this.existingReview = (await axios.get(`/api/reviews/${this.review.id}`)).data.data;
            } catch (e) {
                if (is404(e)) {

                    try {
                        this.booking = (await axios.get(`/api/booking-by-review/${this.review.id}`)).data.data;

                    } catch (error) {

                        this.error = !is404(error);
                    }


                } else {
                    this.error = true
                }

            }
            this.loading = false;

        }
    }
</script>


