<template>
    <div>
        <h2>{{ city.name }}</h2>
        <h3>都道府県：{{ city.prefecture }}、地域：{{ city.region }}</h3>
        <RouterLink
            :to="`/photos/${city.slug}`"
            >
            <div class="photo__controls">
                <button>
                    転出届ダウンロード
                </button>
            </div>
        </RouterLink>
    </div>
</template>

<script>
import { OK } from '../util'

export default {
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
        city: null,
        }
    },
    methods: {
        async fetchCityDetail () {
            const response = await axios.get(
                `/api/region/${this.region_slug}/pref/${this.pref_slug}/city/${this.city_slug}`)

            if (response.status !== OK) {
                this.$store.commit('error/setCode', response.status)
                return false
            }
            console.log(response.data)
            this.city = response.data[0]
        }
    },
    watch: {
        $route: {
        async handler () {
            await this.fetchCityDetail()
        },
        immediate: true
        }
    }
}
</script>