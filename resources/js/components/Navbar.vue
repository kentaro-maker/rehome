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
      <button @click="send()">API</button>
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
  },
  methods: {
    async send(){
      // console.log("PUSH")
      // const response = await axios.put(`/api/ticket`)
      // console.log(response)
      console.log("EVENT_CREATED")
      const response = await axios.get(`/api/eventcreated`)
      console.log(response)
    }
  },
  mounted() {
        // window.Echo.channel("ticketValidate").listen(".ticket-validated", e => {
        //   alert(e)
        // });
        window.Echo.private("ticketValidate."+this.$store.getters['auth/userid']).listen(".ticket-validated", e => {
           alert(e)
        });
  },
}
</script>