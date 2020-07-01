<template>
  <div>
    <div
      v-for="(error,index) in errors"
      :key="key(index)"
      class="invalid-feedback"
    >
      {{ error }}
    </div>
  </div>
</template>

<script>

export default {
	name: 'ValidationErrors',
	//props: ['errors'],
	props: {
		errors: {
			type: Object,
			default: null
		}
	},
	methods: {
		key(index) {
			return `validation_error_${index}_${Math.random()}`;
		}
	},
};
</script>

<style scoped>
    .form-control.is-invalid ~ div > .invalid-feedback {
        display: block;
    }

</style>

