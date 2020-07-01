<template>
  <div>
    <div v-if="loading">
      Loading ...
    </div>
    <div v-else>
      <div
        v-for="row in rows "
        :key="'row'+row"
        class="row mb-4"
      >
        <div
          v-for="(bookable,column) in bookablesInRow(row)"
          :key="'row' + row + column"
          class="col d-flex align-items-stretch"
        >
          <BookableListItem v-bind="bookable" />
        </div>


        <div
          v-for="p in placeHoldersInRow(row)"
          :key=" 'placeholder' +row +p "
          class="col"
        />
      </div>
    </div>
  </div>
</template>

<script>
import BookableListItem from './BookableListItem';

export default {
	components: {
		BookableListItem,

	},
	data() {
		return {
			bookables: null,
			loading: true,
			columns: 3
		};
	},
	computed: {
		rows() {
			return this.bookables == null ? 0 : Math.ceil(this.bookables.length / this.columns);
		}
	},

	created() {
		this.loading = true;
		const request = axios.get('/api/bookables').then(response => {
			this.bookables = response.data.data;
			this.loading = false;
		});

	},
	methods: {
		bookablesInRow(row) {
			return this.bookables.slice((row - 1) * this.columns, row * this.columns);

		},
		placeHoldersInRow(row) {
			return this.columns - this.bookablesInRow(row).length;

		}
	}

};
</script>

<style scoped>

</style>
