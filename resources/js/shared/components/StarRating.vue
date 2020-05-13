<template>

    <div class="d-flex">
        <i class="fas fa-star" v-for="star in fullStar" :key=" 'full'+ star "></i>
        <i class="fas fa-star-half-alt" v-if="halfStar"></i>
        <i class="far fa-star" v-for="star in emptyStar" :key=" 'full'+ star"></i>
    </div>

</template>

<script>
    export default {
        name: "StarRating",
        props: {
            rating: {
                type: Number,
                default: 0
            },
        },
        computed: {
            halfStar() {
                const fraction = Math.round((this.rating - Math.floor(this.rating)) * 100)

                return fraction > 0 && fraction < 50 ;
            }, fullStar() {
                return Math.round(this.rating)
            }, emptyStar() {
                return 5 - Math.ceil(this.rating);
            },

        },
    }
</script>

<style scoped>

</style>
