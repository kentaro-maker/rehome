<template>
    <div>
        <h3 class="title">こだわり条件から探す</h3>
        <div class="card-group">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">総人口から探す</h5>
                    <ul class="condition-list-group">
                        <li  class="condition-list-group__item" v-for="pop in pops">
                            <router-link
                                :to="{name: 'search', query: {pop: pop.query}}"
                                class="condition-nav__link">
                                {{pop.text}}
                            </router-link>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">総面積から探す</h5>
                    <ul class="condition-list-group">
                        <li  class="condition-list-group__item" v-for="land in lands">
                            <router-link
                                :to="{name: 'search', query: {land: land.query}}"
                                class="condition-nav__link">
                                {{land.text}}
                            </router-link>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">空家数から探す</h5>
                    <ul class="condition-list-group">
                        <li  class="condition-list-group__item" v-for="empty in empties">
                            <router-link
                                :to="{name: 'search', query: {land: empty.query}}"
                                class="condition-nav__link">
                                {{empty.text}}
                            </router-link>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { OK, CREATED, UNPROCESSABLE_ENTITY } from '../util'
import Loader from './Loader.vue'
import { mapState } from 'vuex'



export default {
    components: {
        Loader
    },
    data () {
        return {
            loading: false,
            errors: null,
            pops:[
                {text: '～1万人(3)',            query:'to10k'},
                {text: '1万人～5万人(269)',     query:'10kto50k'},
                {text: '5万人～10万人(260)',    query:'50kto100k'},
                {text: '10万人～20万人(151)',   query:'100kto200k'},
                {text: '20万人～30万人(38)',    query:'200kto300k'},
                {text: '30万人～40万人(24)',    query:'300kto400k'},
                {text: '40万人～50万人(19)',    query:'400kto500k'},
                {text: '50万人～100万人(17)',   query:'500kto1m'},
                {text: '100万人～(11)',         query:'1mto'},
            ],
            lands:[
                {text: '～5000ha(144)',         query:'to5k'},
                {text: '5000ha～1万ha(123)',    query:'5kto10k'},
                {text: '1万ha～5万ha(385)',     query:'10kto50k'},
                {text: '5万ha～10万ha(119)',    query:'50kto100k'},
                {text: '10万ha～(21)',          query:'100kto'},
            ],
            empties:[
                {text: '1千家未満(5)',          query:'to1k'},
                {text: '1千家以上2千家未満(75)', query:'1kto2k'},
                {text: '2千家以上3千家未満(143)',query:'2kto3k'},
                {text: '3千家以上4千家未満(126)',query:'3kto4k'},
                {text: '4千家以上5千家未満(100)',query:'4kto5k'},
                {text: '5千家以上1万家未満(188)',query:'5kto10k'},
                {text: '1万家以上5万家未満(140)',query:'10kto50k'},
                {text: '5万家以上10万家未満(9)', query:'50kto100k'},
                {text: '10万家以上(6)',         query:'100kto'},
            ],
        }
    },
    computed: mapState({
        apiStatus: state => state.auth.apiStatus,
        loginErrors: state => state.auth.loginErrorMessages,
        registerErrors: state => state.auth.registerErrorMessages
    }),
    methods: {
        async search () {
            this.loading = true
            
           // await this.$store.dispatch('search/search', this.keywordForm)

        const response = await axios.post(
                '/api/search',{keyword:this.keywordForm}
                ).catch(
                    err => err.response || err
                )
                

            //console.log(response)
            //console.log(response.data.search)

            if(response.status === OK) {
                if(response.data.data.length == 0){
                    this.searchErrors = "キーワード「" + response.data.search.keyword + "」に一致する市はありません"
                }else{
                    await this.$store.dispatch('search/store', response.data.data)
                    await this.$router.push({ 
                        name: 'search_result',
                        params: {
                            keyword: response.data.search.keyword,
                        }
                    })
                }
            }

            // バリデーションエラー
            if (response.status === UNPROCESSABLE_ENTITY) {
                this.searchErrors = "空です"
                console.log(response.data.errors)
            }

            this.keywordForm = ''
            // エラーメッセージをクリア
            //this.searchErrors = null

            // その他のエラー
            if (response.status !== OK) {
                //this.$store.commit('error/setCode', response.status)
                //return false
            }
            this.loading = false

        },
    },
}
</script>