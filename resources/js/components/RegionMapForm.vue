<template>
    <div class="container-item">
        <h3 class="title">地域から探す</h3>
        <div class="row">
            <div class="col-12 col-md-6 order-2 order-md-1">
                <ul class="region-list-group">
                    <li v-for="region in zenkoku" class="region-list-group__item">
                        <ul class="region-nav align-items-center">
                            <li class="region-nav__item">
                                <router-link :to="{name: 'region', params: { region_slug: region.slug }}"  class="region-nav__link">
                                    {{ region.name }}
                                </router-link>
                            </li>
                            <li v-for="pref in region.prefs" class="region-nav__item">
                                <router-link :to="{name: 'pref', params: { pref_slug: pref.slug, region_slug: region.slug }}"  class="region-nav__link">
                                    {{ pref.name }}
                                </router-link>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="col-12 col-md-6 order-ms-2 order-1">
                <img src="https://i.ibb.co/rx6xbTM/zenkoku.png" usemap="#image-map" style="max-width:100%;">
            </div>
        </div>
        <map name="image-map">
            <template v-for="region in zenkoku">
                <router-link :to="{ name: 'region', params: { region_slug: region.slug }}" >
                    <area shape="poly"
                    :alt="region.name"
                    :title="region.name"
                    :coords="region.coords"/>
                </router-link>
            </template>
        </map>
    </div>
</template>

<script>
import { CREATED, UNPROCESSABLE_ENTITY } from '../util'
import Loader from './Loader.vue'
import zenkokuJson from '../assets/zenkoku.json'

import ImageMapResizer from "image-map-resizer";

export default {
    components: {
        Loader
    },
    data() {
        return{
            zenkoku: zenkokuJson,
            loading: false,
            errors: null,
        }
    },
    methods: {
        submit () {
            this.loading = true
        },
    },
    mounted() {
        ImageMapResizer()
    },
}
</script>