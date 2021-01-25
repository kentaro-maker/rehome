<template>
    <div class="container row flex justify-content-center">
      <div class="col-10">
        <h2 class="title__h2">市町村を探す</h2>
        <SearchForm />
        <RegionMapForm />
        <Conditions />
      </div>
    </div>
</template>

<script>
import SearchForm from '../components/SearchForm.vue'
import RegionMapForm from '../components/RegionMapForm.vue'
import Conditions from '../components/Conditions.vue'

export default {
  components: {
    SearchForm,
    RegionMapForm,
    Conditions,
  },
}
</script>