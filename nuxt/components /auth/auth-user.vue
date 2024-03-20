<template>
  <div class="container  p-5" id="display">
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" ref="exampleModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="btn_close">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="register-auth">
            <div class="login-create-account__text">Еще нет аккаунта?</div>
            <nuxt-link to="/register-user/register">
              <button type="button" class="text__primary " data-bs-toggle="modal" data-bs-target="#exampleModal">Создать аккаунт</button>
            </nuxt-link>
          </div>

          <div class="modal-header">
            <h5 class="modal-title text-black" id="exampleModalLabel">Вход</h5>
          </div>
          <div class="modal-body">
            <form @submit.prevent="login(user)">
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Введите email</label>
                <input v-model="user.email"  type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
<!--                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>-->
              </div>
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Введите пароль</label>
                <input v-model="user.password"  type="password" class="form-control" id="exampleInputPassword1">
              </div>
              <button type="submit" class="btn btn-primary">Войти</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import {useAuth} from "~/ composables/user/useAuth.ts";
const exampleModal = ref(null);

const user = ref({
  email: '',
  password: ''
})
const { login } = useAuth()

</script>

<style  scoped>


.register-auth{
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin: 15px 15px;
}
.btn_close{
  display: flex;
  justify-content: flex-end;
  margin:  10px;
}

</style>