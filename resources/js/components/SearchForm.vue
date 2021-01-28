<template>
    <div class="container-item">
        <h3 class="title">キーワード検索</h3>

        <form class="form" @submit.prevent="search">
            
            <div v-if="searchErrors" class="errors">
                {{ searchErrors }}
            </div>

            <div v-show="loading">
                <Loader>検索中</Loader>
            </div>
            <div v-show="! loading">
                <div class="input-group mb-3">
                    <input type="text"
                    class="form-control form__item__input"
                    placeholder="地域・都道府県・市の名前"
                    aria-label="Recipient's username"
                    aria-describedby="button-addon2"
                    v-model="keywordForm">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary form__item__button" type="submit" id="button-addon2">
                            <font-awesome-icon icon="search" />
                        </button>
                    </div>
                </div>    

            </div>
        </form>
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
    props: {
  
    },
    data () {
        return {
            loading: false,
            errors: null,
            searchErrors: null,
            keywordForm: null,
            keyword: '',
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
                

            console.log(response)
            //console.log(response.data.search)

            if(response.status === OK) {
                if(response.data.data.length == 0){
                    this.searchErrors = "キーワード「" + this.keywordForm + "」に一致する市はありません"
                }else{
                    await this.$store.dispatch('search/store', response.data.data)
                    await this.$router.push({ 
                        name: 'search',
                        query: {
                            keyword: this.keywordForm,
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