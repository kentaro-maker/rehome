<template>
  <div class="event-list">
    イベント
    <ul>
      <li>
        <EventItem
          class="grid__item"
          v-for="event in events"
          :key="event.id"
          :item="event"
          @like="onLikeClick"
        />
      </li>
    </ul>
  </div>
</template>

<script>
import { OK } from '../util'
import Loader from '../components/Loader.vue'
import EventItem from '../components/EventItem.vue'


export default {
  components: {
    Loader,
    EventItem,
  },
  data () {
    return {
      events: []
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
    async fetchEvents () {

      var response = null
      response = await axios.get(`/api/event/search`)
    
      if (response.status !== OK) {
        this.$store.commit('error/setCode', response.status)
        return false
      }

      console.log(response)

      this.events = response.data.data
      this.events = this.events.map(event => {
          event.isProcessing =false
        
        return event
      })
            console.log(this.events)

    }
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