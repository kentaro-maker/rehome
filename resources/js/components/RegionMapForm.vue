<template>
    <div class="">
        <div>
            <h2 class="title">地域から探す</h2>
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
    
            <img :src="'/storage/images/zenkoku.svg'" usemap="#image-map">
            <map name="image-map">
                <router-link :to="{ name: 'region', params: { region_slug: 'hokkaido' }}" >
                    <area shape="poly" alt="hokkaido" title="北海道" coords="409,147,370,120,345,144,313,112,349,79,368,20,427,63,460,50,460,89,439,97"/>
                </router-link>
            
                <router-link :to="{ name: 'region', params: { region_slug: 'tohoku' }}" >
                    <area shape="poly" alt="東北" title="東北" coords="331,146,295,159,277,242,299,256,291,274,330,290,344,230"/>
                </router-link>

                <router-link :to="{ name: 'region', params: { region_slug: 'koshinetsu-hokuriku' }}" >
                    <area shape="poly" alt="甲信越・北陸" title="甲信越・北陸" coords="299,256,277,242,273,260,213,305,215,326,274,310" />
                </router-link>
                
                <router-link :to="{ name: 'region', params: { region_slug: 'kanto' }}" >
                    <area shape="poly" alt="関東" title="関東" coords="291,274,274,310,293,350,320,336,330,290"/>
                </router-link>

                <router-link :to="{ name: 'region', params: { region_slug: 'tokai' }}" >
                    <area shape="poly" alt="東海" title="東海" coords="293,350,274,310,215,326,220,376,236,354"/>
                </router-link>

                <router-link :to="{ name: 'region', params: { region_slug: 'kansai' }}" >
                    <area shape="poly" alt="関西" title="関西" coords="220,376,213,305,186,316,177,362,188,402"/>
                </router-link>
                
                <router-link :to="{ name: 'region', params: { region_slug: 'chugoku' }}" >
                    <area shape="poly" alt="中国" title="中国" coords="177,362,186,316,67,367,73,381" />
                </router-link>

                <router-link :to="{ name: 'region', params: { region_slug: 'shikoku' }}" >
                    <area shape="poly" alt="四国" title="四国" coords="114,422,105,387,167,372,164,416"/>
                </router-link>
                
                <router-link :to="{ name: 'region', params: { region_slug: 'kyushu' }}" >
                    <area shape="poly"alt="kyushu" title="九州" coords="50,465,34,389,84,385,97,440"/>
                </router-link>
                
                <router-link :to="{ name: 'region', params: { region_slug: 'okinawa' }}" >
                    <area shape="poly"alt="okinawa" title="沖縄"coords="327,425,380,403,319,454"/>
                </router-link>
            </map>
        </div>
    </div>
</template>

<script>
import { CREATED, UNPROCESSABLE_ENTITY } from '../util'
import Loader from './Loader.vue'
import zenkokuJson from '../assets/zenkoku.json'

import ImageMap from "image-map";

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
        //ImageMap('img[usemap]')
    },
}
</script>