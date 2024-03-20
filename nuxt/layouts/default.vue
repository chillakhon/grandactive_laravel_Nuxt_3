<template>
  <ClientOnly>
    <div class="header-bottom header_right  position-sticky z-10" style="top: 0">
      <div class="main-container">
        <div class="header-bottom__wrapper">
          <nuxt-link to="/" class="header-bottom__logo logo">
            <img alt="Grand Active" itemprop="contentUrl" src="https://www.grandactive.ru//dist/Images/header/logo.svg" width="158" height="23">
          </nuxt-link>
          <div class="header-bottom__actions">
            <div class="header-bottom__services header-services">
              <div v-if="!useAppStore().user" class="header-services__profile header-services__service profile-dropdown ui-dropdown ui-dropdown_gray">
                <button type="button" class="profile-dropdown__btn ui-dropdown__btn" data-bs-toggle="modal" data-bs-target="#exampleModal">
                  Войти
                </button>
              </div>
              <div @click="showProfile" v-else class="profile-dropdown__btn ui-dropdown__btn">
                <div class="profile-dropdown__avatar" data-current-user-avatar="">
                  <img alt="Avatar" src="https://www.grandactive.ru/UploadedFiles/Avatars/100x100/cbc5f4c6-1af2-4ab4-a268-e272260c685d.png">
                </div>
                <div class="profile-dropdown__name" data-current-user-short-name="">
                  {{useAppStore().user.name}}
                </div>
              </div>
              <div >
                <div v-if="show" id="profileId" class="profile-dropdown__content profile-dropdown__content_mobile ui-dropdown__content"
                     style="display: flex;">
                  <a class="ui-dropdown__item" href="/lk/wallet">Кошелёк</a>
                  <a class="ui-dropdown__item" href="/lk/cards">Мои объявления</a>
                  <a class="ui-dropdown__item" href="/lk/lots">Мои лоты</a>
                  <a class="ui-dropdown__item" href="/lk/bets">Ставки</a>
                  <a class="ui-dropdown__item" href="/lk/deals">Сделки</a>
                  <a class="ui-dropdown__item" href="/lk/settings">Настройки</a>
                  <div class="ui-dropdown__divider"></div>
                  <nuxt-link @click="logout" class="ui-dropdown__item">Выйти</nuxt-link>
                </div>
              </div>
            </div>
            <div class="header-bottom__btn-create-card">
              <nuxt-link to="/adv" class="btn-create-card ">Подать объявление</nuxt-link>
            </div>
          </div>
        </div>
      </div>
    </div>
    <section >
      <auth-user/>
      <slot/>
    </section>
    <footer>
      <slot name="footer"/>
    </footer>
  </ClientOnly>
</template>

<script setup>
import "~/assets/css/app.main.css"
import "~/assets/css/responsive.css"
import AuthUser from "~/components /auth/auth-user.vue";
import {useAppStore} from "~/store/index.ts";
import axios from "axios";

const show = ref(false)
const user = useAppStore().user
const showProfile = () => {
  show.value =!show.value
}

const logout = async () => {
  let token = useCookie('token')

  if (token.value) {
    onMounted(() => {
      token.value = null
    })
    await axios.post('/api/logout')
    useAppStore().user = null
  }
  await useRouter().replace('/')
}

onMounted(() => {
  document.addEventListener('click', handleClickOutside);
});

const handleClickOutside = (event) => {
  const clickedElement = event.target;
  const profileDropdownName = document.getElementsByClassName('profile-dropdown__name')[0];
  if (clickedElement === profileDropdownName) {
  }else {
    show.value = false
  }
}


</script>

<style >

.profile-dropdown__content{
  margin-right: 240px;
  margin-top: 12px;
}

@media only screen and (max-width: 552px) {
  .header_right{
    display: flex;
    max-width: 100%;
  }
}

</style>