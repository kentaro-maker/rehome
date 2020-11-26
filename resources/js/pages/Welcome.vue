<template>
    <div>
        <h1>Welcome</h1>
        <div class="grid">
            <SearchForm />
        </div>
        <RegionMapForm />
    </div>
</template>

<script>
import SearchForm from '../components/SearchForm.vue'
import RegionMapForm from '../components/RegionMapForm.vue'

export default {
  components: {
    SearchForm,
    RegionMapForm,
  },
  data () {
    return {
      photos: []
    }
  }
}
</script>