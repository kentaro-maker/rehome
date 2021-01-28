<template>
  <div class="container row flex justify-content-center">
    <div class="event-list col-10">
      <div class="row m-0">
        <div class="align-self-end mb-3">
          <h2 class="title__h2">イベント一覧</h2>
        </div>
        <div class="ml-auto">
          <p class="page-info" style="color:#fff;">総イベント数：{{ total }}</p>
          <p class="page-info" style="color:#fff;">{{ per_page }}件ずつ表示</p>
          <p class="page-info" style="color:#fff;">{{ from }}件目から{{ to }}件目を表示</p>
        </div>
      </div>
      <div v-show="loading">
        <div class="card w-100 grid__item" >
          <div class="card-body">
            <Loader/>
          </div>
        </div>
        <div class="card w-100 grid__item">
          <div class="card-body">
            <Loader/>
          </div>
        </div>
        <div class="card w-100 grid__item">
          <div class="card-body">
            <Loader/>
          </div>
        </div>
      </div>
      <div v-show="! loading">
        <EventItem
          class="grid__item"
          v-for="event in events"
          :key="event.id"
          :item="event"
          @like="onLikeClick"
          @apply="onApplyClick"
        />
      </div>
      <Pagination :current-page="currentPage" :last-page="lastPage" />

    </div>
  </div>
</template>

<script>
import { OK } from '../util'
import Loader from '../components/Loader.vue'
import EventItem from '../components/EventItem.vue'
import Pagination from '../components/Pagination.vue' // ★ 追加


export default {
  components: {
    Loader,
    EventItem,
    Pagination,
  },
  props: {
    page: {
      type: Number,
      required: false,
      default: 1
    }
  },
  data () {
    return {
      loading: false,
      events: [],
      currentPage: 0,
      lastPage: 0,
      total:0,
      per_page: 0,
      from: 0,
      to: 0,
    }
  },
  methods: {
    onLikeClick ({ id, liked }) {
      if (! this.$store.getters['auth/check']) {
        alert('いいね機能を使うにはログインしてください。')
        return false
      }
      if (liked) {
        console.log("Unliked!!")
        this.unlike(id)
      } else {
        console.log("Liked!!")
        this.like(id)
      }
    },
    async like (id) {
      const response = await axios.put(`/api/events/${id}/like`)
        console.log(response)

      if (response.status !== OK) {
        this.$store.commit('error/setCode', response.status)
        return false
      }

      this.events = this.events.map(event => {
        if (event.id === response.data.event_id) {
          event.likes_count += 1
          event.liked_by_user = true
          event.isProcessing = false
        }
        return event
      })
    },
    async unlike (id) {
      const response = await axios.delete(`/api/events/${id}/like`)
        console.log(response)

      if (response.status !== OK) {
        this.$store.commit('error/setCode', response.status)
        return false
      }

      this.events = this.events.map(event => {
        if (event.id === response.data.event_id) {
          event.likes_count -= 1
          event.liked_by_user = false
          event.isProcessing = false
        }
        return event
      })
    },
    onApplyClick ({ id, applied }) {
      if (! this.$store.getters['auth/check']) {
        alert('イベント参加を申し込むにはログインしてください。')
        return false
      }
      if (applied) {
        console.log("UnApplied!!")
        this.unapply(id)
      } else {
        console.log("Applied!!")
        this.apply(id)
      }
    },
    async apply (id) {
      const response = await axios.put(`/api/events/${id}/apply`)
        console.log(response)

      if (response.status !== OK) {
        this.$store.commit('error/setCode', response.status)
        return false
      }

      this.events = this.events.map(event => {
        if (event.id === response.data.event_id) {
          event.applied_by_user = true
          event.isProcessing = false
        }
        return event
      })
    },
    async unapply (id) {
      const response = await axios.delete(`/api/events/${id}/apply`)
        console.log(response)

      if (response.status !== OK) {
        this.$store.commit('error/setCode', response.status)
        return false
      }

      this.events = this.events.map(event => {
        if (event.id === response.data.event_id) {
          event.applied_by_user = false
          event.isProcessing = false
        }
        return event
      })
    },
    async fetchEvents () {

      this.loading = true

      var response = null
      response = await axios.get(`/api/event/search?page=${this.page}`)
    
      if (response.status !== OK) {
        this.$store.commit('error/setCode', response.status)
        return false
      }

      console.log(response)

      this.loading = false

      this.events = response.data.data
      this.currentPage = response.data.current_page
      this.lastPage = response.data.last_page
      this.total = response.data.total
      this.per_page = response.data.per_page
      this.from = response.data.from
      this.to = response.data.to
      
      this.events = this.events.map(event => {
          event.isProcessing =false
          event.isNew = false
        
        return event
      })
    }
  },
  mounted() {
      window.Echo.channel('event-created').listen('EventCreated',response => {
        console.log('received a message');
        console.log(response.event);
        var e = response.event
        e.isNew = true
        e.isProcessing = false
        this.events.unshift(e);
      });
  },
  watch: {
    $route: {
      async handler () {
        await this.fetchEvents()
      },
      immediate: true
    }
  }
}
</script>