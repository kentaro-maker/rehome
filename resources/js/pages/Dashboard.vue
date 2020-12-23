<template>
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-3 ">
                ダッシュボード 
                <ul class="nav flex-column">
                    <li class="nav-item"><router-link class="nav-link" :to="{ path: `/user/${username}/dashboard`}" replace>ホーム</router-link></li>
                    <li class="nav-item"><router-link class="nav-link" :to="{ path: `/user/${username}/dashboard/profile`}" replace>プロフィール</router-link></li>
                    <li class="nav-item"><router-link class="nav-link" :to="{ path: `/user/${username}/dashboard/events`}" replace>イベント</router-link></li>
                    <li class="nav-item"><router-link class="nav-link" :to="{ path: `/user/${username}/dashboard/setting`}" replace>設定</router-link></li>
                </ul>
            </div>
            <div class="col-9">
                <router-view></router-view>
            </div>
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