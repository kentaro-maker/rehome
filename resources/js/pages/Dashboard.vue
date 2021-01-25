<template>
    <div class="container row justify-content-center">
        <div class="col-9">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
import { OK } from '../util'
import Loader from '../components/Loader.vue'


export default {
    components: {
        Loader
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