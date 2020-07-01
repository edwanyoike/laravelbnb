export default {
	data() {
		return {
			errors: {
			    default: null,
				type: Object
			},
		};
	},
	methods: {
		errorFor(field) {

			return this.errors !== null && this.errors[field] ? this.errors[field] : null;
		}
	},
};
