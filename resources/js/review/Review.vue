<template>
    <div>
        <div class="form-group">
            <label class="text-muted">select Star rating (1-5)</label>
            <star-rating  v-model="review.rating"> </star-rating>
        </div>

        <div class="form-group">
            <label for="content" class="text-muted "> describe your experience with ..</label>
            <textarea name="content" id="content" cols="30" rows="10" class="form-control" v-model="review.content"></textarea>

        </div>

        <button class="btn btn-lg btn-primary btn-block">submit</button>
    </div>
</template>

<script>
    export default {
        name: "Review",

        data() {
            return {
                review: {
                    rating:0 ,
                    content:null
                }
            }
        },
    }
</script>

<style scoped>

</style>
