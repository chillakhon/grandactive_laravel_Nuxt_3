<template>

  {{messages}}

  <ul  class="list-group">
    <li v-for="message in messages" class="list-group-item">{{message.message}}</li>
  </ul>

  <div class="form">

      <div class="form-group">
        <input type="text" class="form-control" id="name" placeholder="Напиши сообщение" v-model="message">
      </div>
      <button type="button" @click="submit" class="btn btn-primary">Отправить</button>
  </div>

</template>

<script setup>

import Pusher from "pusher-js";
import axios from "axios";

let message = ''
const  messages = ref([])

const submit = async () => {
  await axios.post('/api/messageChat',{
    message: message,
    username: 'roma'
  })
  message = ''
  console.log(message)
}

onMounted(() => {
  const pusher = new Pusher('6c17bd8627071788d0e4', {
    cluster: 'ap2'
  });

  const channel = pusher.subscribe('my-channel');

  channel.bind('message', (data) => {
    messages.value.push(data);
  });
})

</script>

<style scoped>

.form{
  display: flex;
  justify-content: center;
}
.form-control{
  width: 500px;
}

.list-group{
  min-height: 300px;
}

</style>