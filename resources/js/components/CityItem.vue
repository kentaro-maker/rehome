<template>
  <div class="card col-10 col-sm-9 col-md-8 mb-4">
    <div class="card-body">
      <h5 class="card-title" style="font-size:3rem;font-weight:bold;">
      <router-link
      :to="{
        name: 'city',
        params: {
          region_slug: city.region,
          pref_slug:   city.prefecture,
          city_slug:   city.slug
        }
      }"
    >
      {{ city.name }}
    </router-link>
    </h5>
      <p class="card-text">
        ホームページ：
        <a target="_blank" :href="city.portal">
          <cite>{{ city.portal }}</cite>
        </a>
      </p>
    </div>
    <ul class="list-group list-group-flush">
      <li class="list-group-item">
        人口：{{ city.pop }}人、
        世帯数：{{ city.household}}世帯
      </li>
      <li class="list-group-item">総面積：{{ city.land }} ha</li>
    </ul>
  </div>

</template>

<script>
export default {
  props: {
    city: {
      type: Object,
      required: true
    }
  },
}
</script>