<template>
  <div class="container p-5" >
    <div class="form-register">
  <form @submit.prevent="register(user)">
    <div class="mb-3">
      <div class="page-back__text page-back__text_sm">Новый аккаунт</div>
    </div>
    <div class="mb-3">
      <label for="name" class="form-label">Имя</label>
      <input v-model="user.name" type="text" class="form-control" id="exampleInputName" aria-describedby="nameHelp">
    </div>
    <div class="mb-3">
      <label for="exampleInputEmail1" class="form-label">Электронная почта</label>
      <input v-model="user.email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
    </div>
    <div class="mb-3">
      <label for="exampleInputPassword1" class="form-label">Придумайте пароль</label>
      <input v-model="user.password" type="password" class="form-control" id="exampleInputPassword1">
    </div>

    <div class="flex justify-content-center">
    <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
    </div>
  </form>
  </div>
  </div>
</template>

<script setup>
import axios from "axios";
import {useAppStore} from "~/store/index.ts";
import {useAuth} from "~/ composables/user/useAuth.ts";

const user = ref([
    {
        name: '',
        email: '',
        password: ''
    }
])



const register = async (user) => {
  await axios.post('api/register',{
    name: user.name,
    email: user.email,
    password: user.password
  }).then(res => {
    const cookie = useCookie('token')
    if (cookie){
      cookie.value = null
    }
    cookie.value = res.data.token
    useAppStore().user = res.data.user
    navigateTo('/')
  })
}


</script>

<style  scoped>
.form-register{
  max-width: 400px;
  margin: 0 auto;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 10px;
}

</style>