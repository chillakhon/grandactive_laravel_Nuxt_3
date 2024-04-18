<template>
  <div class="chat-container">
    <div class="chat-sidebar">
      <div class="search-input">
        <input type="text" placeholder="Поиск" />
        <i class="fas fa-search"></i>
      </div>
      <div class="user-list" v-for="user in activeUserMessages">
        <div
            :key="user?.id"
            class="user-item"
            :class="{ 'active-user': activeUserId == user.adv?.id}"
            @click="setActiveUser(user.adv.id)"
            v-if="useAppStore().user?.id == user.receiver?.id || useAppStore().user?.id == user.sender?.id"
        >
          <div class="user-info">
            {{activeAd?.receiver_id == useAppStore().user?.id ? activeAd?.receiver_id : activeAd?.sender_id}} / {{useAppStore().user?.id}}
            <div class="status-ad">
              <div>
                <h3>{{ useAppStore().user?.id == user.receiver?.id ? user.sender?.name : user.receiver?.name }}</h3>
              </div>
              <div v-if="notification?.adv_id == user.adv?.id" class="spinner-grow text-success">
                <span class="visually-hidden">Loading...</span>
              </div>

            </div>

            <h3 class="name_ad">{{ user.adv?.name }}</h3>
          </div>
          <div class="user-status">
            <span v-if="user.status == 'online' " class="online-status"></span>
            <span v-else class="offline-status"></span>
          </div>
        </div>
      </div>
    </div>
    <div class="chat-content">
      <div class="chat-header">
        <div class="chat-info">
          <button @click="leftChat">
            <font-awesome-icon :icon="['fas', 'chevron-left']" />
          </button>

          <h3>{{ useAppStore().user?.id == activeAd?.receiver?.id ? activeAd?.sender?.name : activeAd?.receiver?.name }}</h3>

        </div>
        <div class="header-actions">
          <button class="btn-icon">
            <font-awesome-icon :icon="['fas', 'magnifying-glass']"/>
          </button>
          <button class="btn-icon">
            <font-awesome-icon :icon="['fas', 'paperclip']"/>
          </button>
          <button class="btn-icon">
            <font-awesome-icon :icon="['fas', 'ellipsis-vertical']"/>
          </button>
        </div>
      </div>
      <div class="chat-messages" >
        <div
            v-for="message in messages"
            :key="message.id"
            :class=" { 'user-message' : message.sender_id == useAppStore().user?.id && message.adv_id == activeUserId } "
        >
          <div class="message-content" v-if="message?.adv_id == activeUserId">
            {{message.text}}
            <div
                class="chat-message-send "
                v-if="message.sender_id == useAppStore().user?.id && message.adv_id == activeUserId"
            >
              <font-awesome-icon :icon="['fas', 'check']" />
            </div>
          </div>
          <div class="message-time">{{ message.adv_id == activeUserId  ? formatTime(message.timestamp) : null }}</div>
        </div>
      </div>
      <div
          :class="{'disabled_element_input' : !activeUserId}"
          class="chat-input">
        <button class="btn-icon">
          <i class="fas fa-smile"></i>
        </button>
        <input
            type="text"
            placeholder="Напишите сообщение..."
            v-model="newMessage"
            @keyup.enter="sendMessage"
        />
        <button style="color: #3a3a3a" class="btn-icon" @click="sendMessage">
          <font-awesome-icon :icon="['far', 'paper-plane']" />
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import dayjs from 'dayjs'
import usersMiddleware from "~/middleware/usersMiddleware.js";
import {useAppStore} from "~/store/index.ts";
import messageMiddleware from "~/middleware/messageMiddleware.js";
import axios from "axios";
import Pusher from "pusher-js";
messageMiddleware()

const notification =  ref( computed(() => {
  return useAppStore()?.notification.find(receiver => (receiver.receiver_id == useAppStore().user.id))
}))

const users = ref(computed(() => {
  return useAppStore().users?.filter(user => user.id !== useAppStore().user?.id)
}))

const messages = ref(computed(() => {
    return useAppStore().message
}))



const activeUserId = ref()
const activeAd = computed(() => activeUserMessages.value?.find((ad) => ad.adv?.id == activeUserId.value))

const activeUserMessages = ref(computed(() => {
  const messages = useAppStore().message;
  if (Array.isArray(messages)) {
    const uniqueMessages = {};
    messages.forEach(message => {
      if (message && message.adv && message.adv.id) {
        if (!uniqueMessages[message.adv.id]) {
          uniqueMessages[message.adv.id] = message;
        }
      } else {
        uniqueMessages[message.id] = message;
      }
    });
    return Object.values(uniqueMessages);
  } else {
    return [];
  }
}));

const newMessage = ref('')
const sendMessage = async () => {
  // if (newMessage.value.trim() !== '') {
  //   messages.value.push({
  //     sender_id: useAppStore().user.id,
  //     text: newMessage.value,
  //     adv_id: activeAd.value?.adv_id,
  //     receiver_id: activeAd.value?.receiver_id == useAppStore().user.id ? activeAd.value?.sender_id : activeAd.value?.receiver_id,
  //     timestamp: Date.now(),
  //   })
  // }
  const formData =  new FormData
  formData.append('text', newMessage.value)
  formData.append('sender_id', useAppStore().user.id)
  formData.append('receiver_id', activeAd.value?.receiver_id == useAppStore().user.id ? activeAd.value?.sender_id : activeAd.value?.receiver_id)
  formData.append('adv_id', activeAd.value?.adv_id)
  await axios.post('/api/createMessage',formData)
  newMessage.value = ''
}


const formatTime = (timestamp) => {
  return dayjs(timestamp).format('HH:mm')
}

