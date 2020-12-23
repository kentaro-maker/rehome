<template>
  <div>
    <header>
      <Navbar />
      <div v-show="isWelcome" class="container-fluid p-0">
        <div class="row">
          <div id="welcome_board" class="col p-0 d-flex flex-column align-items-center text-center justify-content-center">
            <h1>あなたにぴったりの町を探そう</h1>
            <p style="font-size:1.5rem;">登録済み市町村は現在「792」</p>
          </div>
          <div class="col p-0">
            <img :src="welcomeImg" class="img-fluid" alt="Responsive image">
          </div>
        </div>
      </div>
    </header>
    <main>
      <Message />
      <router-view></router-view>
    </main>
    <Footer />
  </div>
</template>

<script>
import { NOT_FOUND, UNAUTHORIZED, INTERNAL_SERVER_ERROR } from './util'

import Message from './components/Message.vue'
import Navbar from './components/Navbar.vue'
import Footer from './components/Footer.vue'

export default {
  components: {
    Message,
    Navbar,
    Footer,
  },
  data () {
    return {
      welcomeImg: "/storage/images/welcome.jpg",
    }
  },
  computed: {
    errorCode () {
      return this.$store.state.error.code
    },
    isWelcome() {
      return this.$route.name == 'welcome'
    }
  },
  watch: {
    errorCode: {
      async handler (val) {
        if (val === INTERNAL_SERVER_ERROR) {
          this.$router.push('/500')
        } else if (val === UNAUTHORIZED) {
          await axios.get('/api/refresh-token')
          this.$store.commit('auth/setUser', null)
          this.$router.push('/login')
        } else if (val === NOT_FOUND) {
          this.$router.push('/not-found')
        }
      },
      immediate: true
    },
    $route () {
      this.$store.commit('error/setCode', null)
    }
  }
}
</script>