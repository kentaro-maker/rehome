<template>
  <div class="card w-100">
    <div class="card-body">
      <h5 class="card-title title__h1">
        <span v-if="item.hosted_by_user" class="hosted align-middle">主催中</span>
        <span v-if="item.isNew" class="new align-middle">NEW</span>
          {{ item.title }}
        <!--
        <router-link :to="{name: 'event.detail', params:{id:item.id}}">
        </router-link>
        -->
      </h5>
      <button
        class="event__action event__action--like"
        :class="{ 'event__action--liked': item.liked_by_user }"
        title="いいねする"
        :disabled="isDisabled"
        @click.prevent="like"
        >
        <font-awesome-icon  class="icon" icon="heart" />{{ item.likes_count }}
      </button>
      <router-link 
        v-show="item.liked_by_user == true"
        :to="{path:`/user/${username}/events`}">
        いいねリスト &raquo;
      </router-link>
      <button
        class="event__action event__action--apply icon"
        :class="{ 'event__action event__action--applied' : item.applied_by_user }"
        title="イベントに申し込む"
        :disabled="isDisabled"
        @click.prevent="apply"
        >
        <font-awesome-icon class="icon" icon="file-signature" />
        <span v-show="item.applied_by_user == true">申請済</span>
        <span v-show="item.applied_by_user == false">未申請</span>
      </button>
      <router-link 
        v-show="item.applied_by_user == true"
        :to="{path:`/user/${username}/events`}">
        申請済リスト &raquo;
      </router-link>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    item: {
      type: Object,
      required: true
    }
  },
  data () {
    return {
    }
  },
  computed : {
    isDisabled () {
      return this.item.hosted_by_user || this.item.isProcessing
    },
    username () {
      return this.$store.getters['auth/username']
    }
  },
  methods: {
    like () {
      if(this.item.isProcessing == false) {
        this.item.isProcessing = true

        this.$emit('like', {
          id: this.item.id,
          liked: this.item.liked_by_user,
        })
      }
    },
    apply () {
      if(this.item.isProcessing == false) {
        this.item.isProcessing = true

        this.$emit('apply', {
          id: this.item.id,
          applied: this.item.applied_by_user,
        })
      }
    },
  }
}
</script>