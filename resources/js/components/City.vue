<template>
  <div class="city">
    <router-link
      :to="{
        name: 'city',
        params: {
          region_slug: item.region,
          pref_slug:   item.prefecture,
          city_slug:   item.slug
        }
      }"
    >
      {{ item.name }}
    </router-link>
  </div>
</template>

<script>
export default {
  props: {
    item: {
      type: Object,
      required: true
    }
  },
}
</script>