<template>
  <div class="card w-100">
    <div class="card-body">
      <router-link :to="{name: 'bookable', params:{id}}">
        <h5 class="card-title">
          {{ title }}
        </h5>
      </router-link>

      <p class="card-text">
        {{ description }}
      </p>
    </div>
  </div>
</template>

<script>
export default {
	name: 'BookableListItem',
	props: {
		title: {
			type: String,
			default: null
		},
		description: {

			type: String,
			default: null
		},

		id: {
			type: [String, Number],
			default: null
		},
	},
};

</script>

<style scoped>

</style>
