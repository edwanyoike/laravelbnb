<template>

    <div>
        <h6 class="text-uppercase text-secondary font-weight-bolder pt-4"> reviews</h6>

        <div v-if="loading">
            loading ...
        </div>
        <div v-else>
            <div :key="index" class="border-bottom d-none d-block " v-for="(review,index) in reviews ">
                <div class="row pt-4">
                    <div class="col-md-6">edwin</div>

                    <div class="col-md-6 d-flex justify-content-end">
                        <StarRating :rating="review.rating"></StarRating>

                    </div>

                </div>


                <div class="row">
                    <div class="col-md-12">{{review.created_at | fromNow}}</div>

                </div>

                <div class="row pt-4 pb-4">
                    <div class="col-md-12">{{review.content}}</div>

                </div>
            </div>

        </div>


    </div>
</template>

<script>
    import StarRating from "../shared/components/StarRating";

    export default {
        name: "ReviewList",
        components: {StarRating},
        props: {
            bookableId: {
                type: String,
            },
        },
        data() {
            return {
                loading: null,
                reviews: null,

            }
        },
        created() {
            this.loading = true;
            axios.get(`/api/bookables/${this.bookableId}/reviews`)
                .then(response => (this.reviews = response.data.data))
                .then(() => (this.loading = false))
        },

    }
</script>

<style scoped>

</style>
