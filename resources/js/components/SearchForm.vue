<template>
    <div>
        <h2 class="title">キーワード検索</h2>
        <div v-show="loading" class="panel">
            <Loader>検索中</Loader>
        </div>
        <form class="form" @submit.prevent="submit">
            <input class="form__item" type="text">
            <div class="form__button">
                <button type="submit" class="button button--inverse">submit</button>
            </div>
        </form>
    </div>
</template>

<script>
import { CREATED, UNPROCESSABLE_ENTITY } from '../util'
import Loader from './Loader.vue'


export default {
    components: {
        Loader
    },
    props: {
        value: {
            type: Boolean,
            required: true,
        }
    },
    data () {
        return {
            loading: false,
            errors: null,
        }
    },
    methods: {
        submit () {
            this.loading = true
        },
    },
}
</script>