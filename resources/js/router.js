import Vue from 'vue'
import VueRouter from 'vue-router'

// ページコンポーネントをインポートする
import CityList from './pages/CityList.vue'
import EventList from './pages/EventList.vue'
import Login from './pages/Login.vue'
import Welcome from './pages/Welcome.vue'
import SearchResult from './pages/SearchResult.vue'
import CityDetail from './pages/CityDetail.vue'

import Dashboard from './pages/Dashboard.vue'
import DHome from './components/dashboard/Home.vue'
import DProfile from './components/dashboard/Profile.vue'
import DEvents from './components/dashboard/Events.vue'
import DSetteing from './components/dashboard/Setting.vue'

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
  {
    path:'/photos/:id',
    component: CityDetail,
    props: true,
  },
  {
    path: '/500',
    component: SystemError
  },
  {
    path: '/user/:user/dashboard',
    component: Dashboard,
    beforeEnter (to, from, next) {
      if (store.getters['auth/check']) {
        next()
      } else {
        next('/login')
      }
    },
    children: [
      {
        path: '',
        component: DHome,
      },
      {
        path: 'profile',
        component: DProfile,
      },
      {
        path: 'events',
        component: DEvents,
      },
      {
        path: 'setting',
        component: DSetteing,
      },
    ]
  },
  {
    path: '/events/search',
    name: 'events.search',
    component: EventList,
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
    path: '*',
    name: 'not-found',
    component: NotFound
  }
]

// VueRouterインスタンスを作成する
const router = new VueRouter({
  mode: 'history',
  routes
})

// VueRouterインスタンスをエクスポートする
// app.jsでインポートするため
export default router
