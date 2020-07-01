<template>
  <div>
    <div class="row">
      <div
        v-if="bookable"
        class="col-md-8 pb-4"
      >
        <div class="card ">
          <div class="card-body ">
            <h2> {{ bookable.title }}</h2>
            <hr>

            <article>{{ bookable.description }}</article>
          </div>
        </div>

        <div>
          <ReviewList :bookable-id="this.$route.params.id" />
        </div>
      </div>
      <div class="col-md-4 pb-4">
        <availability
          :bookable-id="this.$route.params.id"
          class="mb-4"
          @availability="checkPrice($event)"
        />

        <transition name="fade">
          <PriceBreakdown
            v-if="price"
            :price-calculated="price"
          />
        </transition>
        <transition name="fade">
          <button
            v-if="price"
            :disabled="inBasketAlready"
            class="btn btn-outline-secondary btn-block"
            @click="addToBasket"
          >
            Book Now
          </button>
        </transition>

        <transition name="fade">
          <button
            v-if="inBasketAlready"
            class="btn btn-outline-secondary btn-block"
            @click="removeFromBasket"
          >
            remove from basket
          </button>
        </transition>

        <div
          v-if="inBasketAlready"
          class="mt-4  text-danger"
        >
          already added
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Availability from './Availability';
import ReviewList from './ReviewList';
import {mapState} from 'vuex';
import PriceBreakdown from './PriceBreakdown';

export default {
	name: 'Bookable',
	components: {Availability, ReviewList, PriceBreakdown},

	data() {
		return {
			bookable: null,
			price: null

		};
	},
	computed: {

		...mapState({
			lastSearch: 'lastSearch',
			inBasketAlready(){
				if (this.bookable === null) {
					return false;
				}
				return this.$store.getters.inBasketAlready(this.bookable.id);

			}
		}),



	},

	created() {
		axios.get(`/api/bookables/${this.$route.params.id}`).then(response => (this.bookable = response.data.data));
	},

	methods: {
		async checkPrice(hasAvailability) {

			if (!hasAvailability) {
				this.price = null;
				return;
			}
			this.price = (await axios.get(`/api/bookables/${this.bookable.id}/price?from=${this.lastSearch.from}&to=${this.lastSearch.to}`)).data.data;

		},

		addToBasket() {
			this.$store.dispatch('addToBasket', {
				bookable: this.bookable,
				price: this.price,
				dates: this.lastSearch
			});

		},
		removeFromBasket() {
			this.$store.dispatch('removeFromBasket', this.bookable.id);
		}
	},


};
</script>

<style scoped>
    .warning {
        font-size: 0.7rem;
    }
</style>
