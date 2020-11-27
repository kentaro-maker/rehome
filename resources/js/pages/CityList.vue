<template>
  <div class="city-list">
    <div class="">
      <City
        v-for="city in cities"
        :key="city.id"
        :item="city"
      />
    </div>
  </div>
</template>

<script>
import { OK } from '../util'
import City from '../components/City.vue'

export default {
  components: {
    City
  },
  props: {
    region_slug: {
      type: String,
      required: true
    },
  },
  data () {
    return {
      cities: []
    }
  },
  methods: {
    async fetchCities () {
      const response = await axios.get(`/api/region/${this.region_slug}`)

      if (response.status !== OK) {
        this.$store.commit('error/setCode', response.status)
        return false
      }
      console.log(response.data)
      this.cities = response.data
    }
  },
  watch: {
    $route: {
      async handler () {
        await this.fetchCities()
      },
      immediate: true
    }
  }
}
</script>