<template>
  <nav class="navbar">
    <RouterLink class="navbar__brand" to="/">
      rehome++
    </RouterLink>
    <div class="navbar__menu">
      <div class="navbar__item">
        <div class="navbar__item">
          <router-link :to="{name: 'events.search'}" tag="button" class="button">
            イベントを探す
          </router-link>
        </div>

        <div v-if="isLogin" class="navbar__item">
        
          <router-link :to="{path:`/user/${username}/dashboard`}" tag="button" class="button">
            イベント作成
          </router-link>
        </div>
        
        <span v-if="isLogin" class="navbar__item">
          <router-link :to="{ path: `/user/${username}/dashboard/profile` }">
            <font-awesome-icon icon="user" />
            {{ username }}
          </router-link>
        </span>
        
        <div v-else class="navbar__item">
          <RouterLink class="button button--link" to="/login">
            ログイン / 新規登録
          </RouterLink>
        </div>
        
      </div>
    </div>
    
    <PhotoForm v-model="showForm" />

  </nav>
</template>

<script>
import PhotoForm from './PhotoForm.vue'

export default {
  components: {
    PhotoForm
  },
  data () {
    return {
      showForm: false
    }
  },
  methods: {
    con(){
      console.log("clicked!")
    }
  },
  computed: {
    isLogin () {
      return this.$store.getters['auth/check']
    },
    username () {
      return this.$store.getters['auth/username']
    }
  }
}
</script>