<template>
  <div class="modal" id="myModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Контакты продавца</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Имя: {{ad.user.name}}</p>
          <p>Почта: {{ad.user.email}}</p>
        </div>

      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  ad: {}
})

</script>

<style scoped>

</style>