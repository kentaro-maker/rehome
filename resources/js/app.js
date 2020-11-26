/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
window.Vue = require('vue');

// ルーティングの定義をインポートする
import router from './router'

import store from './store'
// ルートコンポーネントをインポートする
import App from './App.vue'

const createApp = async () => {
    await store.dispatch('auth/currentUser')

    new Vue({
    el: '#app',
    router, // ルーティングの定義を読み込む
    store,
    components: { App }, // ルートコンポーネントの使用を宣言する
    template: '<App />' // ルートコンポーネントを描画する
    })
}

createApp()



/*
const years = [];
const months = [];
const dates = [];
const time = new Date();
const nowYear = time.getFullYear();
const nowMonth = time.getMonth() + 1;
const nowDate = time.getDate();

for(var i = 1900; i <= nowYear; i++) {
    years.push(i);
}
for(var i = 1; i <= 12; i++) {
    months.push(i);
}
for(var i = 1; i <= 31; i++) {
    dates.push(i);
}

const app = new Vue({
    el: '#app',
    template: '<h1>Hello world</h1>',
    data: {
        year: '',
        month: '',
        date: '',
        options: () => years,
        years:years,
        months:months,
        dates:dates,
        options: [
            { id: 1, name: '夏目漱石' },
            { id: 2, name: '太宰治' },
            { id: 3, name: '村上春樹' }
        ]
    },
    methods: {
        modifyMonths() {
            var last_month = 12;
            if(this.year == nowYear) {
                last_month = nowMonth;
            }
            this.months = months.slice(0, last_month);
        },
        modifyDates() {
            var last_date = 31;
            this.date = null;

            if (this.year == nowYear && this.month == nowMonth ) {
                // 現在の年・月が選択された場合、日の選択肢は 1~現在の日付 に設定
                // それ以外の場合、各月ごとの最終日を判定し、1~最終日 に設定
                last_date = nowDate;
            }else{
                if (this.month == 2) {
                    // 2月：日の選択肢は1~28日に設定
                    // ※ ただし、閏年の場合は29日に設定
                    if((Math.floor(this.year%4 == 0)) && (Math.floor(this.year%100 != 0)) || (Math.floor(this.year%400 == 0))){
                        last_date = 29;
                    }else{
                        last_date = 28;
                    }
                }else if(this.month == 4 || this.month == 6 || this.month == 9 || this.month == 11 ){
                    // 4, 6, 9, 11月：日の選択肢は1~30日に設定
                    last_date = 30;
                }
            }
            this.dates = dates.slice(0, last_date);
    },
});

*/