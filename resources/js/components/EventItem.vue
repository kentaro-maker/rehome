<template>
  <div class="city panel">
     <router-link :to="{name: 'event.detail', params:{id:item.id}}">
        {{ item.title }}
        </router-link>
        <button
          class="photo__action photo__action--like"
          :class="{ 'photo__action--liked': item.liked_by_user }"
          title="いいねする"
          :disabled="isDisabled"
          @click.prevent="like"
          >
        <p v-model="isActive">{{isActive}}</p>
          <font-awesome-icon icon="heart" />{{ item.likes_count }}
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
      isActive: false
    }
  },
  computed : {
    isDisabled () {
      return this.item.hosted_by_user || this.item.isProcessing
      //return this.item.isProcessing
    }
  },
  methods: {
    async like () {
      if(this.item.isProcessing == false) {
        this.item.isProcessing = true

        this.$emit('like', {
          id: this.item.id,
          liked: this.item.liked_by_user,
        })
      }
    },
  }
}
</script>