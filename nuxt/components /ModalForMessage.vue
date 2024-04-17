<template>

  <div class="modal fade" id="modal_for_message" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">New message</h5>
          <button type="button" id="btn-close" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form>
            <div class="mb-3">
              <div  class=col-form-label><span> Продовец: </span> {{ useAppStore().user.id == ad.user.id ? 'Вы сами продавец!' : ad.user.name }}</div>
            </div>
            <div class="mb-3">
              <label for="message-text" class="col-form-label">Message:</label>
              <textarea v-model="newMessage" class="form-control" id="message-text"></textarea>
            </div>
            <div v-show="useAppStore().flash.adMessage" class=" alert-danger" role="alert">
              Поля message обязателено для заполнения
            </div>
          </form>
        </div>
        <div class="modal-footer" :class="{ 'disblock' : useAppStore().user.id == ad.user.id }">
          <button @click="addMessage"  type="button" class="btn btn-primary">Отпровить</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import {useAppStore} from "../store/index.ts";
import axios from "axios";

const newMessage = ref('')

const adForMessage = defineProps({
  ad: {}
})

const addMessage = async () => {
  if (!newMessage.value){
    useAppStore().flash.adMessage = true
    return
  }
  const formData =  new FormData
  formData.append('text', newMessage.value)
  formData.append('sender_id', useAppStore().user.id)
  formData.append('receiver_id', adForMessage.ad?.user?.id)
  formData.append('adv_id', adForMessage.ad?.id)
  await axios.post('/api/createMessage',formData).then(res => {
    console.log(res.data)
  })
  useAppStore().flash.success = true
  useAppStore().flash.adMessage = false
  newMessage.value = ''
  const btnClose =  document.getElementById('btn-close')
  btnClose.click().setAttribute('data-bs-dismiss', 'modal')
}


</script>

<style scoped>
.alert-danger{
  margin-top: -8px;
  margin-left: 4px;
  color: red;
}

.disblock{
  opacity: 0.5;
  pointer-events: none;
}
.col-form-label{
  font-size: 16px;
  font-weight: 600;
  color: #696969;

}
.col-form-label span{
  font-size: 18px;
  color: #606060;
}
</style>