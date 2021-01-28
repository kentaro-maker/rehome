<template>
    <div>
        <div v-show="loading" class="row justify-content-center">
            <div class="card col-10 col-sm-9 col-md-8 mb-4">
                <div class="card-body">
                    <Loader/>
                </div>
            </div>
        </div>
        <div v-show="! loading" v-if="city" class="row justify-content-center">
            <div class="card col-10 col-sm-9 col-md-8 mb-4">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item active card-image-out">
                            <img class="d-block card-img-top card-image-in" :src="imgList[0].src" alt="First slide">
                        </div>
                        <div class="carousel-item card-image-out">
                        <img class="d-block card-img-top card-image-in" :src="imgList[1].src" alt="Second slide">
                        </div>
                        <div class="carousel-item card-image-out">
                        <img class="d-block card-img-top card-image-in" :src="imgList[2].src" alt="Third slide">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
                <div class="card-body">
                    <h5 class="card-title" style="font-size:3rem;font-weight:bold;">{{ city.city_name }}</h5>
                    <p class="card-text">
                         都道府県：
                        <router-link :to="{name: 'pref', params: { pref_slug: city.prefecture_slug, region_slug: city.region_slug }}">
                            {{ city.prefecture_name }}
                        </router-link>
                        、
                        地域：
                        <router-link :to="{name: 'region', params: { region_slug: city.region_slug }}">
                            {{ city.region_name }}
                        </router-link>
                    </p>
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
                    <li class="list-group-item">
                        幼稚園数：{{ city.yo_school }}、
                        小学校数：{{ city.sho_school }}、
                        中学校数：{{ city.chu_school }}、
                        高等学校数：{{ city.ko_school }}、
                        公民館数：{{ city.kominkan }}、
                        図書館数：{{ city.toshokan }}
                    </li>
                    <li class="list-group-item">空家数：{{ city.empty }}</li>
                    <li class="list-group-item">
                        病院数：{{ city.hospital }}、
                        診療所数：{{ city.clinic }}
                    </li>
                </ul>
                <div class="card-body">
                    <button class="btn btn-primary"@click="pdf(city.id)">
                        転出届ダウンロード
                    </button>
                </div>
            </div>
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
        async pdf(id){
            if (! this.$store.getters['auth/check']) {
                alert('転出届をダウンロードするにはログインしてください。')
                return false
            }
            const response = await axios.get(
                `/api/cities/${id}/pdf`, {responseType: 'arraybuffer'})

            console.log(response)
            const url = window.URL.createObjectURL(new Blob([response.data], { "type" : "application/pdf" }))
            const link = document.createElement('a')
            link.href = url
            link.setAttribute('download', 'file.pdf')
            document.body.appendChild(link)
            link.click()
        },
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