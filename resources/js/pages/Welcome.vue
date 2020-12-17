<template>
    <div class="row">
        <div class="col-8">
          <h2 class="title__h2">市町村を探す</h2>
          
          <SearchForm />
          <RegionMapForm />
          <Conditions />
        </div>
        <div class="col-4">
          <div class="card mb-4">
            <h5 class="card-header">お気に入り</h5>
            <div class="card-body">
              <p class="card-text text-center">最近お気に入りに入れた市町村の履歴が見られます。</p>
              <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
          </div>
          <div class="card mb-4">
            <h5 class="card-header">閲覧履歴</h5>
            <div class="card-body">
              <p class="card-text text-center">最近閲覧した市町村の履歴が見られます。</p>
              <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
          </div>
          <div class="card mb-4">
            <h5 class="card-header">検索履歴</h5>
            <div class="card-body">
              <p class="card-text text-center">最近検索した市町村の履歴が見られます。</p>
              <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
          </div>
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