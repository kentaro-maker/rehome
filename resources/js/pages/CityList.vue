<template>
  <div class="city-list">
    <div v-show="loading">
      <Loader/>
    </div>
    <div v-show="! loading" class="">
      <CityItem
        v-for="city in cities"
        :key="city.id"
        :item="city"
      />
    </div>
  </div>
</template>

<script>
import { OK } from '../util'
import CityItem from '../components/CityItem.vue'
import Loader from '../components/Loader.vue'


export default {
  components: {
    CityItem,
    Loader
  },
  props: {
    region_slug: {
      type: String,
      required: true
    },
    pref_slug: {
      type: String,
      required: false
    },
  },
  data () {
    return {
      loading: false,
      cities: []
    }
  },
  methods: {
    async fetchCities () {

      this.loading = true
      var response = null
      if(this.pref_slug == null){
        response = await axios.get(`/api/region/${this.region_slug}`)
      }else{
        response = await axios.get(`/api/region/${this.region_slug}/pref/${this.pref_slug}`)
      }
      console.log('region: '+ this.region_slug);
      console.log('pref: '+ this.pref_slug);

      if (response.status !== OK) {
        this.$store.commit('error/setCode', response.status)
        return false
      }

      //  2.2秒わざと待っちゃうぞ☆
      //  ローディングを見せたいからね♪
      //setTimeout(() => this.loading = false, 2200);
      this.loading = false

      console.log(response)

      console.log(typeof(response.data))
      if(response.data.length == 0){
        this.$router.push('/not-found')
      }
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