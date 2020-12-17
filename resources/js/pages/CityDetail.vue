<template>
    <div>
        <div v-show="loading">
            <Loader/>
        </div>
        <div v-show="! loading" v-if="city">
            <img :src="img.src" :alt="imgList.alt" v-for="img in imgList">
            
            <h1 v-if="city">{{ city.city_name }}</h1>
            <h3>
                都道府県：
                <router-link :to="{name: 'pref', params: { pref_slug: city.prefecture_slug, region_slug: city.region_slug }}">
                    {{ city.prefecture_name }}
                </router-link>
            </h3>
            
            <h3>
                地域：
                <router-link :to="{name: 'region', params: { region_slug: city.region_slug }}">
                    {{ city.region_name }}
                </router-link>
            </h3>

            <ul>
                <li>人口：{{ city.pop }} 人</li>
                <li>総面積：{{ city.land }} ha</li>
                <li>世帯数：{{ city.household}} 世帯</li>
                <li>幼稚園数：{{ city.yo_school }}</li>
                <li>小学校数：{{ city.sho_school }}</li>
                <li>中学校数：{{ city.chu_school }}</li>
                <li>高等学校数：{{ city.ko_school }}</li>
                <li>空家数：{{ city.empty }}</li>
                <li>公民館数：{{ city.kominkan }}</li>
                <li>図書館数：{{ city.toshokan }}</li>
                <li>ホームページ：<a target="_blank" :href="city.portal"><cite>{{ city.portal }}</cite></a></li>
                <li>病院数：{{ city.hospital }}</li>
                <li>診療所数：{{ city.clinic }}</li>
            </ul>

            <router-link
                :to="`/photos/${city.slug}`"
                >
                <div class="photo__controls">
                    <button>
                        転出届ダウンロード
                    </button>
                </div>
            </router-link>
        </div>
    </div>
</template>

<script>
import { OK } from '../util'
import Loader from '../components/Loader.vue'


export default {
    components: {
        Loader
    },
    props: {
        region_slug: {
            type: String,
            required: true
        },
        pref_slug: {
            type: String,
            required: true
        },
        city_slug: {
            type: String,
            required: true
        },
    },
    data () {
        return {
            loading: false,
            city: null,
            imgList:[],
        }
    },
    methods: {
        async fetchCityDetail () {

            this.loading = true

            const response = await axios.get(
                `/api/region/${this.region_slug}/pref/${this.pref_slug}/city/${this.city_slug}`)

            if (response.status !== OK) {
                this.$store.commit('error/setCode', response.status)
                return false
            }

            //setTimeout(() => this.loading = false, 1800);

            this.loading = false
            
            console.log(response.data)
            this.city = response.data[0]
        }
    },
    watch: {
        city:function() {
            for(var i = 1; i <= 5; i++) {
                var src = "/storage/images/cities/"
                    + this.city.region_slug + "/"
                    + this.city.prefecture_slug + "/"
                    + this.city_slug + "/"
                    + this.city_slug + "-" + i + ".jpg"
                var alt = this.city.prefecture_name + " " + this.city.city_name + "の画像"
                this.imgList.push({src: src, alt:alt})
            }
        },
        $route: {
            async handler () {
                await this.fetchCityDetail()
            },
        immediate: true
        }
    }
}
</script>