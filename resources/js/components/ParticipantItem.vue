<template>
  <div class="city panel">
     <router-link :to="{name: 'event.detail', params:{id:item.id}}">
        {{ item.title }}
        </router-link>
        <button
          class="event__action event__action--like"
          :class="{ 'event__action--liked': item.liked_by_user }"
          title="いいねする"
          :disabled="isDisabled"
          @click.prevent="like"
          >
          <font-awesome-icon  class="icon" icon="heart" />{{ item.likes_count }}
        </button>
        <button
            class="event__action event__action--apply icon"
            :class="{ 'event__action event__action--applied' : item.applied_by_user }"
            title="イベントに申し込む"
            :disabled="isDisabled"
            @click.prevent="apply"
            >
            <font-awesome-icon class="icon" icon="file-signature" />{{ applyStatus }}
        </button>
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
    applyStatus() {
      if(this.item.applied_by_user){
        return '申請済'
      }else{
        return '未申請'
      }
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