<template>
  <div class="pagination">
    <router-link
      v-if="! isFirstPage"
      :to="`/events/search?page=${currentPage - 1}`"
      class="button mr-4"
    >&laquo; まえのページ</router-link>
    <router-link
      v-if="! isLastPage"
      :to="`/events/search?page=${currentPage + 1}`"
      class="button"
    >つぎのページ &raquo;</router-link>
  </div>
</template>

<script>
export default {
  props: {
    currentPage: {
      type: Number,
      required: true
    },
    lastPage: {
      type: Number,
      required: true
    },
  },
  computed: {
    isFirstPage () {
      return this.currentPage === 1
    },
    isLastPage () {
      return this.currentPage === this.lastPage
    }
  }
}
</script>