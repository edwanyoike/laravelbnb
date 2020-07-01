<template>
  <div>
    <h6 class="text-uppercase text-secondary font-weight-bolder ">
      Price break down
    </h6>

    <div
      v-for="(days,price) in priceCalculated.breakdown "
      :key="price"
      class="pt-2 pb-2 border-bottom border-top d-flex justify-content-between"
    >
      <span> {{ days }} days x Kshs. {{ price }} per day </span> <span> Kshs. {{ days * price }}</span>
    </div>

    <div class="pt-2 pb-2 border-bottom border-top d-flex justify-content-between">
      Total = Kshs. {{ priceCalculated.total }}
    </div>
  </div>
</template>

<script>
export default {
	name: 'PriceBreakdown',
	props: {
		priceCalculated: {
			type: Object,
			default: null,
		},
	},
};
</script>

<style scoped>

</style>
