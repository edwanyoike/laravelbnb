<template>
    <div>
        <div class="row">
            <div class="col-md-8 pb-4" v-if="bookable">
                <div class="card ">
                    <div class="card-body ">
                        <h2> {{bookable.title}}</h2>
                        <hr/>

                        <article>{{bookable.description}}</article>

                    </div>



                </div>

                <div>
                    <ReviewList :bookable-id="this.$route.params.id"></ReviewList>
                </div>

            </div>
            <div class="col-md-4 pb-4" >
                <availability :bookable-id="this.$route.params.id"></availability>
            </div>

        </div>


    </div>
</template>

<script>
    import Availability from "./Availability";
    import ReviewList from "./ReviewList";

    export default {
        components: {Availability,ReviewList},
        name: "Bookable",

        data() {
            return {
                bookable: null,

            }
        },
        created() {
            console.log(this.$route.params.id);
            axios.get(`/api/bookables/${this.$route.params.id}`).then(response => (this.bookable = response.data.data));
        }


    }
</script>

<style scoped>

</style>
