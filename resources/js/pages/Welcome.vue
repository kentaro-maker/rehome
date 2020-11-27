<template>
    <div>
        <h1>あなたにぴったりの町を探そう</h1>
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
}
</script>