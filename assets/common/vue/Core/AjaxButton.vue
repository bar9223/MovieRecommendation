<template>
    <button @click="onButtonClick()"  class="btn-movie-action btn-ajax">
      {{ text }}
    </button>
</template>

<script>
export default {
  props: [
    'link',
    'text',
    'direction',
  ],
  methods: {
    onButtonClick() {
      this.$http.post(this.link)
        .then(() => {
          $.app.toast.success();
          if (this.direction === 'link') {
            window.location.href = this.link;
          } else if (this.direction === 'reload') {
            location.reload()
          }
        })
        .catch(errorResponse => {
          $.app.toast.handleErrorResponse(errorResponse)
        })
    },
  }
}
</script>

<style scoped>
  .btn-ajax {
    margin: 17px 1px;
  }
</style>