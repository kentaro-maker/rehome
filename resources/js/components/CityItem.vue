<template>
  <div class="city panel">
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
          {{ item.prefecture_name }}
      {{ item.region_name }}

      <ul>
        <li>人口：{{ item.pop }} 人</li>
        <li>総面積：{{ item.land }} ha</li>
        <li>林野面積：{{ item.forest }} ha</li>
        <li>世帯数：{{ item.household}} 世帯</li>
        <li>幼稚園数：{{ item.yo_school }}</li>
        <li>小学校数：{{ item.sho_school }}</li>
        <li>中学校数：{{ item.chu_school }}</li>
        <li>高等学校数：{{ item.ko_school }}</li>
        <li>空家数：{{ item.empty }}</li>
        <li>公民館数：{{ item.kominkan }}</li>
        <li>図書館数：{{ item.toshokan }}</li>
        <li>ホームページ：<a target="_blank" :href="item.portal"><cite>{{ item.portal }}</cite></a></li>
        <li>病院数：{{ item.hospital }}</li>
        <li>診療所数：{{ item.clinic }}</li>
      </ul>
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