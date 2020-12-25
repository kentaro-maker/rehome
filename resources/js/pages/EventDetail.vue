<template>
    <div v-if="event">
        {{ event.title }}
        <button
            class="button button--like"
            :class="{ 'button--liked': event.liked_by_user }"
            title="Like photo"
            @click="onLikeClick"
            >
            <i class="icon ion-md-heart"></i>{{ event.likes_count }}
            </button>
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
        id: {
            type: [Number,String],
            required: true
        },
    },
    data () {
        return {
            loading: false,
            event: null,
        }
    },
    methods: {
        onLikeClick () {
            if (! this.$store.getters['auth/check']) {
                alert('いいね機能を使うにはログインしてください。')
                return false
            }

            if (this.event.liked_by_user) {
                this.unlike()
            } else {
                this.like()
            }
        },
        async like () {
            const response = await axios.put(`/api/events/${this.event.id}/like`)

            if (response.status !== OK) {
                this.$store.commit('error/setCode', response.status)
                return false
            }

            this.event.likes_count = this.event.likes_count + 1
            this.event.liked_by_user = true
        },
        async unlike () {
            const response = await axios.delete(`/api/events/${this.id}/like`)

            if (response.status !== OK) {
                this.$store.commit('error/setCode', response.status)
                return false
            }

            this.event.likes_count = this.event.likes_count - 1
            this.event.liked_by_user = false
        },
        async fetchEventDetail () {

            const response = await axios.get(`/api/event/detail/${this.id}`).catch(error => error.response || error)
            console.log("------")
            console.log(response)
            console.log("------")
            if (response.status !== OK) {
                this.$store.commit('error/setCode', response.status, { root: true })
                return false
            }

            //setTimeout(() => this.loading = false, 1800);

            
            console.log(response.data)
            this.event = response.data
        }
    },
    watch: {
        $route: {
            async handler () {
                await this.fetchEventDetail()
            },
        immediate: true
        }
    }
}
</script>