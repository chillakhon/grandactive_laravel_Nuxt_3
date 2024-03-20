<template>
  <div v-if="!useAppStore().user" class="edit-card__login">
    <form @submit.prevent="login(user)" class="edit-card-login" >
      <div class="edit-card-login__container">
        <div class="edit-card-login__title">Войдите, чтобы продолжить</div>
        <div class="edit-card-login__wrapper">
          <div class="edit-card-login__inputs">
            <div class="edit-card-login__input ui-input-wrapper ui-input-wrapper_col">
              <input v-model="user.email" class="ui-dispersing-input ui-dispersing-input_w100" tabindex="1">
              <span class="ui-dispersing-input__placeholder">Введите email</span>
            </div>
            <div class="edit-card-login__input ui-input-wrapper ui-input-wrapper_col">
              <input v-model="user.password"  class="ui-dispersing-input ui-dispersing-input_password ui-dispersing-input_w100" tabindex="2" type="password">
              <span class="ui-dispersing-input__placeholder">Введите пароль</span>
            </div>
          </div>
          <div class="edit-card-login__actions">
            <button class="edit-card-login__btn ui-button ui-button_primary" tabindex="3" type="submit">Войти</button>
            <nuxt-link class="edit-card-login__registration-link" to="/register-user/register">Создать аккаунт</nuxt-link>
          </div>
        </div>
      </div>
    </form>
  </div>

</template>

<script setup>

import {useAppStore} from "~/store/index.ts";
import {useAuth} from "~/ composables/user/useAuth.ts";



const user = ref({
  email: '',
  password: ''
})

const { login } = useAuth()

</script>


<style  scoped>
@media only screen and (max-width: 1375px) {
  .edit-card__login[data-v-0f9733ca] {
    width: auto;
  }
}

@media only screen and (max-width: 430px) {
  .edit-card__login[data-v-0f9733ca] {
    width: auto;
    margin: 10px auto;
  }
}

.edit-card__login{
  width: 65%;
}
</style>