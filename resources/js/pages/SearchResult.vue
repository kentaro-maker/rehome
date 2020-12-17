<template>
    <div class="city-list">
      <form class="form" @submit.prevent="keyword_search">
            
            <div v-if="searchErrors" class="errors">
                {{ searchErrors }}
            </div>

            <div v-show="loading">
                <Loader>検索中</Loader>
            </div>
            <div v-show="! loading">
                <p>{{ keywordData }}</p>
                <input class="form__item" type="text" v-model="keyword">
                <div class="form__button">
                    <button type="submit" class="button button--inverse">検索</button>
                </div>
            </div>
        </form>
        <div v-show="load"><Loader>検索中</Loader></div>
        <div v-show="! load">
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
  data () {
    return {
      loading: false,
      load:false,
      cities: [],
      keyword: this.$route.query.keyword,
      pop: this.$route.query.pop,
      land: this.$route.query.land,
      empty: this.$route.query.empty,
      searchErrors: null,
      keywordData: '',

    }
  },
  computed: {
    citieslist () {
      return this.$store.getters['search/cities']
    }
  },
  methods: {
    async keyword_search () {
            this.loading = true

            const response = await axios.post(
                'api/search',{keyword:this.keyword}
                ).catch(
                    err => err.response || err
                )
                            console.log(response)

    },
    async fetchCities () {
      var popArr = this.pop ? this.pop.split('to') : []
      var landArr = this.land ? this.land.split('to') :[]
      var emptyArr = this.empty ? this.empty.split('to') :[]
      this.load = true

      if(this.$store.getters['search/check']){
        this.cities = await this.$store.getters['search/cities']
        console.log("true")
        console.log(await this.$store.getters['search/cities'])
      }else{
        console.log("keyword"  + this.keyword)
        const response = await axios.post(
                '/api/search',{
                  keyword:this.keyword,
                  pop:popArr,
                  land:landArr,
                  empty:emptyArr
                  }
                ).catch(
                    err => err.response || err
                )
        this.cities = response.data.data
        console.log("false")
      }
      this.load = false
    }
  },
  watch: {
    $route: {
      async handler () {
        await this.fetchCities()
        //await this.keyword_search()
      },
      immediate: true
    }
  }
}
</script>