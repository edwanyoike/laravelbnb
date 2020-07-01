<template>
  <div>
    <h6 class="text-uppercase text-secondary font-weight-bolder ">
      check availability

      <transition name="fade">
        <span
          v-if="hasAvailability"
          class="text-success"
        >(AVAILABLE)</span>
        <span
          v-if="noAvailability"
          class="text-danger"
        >(NOT AVAILABLE)</span>
      </transition>
    </h6>
    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="from"> From</label>
        <input
          id="from"
          v-model="from"
          :class="[{ 'is-invalid':errorFor('from')}]"
          class="form-control form-control-sm"
          name="from"

          placeholder="From Date"
          type="text"
        >

        <v-errors :errors="errorFor('from')" />
      </div>


      <div class="form-group col-md-6">
        <label for="to">To</label>
        <input
          id="to"
          v-model="to"
          :class="[{ 'is-invalid':errorFor('to')}]"
          class="form-control form-control-sm"
          name="to"
          placeholder="To Date"
          type="text"
        >

        <v-errors :errors="errorFor('to')" />
      </div>
    </div>

    <button
      :disabled="loading"
      class="btn btn-secondary btn-block"
      @click="check"
    >
      <LoadingAnimation :loading="loading">
        <span v-if="!loading">Check </span> <span
          v-if="loading"
        >Checking</span>
      </LoadingAnimation>
    </button>
  </div>
</template>

<script>
import {is422} from '../shared/utilis/response';
import validationError from '../shared/mixins/validationError';
import LoadingAnimation from '../shared/components/slots/LoadingAnimation';

export default {
	name: 'Availability',
	components: {LoadingAnimation},
	mixins: [validationError],
	props: {
		bookableId: {
			type: String,
			default:null
		},
	},
	data() {
		return {
			from: this.$store.state.lastSearch.from,
			to: this.$store.state.lastSearch.to,
			loading: false,
			status: null,
		};
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
	methods: {
		async check() {
			this.loading = true;
			this.errors = null;

			await this.$store.dispatch('setLastSearch', {
				from: this.from,
				to: this.to
			});

			try {

				this.status = (await axios.get(`/api/bookables/${this.bookableId}/availability?from=${this.from}&to=${this.to}`)).status;
				this.$emit('availability', this.hasAvailability);
			} catch (error) {

				if (is422(error)) {
					this.errors = error.response.data.errors;
				}
				this.status = error.response.status;
				this.$emit('availability', this.hasAvailability);

			}

			this.loading = false;
		},

	},

};
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