const setActiveUser = (adId) => {
  activeUserId.value = adId
  const notification  = useAppStore().notification.find(ad => (ad.adv_id = adId))
  if (notification) {
    useAppStore().notification.splice(useAppStore().notification.indexOf(notification), 1)
  }
  if (document.documentElement.clientWidth < 750){
    const chatSidebar = document.querySelector('.chat-sidebar')
    const chatContent = document.querySelector('.chat-content')
     chatSidebar.style.display = 'none'
      chatContent.style.opacity = 1
  }
}
const leftChat = () => {
  const chatSidebar = document.querySelector('.chat-sidebar')
  const chatContent = document.querySelector('.chat-content')
  chatSidebar.style.display = 'block'
  chatContent.style.opacity = 0
}


watch(() => {
  // console.log(activeUserId.value)
  // const notification  = useAppStore().notification.find(ad => (ad.adv_id = activeUserId))
  // if (notification) {
  //   if (notification?.adv_id == activeUserId.value) {
  //     useAppStore().notification.splice(useAppStore().notification.indexOf(notification), 1)
  //   }
  // }

})

</script>

<style>

.disabled_element_input{
  opacity: 0.5 !important;
  pointer-events: none !important;
}


.status-ad{
  display: flex;
}


@media only screen and  (max-width: 750px) {
  .chat-container{
    flex-direction: column;
    max-width: 100% !important;
    max-height: 100% !important;
    margin-right: 8px;
  }
  .chat-sidebar{
    max-width: 100% !important;
    width: 100% !important;
  }
  .chat-content{
    opacity: 0;
  }
  .chat-info{
    display: flex;
    margin: 0 auto;
    padding: 0;
  }
  .chat-info button {
    display: block !important;
    padding-right: 15px !important;
  }
  .p-5{
    padding: 3% !important;
  }
}


.chat-message-send{
  display: flex;
  justify-content: right;
}
.name_ad{
  float: right;
  background-color: #bdccf8;
  border-radius: 10px;
  padding: 5px;
}


.chat-container {
  display: flex;
  margin-top: -5%;
  margin-left: 1%;
  padding: 0;
  max-width: 90%;
  height: 700px;
  font-family: "Roboto", sans-serif;
  border-radius: 10px;
  border: 1px solid black
}

.chat-sidebar {
  width: 400px;
  min-width: 300px;
  background-color: #f0f0f0;
  border-right: 1px solid #e0e0e0;
}

.chat-content {
  flex-grow: 1;
  display: flex;
  flex-direction: column;
  max-width: 100%;
}

.search-input {
  position: relative;
  padding: 12px 16px;
  border-bottom: 1px solid #e0e0e0;
}

.search-input input {
  width: 100%;
  padding: 8px 32px 8px 12px;
  border: none;
  border-radius: 20px;
  background-color: #fff;
  font-size: 14px;
}

.search-input i {
  position: absolute;
  top: 50%;
  right: 20px;
  transform: translateY(-50%);
  color: #888;
}

.user-list {
}

.user-item {
  display: flex;
  align-items: center;
  padding: 12px;
  border-radius: 8px;
  cursor: pointer;
}

.user-item.active-user {
  background-color: #ffffff;
}

.user-avatar img {
  border-radius: 50%;
}

.user-info {
  flex-grow: 1;
  margin-left: 12px;
}

.user-info h3 {
  margin: 0;
  font-size: 16px;
  font-weight: 500;
}

.user-info p {
  margin: 0;
  font-size: 14px;
  color: #888;
}

.user-status {
  display: flex;
  align-items: center;
}

.online-status {
  width: 10px;
  height: 10px;
  border-radius: 50%;
  background-color: #4caf50;
  margin-right: 6px;
}

.offline-status {
  width: 10px;
  height: 10px;
  border-radius: 50%;
  background-color: #888;
  margin-right: 6px;
}

.chat-header {
  background-color: #075e54;
  color: #fff;
  padding: 12px 16px;
  display: flex;
  align-items: center;
}

.chat-avatar img {
  border-radius: 50%;
}

.chat-info {
  flex-grow: 1;
  margin-left: 12px;
}

.chat-info h3 {
  margin: 0;
  font-size: 16px;
  font-weight: 500;
}

.chat-info p {
  margin: 0;
  font-size: 14px;
  color: #b3b3b3;
}
.chat-info button {
  display: none;
}

.header-actions {
  display: flex;
  align-items: center;
}

.btn-icon {
  background-color: transparent;
  border: none;
  color: #fff;
  cursor: pointer;
  margin-left: 12px;
  font-size: 18px;
}

.chat-messages {
  flex-grow: 1;
  overflow-y: auto;
  padding: 12px 16px;
  background-color: #f0f0f0;
  display: flex;
  flex-direction: column;
}

.chat-message {
  display: flex;
  margin-bottom: 12px;
  align-items: flex-end;
}

.user-message {
  display: flex;
  justify-content: flex-end;
}

.bot-message {
  display: flex;
  justify-content: flex-start;
}

.message-content {
  background-color: #f4fff2;
  padding: 8px 12px;
  border-radius: 16px;
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
  max-width: 60%;
  font-size: 14px;
  line-height: 1.4;
  word-wrap: break-word;

}
.unMessage-content {
  display: none;
}

.message-time {
  font-size: 12px;
  color: #b3b3b3;
  margin-left: 8px;
}

.chat-input {
  background-color: #f0f0f0;
  padding: 12px 16px;
  display: flex;
  align-items: center;
}

.chat-input input {
  flex-grow: 1;
  padding: 8px 12px;
  border: none;
  border-radius: 20px;
  background-color: #fff;
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
  font-size: 14px;
  margin: 0 12px;
}
</style>