<template>
  <div class="d-flex">
    <i
      v-for="(star) in fullStar"
      :key=" 'full'+ star "
      class="fas fa-star"
      @click="$emit('input',star)"
    />
    <i
      v-if="halfStar"
      class="fas fa-star-half-alt"
    />
    <i
      v-for="star in emptyStar"
      :key=" 'empty'+ star"
      class="far fa-star"
      @click="$emit('input',fullStar+star)"
    />
  </div>
</template>

<script>
export default {
	name: 'StarRating',
	props: {
		value: {
			type: Number,
			default: 0
		},
	},
	computed: {
		halfStar() {
			const fraction = Math.round((this.value - Math.floor(this.value)) * 100);

			return fraction > 0 && fraction < 50;
		}, fullStar() {
			return Math.round(this.value);
		}, emptyStar() {
			return 5 - Math.ceil(this.value);
		},

	},
};
</script>

<style scoped>

</style>
