<template>
    <div>
        <div class="header">
            <h2>イベント</h2>
            <button class="button" @click="showCreateEventForm = true">イベントを作る</button>
            <router-link :to="{name: 'events.search'}" tag="button" class="button">
                イベントを探す
            </router-link>
        </div>
        <div v-if="showCreateEventForm">
            <h3>新規イベント</h3>
            <button @click="showCreateEventForm = false"><font-awesome-icon icon="times" /></button>
            <form class="form" @submit.prevent="createEvent">

                 <div v-if="createEventErrors" class="errors">
                    <ul v-if="createEventErrors.title">
                       <li v-for="msg in createEventErrors.title" :key="msg">{{ msg }}</li>
                    </ul>
                </div>

                <label for="title">タイトル</label>
                <input type="text" id="title" v-model="eventForm.title"/>

                <label for="fee">参加費</label>
                <div class="input-group">
                    <input type="text" id="fee" />
                     <div class="input-group-append">
                        <span class="input-group-text">円</span>
                    </div>
                    /1人
                </div>

                <label for="content">内容</label>
                <input type="text" id="content"/>
                
                <label for="place">開催地</label>
                <input type="text" id="plcae"/>

                <label for="parking">駐車場</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="exampleRadios" id="parkingOn" value="option1" checked>
                    <label class="form-check-label" for="parkingOn">あり</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="exampleRadios" id="parkingOff" value="option2">
                    <label class="form-check-label" for="parkingOff">なし</label>
                </div>

                <div class="form-group">
                    <label for="people">参加人数</label>
                    <input type="text" id="people"/>
                </div>
                
                <button type="submit" class="button">作成</button>
            </form>
        </div>
        <div class="content">
            <div>参加中のイベント
            </div>
            <div>主催中のイベント
                <ul>
                    <li v-for="h in hosted">
                    {{ h.title}}
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
import { OK } from '../../util'
import Loader from '../../components/Loader.vue'
import { mapState } from 'vuex'


export default {
    components: {
        Loader
    },
    data (){
        return {
            eventForm: {
                title: '',
            },
            showCreateEventForm: false,
            hosted: [],

        }
    },
    computed: mapState({
            apiStatus: state => state.event.apiStatus,
            createEventErrors: state => state.event.createErrorMessages,
    }),
    methods: {
        async createEvent() {
            console.log("createEvent")
            await this.$store.dispatch('event/create', this.eventForm)
             if (this.apiStatus) {
                await this.fetchHosted()
            }
            console.log(this.createEventErrors)
        },

        async fetchHosted () {
            const response = await axios.get('/api/event/hosted')

            if (response.status !== OK) {
                this.$store.commit('error/setCode', response.status)
                return false
            }

            console.log(response)
            this.hosted = response.data.data
        },

        clearError () {
            this.$store.commit('event/setCreateErrorMessages', null)
        },
    },
    created() {
        this.clearError()
    },
     watch: {
        $route: {
            async handler () {
                await this.fetchHosted()
                //await this.fetchPhotos()
            },
            immediate: true
        }
    }
}
</script>