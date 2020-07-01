<template>
  <div>
    <nav class="navbar bg-white border-bottom navbar-light">
      <router-link
        class="navbar-brand mr-auto"
        to="/"
      >
        home
      </router-link>

      <router-link class="btn nav-button" :to="{name:'basket'}">
        basket
        <span v-if="itemsInBasket" class="badge badge-secondary"> {{ itemsInBasket }} </span>
      </router-link>
    </nav>

    <div class="container mt-4  mb-4 pr-4 pl-4 ">
      <router-view />
    </div>
  </div>
</template>

<script>
import {mapGetters, mapState} from 'vuex';

export default  {
	name: 'index',
	data() {
		return {
			lastSearch: this.$store.state.lastSearch
		};
	},


	computed: {
		... mapState({
			lastSearchComputed: 'lastSearch'
		}),
		... mapGetters({
			itemsInBasket: 'itemsInBasket'
		})
	},
};


</script>

<style scoped>

</style>
