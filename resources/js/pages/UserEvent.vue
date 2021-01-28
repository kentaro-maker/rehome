<template>
    <div class="container row justify-content-center">
        <div class="col-md-9">
            <div class="d-flex flex-wrap m-3 p-2" style="border-bottom: 10px double #fff;">
                <div><h2 class="title__h2">イベント管理</h2></div>
                <div class="ml-auto">
                    <!--<button class="button" @click="showCreateEventForm = true">イベントを作る</button>-->
                    <router-link to="/events/search" tag="button" class="button">イベントを探す</router-link>
                    <button class="button" @click="[tab = 4,new_tab_title = 'イベントを作る',new_tab = true]">イベントを作る</button>
                </div>
            </div>
            <ul class="tab flex-wrap">
                <li class="tab__item"
                    :class="{'tab__item--active': tab === 1 }"
                    @click="tab = 1"
                    >
                    主催
                    <span class="badge badge-pill"
                        :class="[{'badge-secondary' : tab === 1},
                                {'badge-light' : tab !== 1}]"
                    >
                        {{ hosted_total }}
                    </span>
                </li>
                <li class="tab__item"
                    :class="{'tab__item--active': tab === 2 }"
                    @click="tab = 2"
                    >
                    参加
                    <span class="badge badge-pill"
                        :class="[{'badge-secondary' : tab === 2},
                                {'badge-light' : tab !== 2}]"
                    >
                        {{ participated_total }}
                    </span>
                </li>
                <li class="tab__item"
                    :class="{'tab__item--active': tab === 3 }"
                    @click="tab = 3"
                    >
                    いいね
                    <span class="badge badge-pill"
                        :class="[{'badge-secondary' : tab === 3},
                                {'badge-light' : tab !== 3}]"
                    >
                        {{ liked_total }}
                    </span>
                </li>
                <li class="tab__item"
                    v-show="tab === 4 || new_tab == true"
                    :class="{'tab__item--active': tab === 4 }"
                    @click="tab = 4"
                    >
                    {{ new_tab_title }}
                </li>
            </ul>
            <div class="content">
                <div v-show="tab === 1">
                    <div v-show="hosted_loading == true">
                        <div class="card">
                            <div class="card-header">
                                <ul class="nav nav-pills card-header-pills">
                                    <li class="nav-item" style="cursor:pointer;"><a class="nav-link">イベント情報</a></li>
                                    <li class="nav-item" style="cursor:pointer;"><a class="nav-link">参加者</a></li>
                                    <!--
                                    <li class="nav-item" style="cursor:pointer;"><a class="nav-link">アンケート</a></li>
                                    -->
                                    <li class="nav-item" style="cursor:pointer;"><a class="nav-link">チケット認証</a></li>
                                </ul>
                            </div><!-- end of card header -->
                            <div class="card-body"><Loader /></div>
                        </div>
                    </div><!-- end of Loader card -->
                    <div v-show="hosted_loading == false">
                        <div class="card" v-show="hosted_total == 0">
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item text-center">
                                        <div style="font-size:1.5rem;">主催しているイベントはありません</div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card grid__item" v-for="(h,index) in hosted">
                            <div class="card-header">
                                <ul class="nav nav-pills card-header-pills">
                                    <li class="nav-item" style="cursor:pointer;">
                                        <a class="nav-link"
                                            :class="{'active' : hosted_tab[index].tab === 1 }"
                                            @click="hosted_tab[index].tab = 1"
                                            >
                                            イベント情報
                                        </a>
                                    </li>
                                    <li class="nav-item" style="cursor:pointer;">
                                        <a class="nav-link"
                                            :class="{'active' : hosted_tab[index].tab === 2 }"
                                            @click="hosted_tab[index].tab = 2"
                                            >
                                            参加者
                                            <span class="badge badge-pill"
                                                :class="[{'badge-light' : hosted_tab[index].tab === 2},{'badge-primary' : hosted_tab[index].tab !== 2}]"
                                                >
                                                {{ h.participants.length }}
                                            </span>
                                        </a>
                                    </li>
                                    <!--
                                    <li class="nav-item" style="cursor:pointer;">
                                        <a class="nav-link"
                                            :class="{'active' : hosted_tab[index].tab === 3 }"
                                            @click="hosted_tab[index].tab = 3"
                                            >
                                            アンケート
                                        </a>
                                    </li>
                                    -->
                                     <li class="nav-item" style="cursor:pointer;">
                                        <a class="nav-link"
                                            :class="{'active' : hosted_tab[index].tab === 4 }"
                                            @click="hosted_tab[index].tab = 4"
                                            >
                                            チケット認証
                                        </a>
                                    </li>
                                </ul>
                            </div><!-- end of card header -->
                            <div class="card-body">
                                <div v-show="hosted_tab[index].tab === 1">
                                    <div class="row">
                                        <div class="col-3 d-flex align-content-center flex-wrap justify-content-end" style="font-size:1.2rem;"><span>イベント名</span></div>
                                        <div class="col-6" style="font-size:3rem; font-weight:bold">{{ h.title }}</div>
                                    </div>
                                </div><!-- end of tab 1 -->
                                <div v-show="hosted_tab[index].tab === 2">
                                    <ul v-if="h.participants.length == 0" class="list-group list-group-flush">
                                        <li class="list-group-item text-center">
                                            <div style="font-size:1.5rem;">参加者がいません</div>
                                        </li>
                                    </ul>
                                    <ul v-else class="list-group list-group-flush">
                                        <li class="list-group-item d-flex" v-for="ptcp in h.participants">
                                            <div style="font-size:1.5rem;">{{ ptcp.name }}</div>
                                            <div class="ml-auto">
                                                <button
                                                    class="event__action event__action--approve"
                                                    :class="{ 'event__action event__action--approved' : ptcp.approved == true }"
                                                    title="参加を承認する"
                                                    :disabled="isDisabled"
                                                    @click.prevent="onApproveClick(h.id,ptcp.user_id,ptcp.approved)"
                                                    >
                                                    <font-awesome-icon class="icon" icon="user-check" />
                                                    <span v-show="ptcp.approved != true">未承認</span>
                                                    <span v-show="ptcp.approved == true">承認済</span>
                                                </button>
                                                <button
                                                    class="event__action event__action--decline"
                                                    :class="{ 'event__action event__action--declined' : ptcp.approved == false }"
                                                    title="参加を拒否する"
                                                    :disabled="isDisabled"
                                                    @click.prevent="onDeclineClick(h.id,ptcp.user_id,ptcp.approved)"
                                                    >
                                                    <font-awesome-icon class="icon" icon="user-times" />
                                                    <span v-show="ptcp.approved != false">未拒否</span>
                                                    <span v-show="ptcp.approved == false">拒否済</span>
                                                </button>
                                            </div>
                                        </li>
                                    </ul>
                                </div><!-- end of tab 2 -->
                                <div v-show="hosted_tab[index].tab === 3">
                                    <form class="form" @submit.prevent="createQuestionnaire()">
                                        <h3>アンケート作成</h3>
                                        <div v-if="createEventErrors" class="errors">
                                            <ul v-if="createEventErrors.title">
                                            <li v-for="msg in createEventErrors.title" :key="msg">{{ msg }}</li>
                                            </ul>
                                        </div>

                                        <label :for="'event_code--' + h.id">認証コード</label>
                                        <input type="text" :id="'event_code--' + h.id" v-model="code[h.id]"/>
                                        
                                        <button type="submit" class="button">作成</button>
                                    </form>
                                </div><!-- end of tab 3 -->
                                <div v-show="hosted_tab[index].tab === 4" class="justify-content-center" >
                                    <form class="form-inline justify-content-center" @submit.prevent="validateCode(h.id,sw[index].code)">
                                        <div v-if="createEventErrors" class="errors">
                                            <ul v-if="createEventErrors.title">
                                                <li v-for="msg in createEventErrors.title" :key="msg">{{ msg }}</li>
                                            </ul>
                                        </div>
                                        <div class="form-group">
                                            <label :for="'event_code--' + h.id" class="col-form-label">チケットコード</label>
                                            <input type="text" :id="'event_code--' + h.id" class="form--ticket ml-5 mr-5" v-model="sw[index].code"/>
                                        </div>
                                        <div class="">
                                            <button type="submit" class="button">認証</button>
                                        </div>
                                    </form>
                                    <p class="error">{{ error }}</p>
                                    <div style="width:100%;height:auto;margin:0 auto;" v-if="sw[index].cap" :key="sw[index].cap">
                                        <QrcodeStream @decode="onDecode" @init="onInit"/>
                                    </div>
                                    <div class="d-flex justify-content-center mt-4">
                                        <button class="button" @click="switchCamera(index)">
                                            <font-awesome-icon class="icon" icon="camera" />
                                            <span v-if="sw[index].cap">OFF</span>
                                            <span v-else>ON</span>
                                        </button>
                                    </div>
                                </div><!--- end of tab 4 -->
                            </div><!-- end of card body -->
                        </div><!-- end of card -->
                    </div><!-- end of hosted loop -->
                </div><!-- end of tab 1 -->
                <div v-show="tab === 2">
                    <div v-show="participated_loading == true">
                        <div class="card">
                            <div class="card-header">
                                <ul class="nav nav-pills card-header-pills">
                                    <li class="nav-item" style="cursor:pointer;"><a class="nav-link">イベント情報</a></li>
                                    <li class="nav-item" style="cursor:pointer;"><a class="nav-link">進捗状況</a></li>
                                </ul>
                            </div><!-- end of card header -->
                            <div class="card-body"><Loader /></div>
                        </div>
                    </div><!-- end of Loader card -->
                    <div v-show="participated_loading == false">
                        <div class="card" v-show="participated_total == 0">
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item text-center">
                                        <div style="font-size:1.5rem;">参加しているイベントはありません</div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card grid__item" v-for="(p,index) in participated">
                            <div class="card-header">
                                <ul class="nav nav-pills card-header-pills">
                                    <li class="nav-item" style="cursor:pointer;">
                                        <a class="nav-link"
                                            :class="{'active' : participated_tab[index].tab === 1 }"
                                            @click="participated_tab[index].tab = 1"
                                            >
                                            イベント情報
                                        </a>
                                    </li>
                                    <li class="nav-item" style="cursor:pointer;">
                                        <a class="nav-link"
                                            :class="{'active' : participated_tab[index].tab === 2 }"
                                            @click="participated_tab[index].tab = 2"
                                            >
                                            進捗状況
                                        </a>
                                    </li>
                                    <li class="nav-item" style="cursor:pointer;" v-if="p.event.purchased_by_user == true">
                                        <a class="nav-link"
                                            :class="{'active' : participated_tab[index].tab === 3 }"
                                            @click="participated_tab[index].tab = 3"
                                            >
                                            チケット
                                        </a>
                                    </li>
                                </ul>
                            </div><!-- end of card header -->
                            <div class="card-body">
                                <div v-show="participated_tab[index].tab === 1">
                                    <div class="row">
                                        <div class="col-3 d-flex align-content-center flex-wrap justify-content-end" style="font-size:1.2rem;"><span>イベント名</span></div>
                                        <div class="col-6" style="font-size:3rem; font-weight:bold">{{ p.event.title }}</div>
                                    </div>
                                </div><!-- end of tab 1 -->
                                <div v-show="participated_tab[index].tab === 2">
                                    <div class="d-flex flex-wrap align-content-center">
                                        <div class="event__status event__status--apply align-self-center">
                                            参加申請済み
                                        </div>
                                        <div style="font-size:2rem;" class="ml-2 mr-2">
                                            <font-awesome-icon class="icon" icon="chevron-right" />
                                        </div>
                                        <div v-show="p.approved == null" 
                                            class="event__status align-self-center">
                                            <span v-show="p.approved == 1">参加可能</span>
                                            <span v-show="p.approved == 0">参加可能</span>
                                            <span>参加承認待ち</span>
                                        </div>
                                        <div v-show="p.approved == 0" 
                                            class="event__status event__status--error  align-self-center">
                                            <span>参加不可</span>
                                            <font-awesome-icon class="icon" icon="times" />
                                        </div>
                                         <div v-show="p.approved == 1" 
                                            class="event__status event__status--approve align-self-center">
                                            <span>参加可能</span>
                                        </div>
                                        <div v-show="p.approved == 1" style="font-size:2rem;" class="ml-2 mr-2">
                                            <font-awesome-icon class="icon" icon="chevron-right" />
                                        </div>
                                        <div v-show="p.approved == 1 && p.event.purchased_by_user == true"
                                            class="event__status event__status--purchase align-self-center">
                                            <span>参加確定</span>
                                        </div>
                                        <button
                                            class="event__action event__action--purchase icon"
                                            title="チケット購入"
                                            :disabled="!p.approved"
                                            v-show="p.approved == 1 && p.event.purchased_by_user == false"
                                            @click.prevent="onPurchaseClick(p.event_id,p.event.purchased_by_user)"
                                            >
                                            <font-awesome-icon class="icon" icon="ticket-alt" />
                                            <span>チケット購入で参加確定</span>
                                        </button>
                                        <div v-show="p.event.purchased_by_user" style="font-size:2rem;" class="ml-2 mr-2">
                                            <font-awesome-icon class="icon" icon="chevron-right" />
                                        </div>
                                        <button
                                            class="event__action event__action--ticket"
                                            @click="participated_tab[index].tab = 3"
                                            v-show="p.event.purchased_by_user && p.ticket.validated == null"
                                             >
                                            <font-awesome-icon class="icon" icon="ticket-alt" />
                                            <span >チケットコード表示</span>
                                        </button>
                                        <div v-show="p.event.purchased_by_user && p.ticket.validated != null"
                                            class="event__status event__status--ticket align-self-center">
                                            <span>チケット認証済み</span>
                                        </div>
                                        <div v-show="p.event.purchased_by_user && p.ticket.validated != null"
                                            style="font-size:2rem;" class="ml-2 mr-2">
                                            <font-awesome-icon class="icon" icon="chevron-right" />
                                        </div>
                                        <div v-show="p.event.purchased_by_user && p.ticket.validated != null"
                                            class="event__status event__status--participated align-self-center">
                                            <span>参加中</span>
                                        </div>
                                    </div>
                                </div><!-- end of tab 2 -->
                                <div v-show="participated_tab[index].tab === 3">
                                    <div v-if="p.event.purchased_by_user == true" class="event__ticket d-flex flex-column">
                                        <div class="d-flex justify-content-around">
                                            <div v-show="Object(p.ticket).hasOwnProperty('code')">コード：{{ p.ticket.code }}</div>
                                            <div>
                                                <div v-show="p.ticket && p.ticket.validated == null" class="event__ticket--status">
                                                    <font-awesome-icon class="icon event__ticket--status--icon" icon="exclamation-circle"/>
                                                    未認証
                                                </div>
                                                <div v-show="p.ticket && p.ticket.validated != null" class="event__ticket--status--validated">
                                                    <font-awesome-icon class="icon event__ticket--status--icon--validated" icon="check-circle" />
                                                    認証済
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row m-0 justify-content-center">
                                            <VueQrcode v-if="p.ticket.code" :value="p.ticket.code" :options="option" tag="img" />
                                        </div>
                                    </div>
                                </div><!-- end of tab 3 -->
                            </div><!-- end of card body -->
                        </div><!-- end of card -->
                    </div><!-- end of hosted loop -->
                </div><!-- end of tab 2 -->
                <div v-show="tab === 3">
                    <div v-show="liked_loading == true">
                        <div class="card">
                            <div class="card-body"><Loader /></div>
                        </div>
                    </div><!-- end of Loader card -->
                    <div v-show="liked_loading == false">
                        <div class="card" v-show="liked_total == 0">
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item text-center">
                                        <div style="font-size:1.5rem;">いいねしたイベントはありません</div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card grid__item" v-for="(l,index) in liked">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-2 d-flex align-content-center flex-wrap justify-content-end" style="font-size:1.2rem;"><span>イベント名</span></div>
                                    <div class="col-8" style="font-size:3rem; font-weight:bold">{{ l.title }}</div>
                                </div>
                            </div><!-- end of card body -->
                        </div><!-- end of card --><!-- end of liked loop -->
                        <Pagination :current-page="liked_page.current" :last-page="liked_page.last" />
                    </div><!-- end of out of Loader -->
                </div>
                <div v-show="tab === 4">
                    <div class="card">
                        <div class="card-body">
                            <form class="form" @submit.prevent="createEvent">
                                <div v-if="createEventErrors" class="errors">
                                    <ul v-if="createEventErrors.title">
                                        <li v-for="msg in createEventErrors.title" :key="msg">{{ msg }}</li>
                                    </ul>
                                </div>
                                <div class="form-group row">
                                    <label for="title" class="col-sm-2 col-form-label">タイトル</label>
                                    <div class="col-sm-10">
                                        <input type="text" id="title" class="form-control" placeholder="タイトル" v-model="eventForm.title"/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-10">
                                    <button type="submit" class="button">作成</button>
                                    </div>
                                </div>
                                <!--
                                <label for="fee">参加費</label>
                                <div class="input-group">
                                    <input type="text" id="fee" />
                                    <div class="input-group-append"><span class="input-group-text">円</span></div>
                                    /1人
                                </div>
                                <label for="content">内容</label><input type="text" id="content"/>
                                <label for="parking">駐車場</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="exampleRadios" id="parkingOn" value="option1" checked>
                                    <label class="form-check-label" for="parkingOn">あり</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="exampleRadios" id="parkingOff" value="option2">
                                    <label class="form-check-label" for="parkingOff">なし</label>
                                </div>
                                <div class="form-group">
                                    <label for="people">参加人数</label><input type="text" id="people"/>
                                </div>
                                -->
                            </form>
                        
                        </div>
                    </div>
                </div>
            </div><!-- end of content -->
        </div><!-- end of col-9 -->
    </div><!-- end of container -->
