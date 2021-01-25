<template>
    <div v-if="event">
        {{ event.title }}
        <h2 class="photo-detail__title">
            <font-awesome-icon icon="comment" />Comments
        </h2>
        <ul v-if="event.comments.length > 0" class="photo-detail__comments">
            <li
                v-for="comment in event.comments"
                :key="comment.content"
                class="photo-detail__commentItem"
            >
                <p class="photo-detail__commentBody">
                    {{ comment.content }}
                </p>
                <p class="photo-detail__commentInfo">
                    {{ comment.author.name }}
                </p>
            </li>
        </ul>
        <p v-else>コメントはありません</p>
        <form v-if="isLogin" @submit.prevent="addComment" class="form">
            <div v-if="commentErrors" class="errors">
                <ul v-if="commentErrors.content">
                    <li v-for="msg in commentErrors.content" :key="msg">{{ msg }}</li>
                </ul>
            </div>
            <textarea class="form__item" v-model="commentContent"></textarea>
            <div class="form__button">
                <button type="submit" class="button button--inverse">コメントを投稿</button>
            </div>
        </form>

        <button
            class="button button--like"
            :class="{ 'button--liked': event.liked_by_user }"
            title="Like photo"
            @click="onLikeClick"
            >
            <font-awesome-icon icon="heart" />{{ event.likes_count }}
        </button>

        <button
            class="button button--like"
            title="イベントに申し込む"
            @click="onApplyClick"
            >
            <font-awesome-icon icon="file-signature" />イベントに申し込む
        </button>
    </div>
</template>

<script>
import { OK, CREATED, UNPROCESSABLE_ENTITY } from '../util'
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
            commentContent: '',
            commentErrors: null,
        }
    },
    computed: {
        isLogin () {
            return this.$store.getters['auth/check']
        }
    },
    methods: {
        onLikeClick () {
            if (! this.isLogin) {
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
        onApplyClick () {
            if (! this.isLogin) {
                alert('イベント参加を申し込むにはログインしてください。')
                return false
            }

            if (this.event.applied_by_user) {
                this.unapply()
            } else {
                this.apply()
            }
        },
        async apply () {
            const response = await axios.put(`/api/events/${this.event.id}/like`)

            if (response.status !== OK) {
                this.$store.commit('error/setCode', response.status)
                return false
            }

            this.event.likes_count = this.event.likes_count + 1
            this.event.liked_by_user = true
        },
        async unapply () {
            const response = await axios.delete(`/api/events/${this.id}/like`)

            if (response.status !== OK) {
                this.$store.commit('error/setCode', response.status)
                return false
            }

            this.event.likes_count = this.event.likes_count - 1
            this.event.liked_by_user = false
        },
        async fetchEvent () {

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
        },
        async addComment () {
            const response = await axios.post(`/api/events/${this.id}/comments`, {
                content: this.commentContent
            })

            // バリデーションエラー
            if (response.status === UNPROCESSABLE_ENTITY) {
                this.commentErrors = response.data.errors
                return false
            }

            this.commentContent = ''
            // エラーメッセージをクリア
            this.commentErrors = null

            // その他のエラー
            if (response.status !== CREATED) {
                this.$store.commit('error/setCode', response.status)
                return false
            }

            this.event.comments = [
                response.data,
                ...this.event.comments
            ]
            console.log(this.event.comments)
        }
    },
    watch: {
        $route: {
            async handler () {
                await this.fetchEvent()
            },
        immediate: true
        }
    }
}
</script>