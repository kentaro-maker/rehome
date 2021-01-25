<template>
  <nav class="navbar">
    <router-link class="navbar__brand" to="/">
      <img src="/storage/images/logo.svg" class="navbar__brand--logo"/>
      rehome++
    </router-link>
    <div class="navbar__menu">
      <div v-if="isLogin" class="navbar__item">

        <router-link :to="{path:`/user/${username}/events`}">
          <font-awesome-icon icon="user" />
            {{ username }}
        </router-link>
      </div>
      <div v-else class="navbar__item">
        <router-link class="button button--link" to="/login">
          ログイン / 新規登録
        </router-link>
      </div>  
      <div class="navbar__item">
        <router-link :to="{name: 'events.search'}" tag="button" class="button">
          イベントを探す
        </router-link>
      </div>
      <div v-if="isLogin" class="navbar__item">
        <router-link :to="{path:`/user/${username}/events`}" tag="button" class="button">
          イベントを作る
        </router-link>
      </div>
    </div>
  </nav>
</template>

<script>

export default {
  components: {
  
  },
  methods: {

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