</template>

<script>
import { OK } from '../util'
import Loader from '../components/Loader.vue'
import Pagination from '../components/Pagination.vue' 

import { QrcodeStream } from 'vue-qrcode-reader'
import VueQrcode from "@chenfengyuan/vue-qrcode";


import { mapState } from 'vuex'


export default {
    components: {
        Loader,
        Pagination,
        QrcodeStream,
        VueQrcode
    },
    props: {
        likedPage: {
            type: Number,
            required: false,
            default: 1
        }
    },
    data (){
        return {
            tab: 1,
            new_tab: false,
            new_tab_title: '',
            eventForm: {
                title: '',
            },
            code:[],
            showCreateEventForm: false,

            hosted_tab:[],
            participated_tab:[],
            liked_tab:[],
            hosted: [],
            participated: [],
            liked: [],
            hosted_total: 0,
            participated_total: 0,
            liked_total: 0,

            hosted_page:        {current: 0,last: 0,per: 0,from: 0,to: 0,},
            participated_page:  {current: 0,last: 0,per: 0,from: 0,to: 0,},
            liked_page:         {current: 0,last: 0,per: 0,from: 0,to: 0,},
            
            hosted_loading: true, 
            participated_loading: true, 
            liked_loading: true, 
            validate_loading: [], 

            sw: [],
            code: [],
            result: '',
            targetText:'aaa',
            option: {
                errorCorrectionLevel: "M",
                maskPattern: 0,
                margin: 10,
                scale: 2,
                width: 300,
                color: {
                dark: "#000000FF",
                light: "#FFFFFFFF"
                }
            },
            error: '',
        }
    },
    computed: {
        ...mapState({
                apiStatus: state => state.event.apiStatus,
                createEventErrors: state => state.event.createErrorMessages,
        }),
        isDisabled () {
            return this.hosted.isProcessing
        },
        username () {
            return this.$store.getters['auth/username']
        }
    },
    methods: {
         onDecode (result,id) {
            console.log(result)
            this.result = result
            this.sw = this.sw.map(sw => {
                if(sw.cap){
                    sw.code = result
                }
                return sw
            })
         },
        switchCamera(index) {
            this.sw = this.sw.map((sw,i) => {
                console.log(sw)
                if(i == index){
                    sw.cap = !sw.cap
                }else{
                    sw.cap = false
                }
                return sw
            })
        },
    async onInit (promise) {
      try {
        await promise
      } catch (error) {
        if (error.name === 'NotAllowedError') {
          this.error = "ERROR: you need to grant camera access permisson"
        } else if (error.name === 'NotFoundError') {
          this.error = "ERROR: no camera on this device"
        } else if (error.name === 'NotSupportedError') {
          this.error = "ERROR: secure context required (HTTPS, localhost)"
        } else if (error.name === 'NotReadableError') {
          this.error = "ERROR: is the camera already in use?"
        } else if (error.name === 'OverconstrainedError') {
          this.error = "ERROR: installed cameras are not suitable"
        } else if (error.name === 'StreamApiNotSupportedError') {
          this.error = "ERROR: Stream API is not supported in this browser"
        }
        alert(error)
      }
    },
        onApproveClick(event_id,user_id,status){
            console.log(this.hosted)
            if (status == 1) {
                console.log("UnApproved!!")
                this.unapprove(event_id,user_id)
            } else {
                console.log("Approved!!")
                this.approve(event_id,user_id)
            }
            console.log(this.hosted)
        },
        async approve (event_id,user_id) {
            const response = await axios.put(`/api/event/${event_id}/user/${user_id}/approve`)
                console.log(response)

            if (response.status !== OK) {
                this.$store.commit('error/setCode', response.status)
                return false
            }
            this.hosted = this.hosted.map(event => {
                if(event.id == response.data.event_id){
                    event.participants = event.participants.map(user => {
                        if(user.user_id == response.data.user_id) {
                            user.approved = 1
                        }
                        return user
                    })
                    //return eventをifの中に書かないで！！
                }
                return event
            })
        },
        async unapprove (event_id,user_id) {
            const response = await axios.delete(`/api/event/${event_id}/user/${user_id}/approve`)
                console.log(response)

            if (response.status !== OK) {
                this.$store.commit('error/setCode', response.status)
                return false
            }

            this.hosted = this.hosted.map(event => {
                if(event.id == response.data.event_id){
                    event.participants = event.participants.map(user => {
                        if(user.user_id == response.data.user_id) {
                            user.approved = null
                        }
                        return user
                    })
                    //return eventをifの中に書かないで！！
                }
                return event
            })
        },
        onDeclineClick(event_id,user_id,status){
            console.log(this.hosted)
            if (status == 0) {
                console.log("UnDeclined!!")
                this.undecline(event_id,user_id)
            } else {
                console.log("Declined!!")
                this.decline(event_id,user_id)
            }
            console.log(this.hosted)
        },
        async decline (event_id,user_id) {
            const response = await axios.put(`/api/event/${event_id}/user/${user_id}/decline`)
                console.log(response)

            if (response.status !== OK) {
                this.$store.commit('error/setCode', response.status)
                return false
            }
            this.hosted = this.hosted.map(event => {
                if(event.id == response.data.event_id){
                    event.participants = event.participants.map(user => {
                        if(user.user_id == response.data.user_id) {
                            user.approved = 0
                        }
                        return user
                    })
                    //return eventをifの中に書かないで！！
                }
                return event
            })
        },
        async undecline (event_id,user_id) {
            const response = await axios.delete(`/api/event/${event_id}/user/${user_id}/decline`)
                console.log(response)

            if (response.status !== OK) {
                this.$store.commit('error/setCode', response.status)
                return false
            }

            this.hosted = this.hosted.map(event => {
                if(event.id == response.data.event_id){
                    event.participants = event.participants.map(user => {
                        if(user.user_id == response.data.user_id) {
                            user.approved = null
                        }
                        return user
                    })
                    //return eventをifの中に書かないで！！
                }
                return event
            })
        },
        onPurchaseClick(event_id,status){
            if (status) {
                console.log("UnPurchase!!")
                this.unpurchase(event_id)
            } else {
                console.log("Purchase!!")
                this.purchase(event_id)
            }
            console.log(this.participated)
        },

         async purchase (event_id) {
            const response = await axios.put(`/api/event/${event_id}/purchase`)
                console.log(response)

            if (response.status !== OK) {
                this.$store.commit('error/setCode', response.status)
                return false
            }
            this.participated = this.participated.map(p => {

                if(p.event.id == response.data.event_id){
                    p.event.purchased_by_user = true
                    p.ticket = response.data.ticket
                    window.Echo.private('ticket-validated.'+ p.ticket.id).listen('TicketValidated',response => {
                        console.log('received a message')
                        console.log(response);
                        p.ticket.validated = response.ticket.validated
                    });
                }
                console.log(p)
                return p
            })
        },
         async unpurchase (event_id) {
            const response = await axios.delete(`/api/event/${event_id}/purchase`)
                console.log(response)

            if (response.status !== OK) {
                this.$store.commit('error/setCode', response.status)
                return false
            }
            this.participated = this.participated.map(p => {

                if(p.event.id == response.data.event_id){
                    console.log(p)
                    p.event.purchased_by_user = false
                    //return eventをifの中に書かないで！！
                }
                return p
            })
        },
        async createEvent() {
            console.log("createEvent")
            await this.$store.dispatch('event/create', this.eventForm)
             if (this.apiStatus) {
                await this.fetchHosted()
                this.tab = 1
                this.new_tab = false,
                this.eventForm.title = ''
            }
            console.log(this.createEventErrors)
        },

         async validateCode(event_id,code) {
             console.log(event_id+code)

            
            const response = await axios.post(`/api/event/${event_id}/validate`, {
                code: code
            })
            console.log(response)
            
        },

        async fetchHosted () {
            this.hosted_loading = true
            const response = await axios.get('/api/event/hosted')
            if (response.status !== OK) {
                this.$store.commit('error/setCode', response.status)
                return false
            }

            console.log(response)
            this.hosted = response.data.data
            this.hosted_total = response.data.total
            
            this.hosted.forEach(event => {
                var o = new Object()
                o['tab'] = 1
                this.hosted_tab.push(o)
                var sw = new Object()
                sw['cap'] = false
                sw['code'] = ''
                this.sw.push(sw)

                
                window.Echo.private('user-applied-event.'+ event.id).listen('UserApplied',response => {
                    console.log('received a message')
                    console.log(response);
                    var user = new Object()
                    user['user_id'] = response.user.id
                    user['name'] = response.user.name
                    user['approved'] = null
                    event.participants.unshift(user)
                });
            })

            console.log(this.sw)
            this.hosted_loading = false
        },

        async fetchParticipated () {
            this.participated_loading = true
            const response = await axios.get('/api/event/participated')

            if (response.status !== OK) {
                this.$store.commit('error/setCode', response.status)
                return false
            }

            console.log(response)
            this.participated = response.data.data
            this.participated_total = response.data.total
            this.participated.forEach(apply => {
                var o = new Object()
                o['tab'] = 1
                this.participated_tab.push(o)
                window.Echo.private('user-approved-apply.'+ apply.id).listen('UserApproved',response => {
                    console.log('received a message')
                    console.log(response);
                    apply.approved = response.apply.approved
                });
                if(apply.ticket){
                    console.log(apply.ticket.id)
                    window.Echo.private('ticket-validated.'+ apply.ticket.id).listen('TicketValidated',response => {
                        console.log('received a message')
                        console.log(response);
                        apply.ticket.validated = response.ticket.validated
                    });
                }

            })
            this.participated_loading = false
        },
        
        async fetchLiked () {
            this.liked_loading = true
            const response = await axios.get(`/api/event/liked?page=${this.likedPage}`)

            if (response.status !== OK) {
                this.$store.commit('error/setCode', response.status)
                return false
            }

            console.log(response)
            this.liked = response.data.data
            this.liked_total = response.data.total

            this.liked_page.current = response.data.current_page
            this.liked_page.last = response.data.last_page
            this.liked_page.per = response.data.per_page
            this.liked_page.from = response.data.from
            this.liked_page.to = response.data.to

            this.liked.forEach(event => {
                var o = new Object()
                o['tab'] = 1
                this.liked_tab.push(o)
            })
            this.liked_loading = false
        },

        clearError () {
            this.$store.commit('event/setCreateErrorMessages', null)
        },
    },
    created() {
        this.clearError()
    },
    destroyed() {
        this.hosted.forEach(event => {
                var ch = window.Echo.leaveChannel('user-applied-event.'+ event.id)
                console.log(ch)
        })
    },
    watch: {
        hosted: function () {
            console.log('hosted watcher')
        },
        $route: {
            async handler () {
                await this.fetchHosted()
                await this.fetchParticipated()
                await this.fetchLiked()
            },
            immediate: true
        },
    }
}
</script>