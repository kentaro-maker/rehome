import Vue from 'vue'
import VueRouter from 'vue-router'

// ページコンポーネントをインポートする
import CityList from './pages/CityList.vue'
import Login from './pages/Login.vue'
import Welcome from './pages/Welcome.vue'
import SearchResult from './pages/SearchResult.vue'
import CityDetail from './pages/CityDetail.vue'

import EventList from './pages/EventList.vue'
import EventDetail from './pages/EventDetail.vue'
import Dashboard from './pages/Dashboard.vue'

import UserEvent from './pages/UserEvent.vue'

import SystemError from './pages/errors/System.vue'
import NotFound from './pages/errors/NotFound.vue'



import store from './store'

// VueRouterプラグインを使用する
// これによって<RouterView />コンポーネントなどを使うことができる
Vue.use(VueRouter)

// パスとコンポーネントのマッピング
const routes = [
  {
    path: '/',
    name: 'welcome',
    component: Welcome,
  },
  {
    path: '/search',
    name: 'search',
    props: true,
    component: SearchResult,
  },
  {
    path: '/login',
    component: Login,
    beforeEnter (to, from, next) {
      if (store.getters['auth/check']) {
        next('/')
      } else {
        next()
      }
    }
  },
  // {
  //   path:'/cities/:city_id/pdf',
  //   component: Pdf,
  //   props: true,
  // },
  {
    path: '/500',
    component: SystemError
  },
  {
    path: '/user/:user/events',
    component: UserEvent,
    beforeEnter (to, from, next) {
      if (store.getters['auth/check']) {
        next()
      } else {
        next('/login')
      }
    },
  },
  {
    path: '/events/search',
    name: 'events.search',
    component: EventList,
    props: route => {
      const page = route.query.page
      return { page: /^[1-9][0-9]*$/.test(page) ? page * 1 : 1 }
    }
  },
  {
    path: '/events/detail/:id',
    name: 'event.detail',
    props: true,
    component: EventDetail,
  },
  {
    path: '/region/:region_slug',
    name: 'region',
    props: true,
    component: CityList,
  },
  {
    path: '/region/:region_slug/pref/:pref_slug',
    name: 'pref',
    props: true,
    component: CityList,
  },
  {
    path: '/region/:region_slug/pref/:pref_slug/city/:city_slug',
    name: 'city',
    props: true,
    component: CityDetail,
  },
  {
    path: '/not-found',
    name: 'not-found',
    component: NotFound
  }
]

// VueRouterインスタンスを作成する
const router = new VueRouter({
  mode: 'history',
  scrollBehavior () {
    return { x: 0, y: 0 }
  },
  routes
})

// VueRouterインスタンスをエクスポートする
// app.jsでインポートするため
export default router
