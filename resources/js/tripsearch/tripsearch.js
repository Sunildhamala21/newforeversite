function searchDropdown() {
  return {
    keyword: '',
    selectedIndex: '',
    trips: [],
    get filteredTrips() {
      if (this.keyword === '') {
        return []
      }
      return window.Alpine.store('tripStore').trips.filter(trip => trip.name.toLowerCase().includes(this.keyword.toLowerCase()))
    },
    reset() {
      this.keyword = ''
    },
    selectNext() {
      if (this.selectedIndex === '') {
        this.selectedIndex = 0;
      } else {
        this.selectedIndex++;
      }
      if (this.selectedIndex === this.filteredTrips.length) {
        this.selectedIndex = 0;
      }
      this.focusSelected();
    },
    selectPrev() {
      if (this.selectedIndex === '') {
        this.selectedIndex = this.filteredTrips.length - 1;
      } else {
        this.selectedIndex--;
      }
      if (this.selectedIndex === -1) {
        this.selectedIndex = this.filteredTrips.length - 1;
      }
      this.focusSelected();
    },
    focusSelected() {
      this.$refs.results.children[this.selectedIndex + 1].scrollIntoView({
        block: 'nearest'
      })
    },
    handleSubmit(form) {
      if (this.selectedIndex !== '') {
        window.location.href = this.filteredTrips[this.selectedIndex].url;
      } else {
        form.submit();
      }
    }
  }
}
window.searchDropdown = searchDropdown;

window.Alpine.store('tripStore', {
  init() {
    this.trips = JSON.parse(document.querySelector('#tripsJson').innerText);
  },
  trips: []
})