<template>
  <ClientOnly>
    <div class=" header-bottom header_right  position-sticky z-10" style="top: 0">
      <div class="main-container" style="">
        <div class="header-bottom__wrapper">
          <DropdownForNav/>

          <nuxt-link to="/" class="header-bottom__logo logo">
            <img alt="Grand Active" itemprop="contentUrl" src="https://www.grandactive.ru//dist/Images/header/logo.svg" width="158" height="23">
          </nuxt-link>
          <div class="header-bottom__actions">
            <div  class="header-bottom__services header-services">
              <div v-if="!useAppStore().user" class="header-services__profile header-services__service profile-dropdown ui-dropdown ui-dropdown_gray">
                <button type="button" class="profile-dropdown__btn ui-dropdown__btn" data-bs-toggle="modal" data-bs-target="#exampleModal">
                  Войти
                </button>
              </div>
              <div @click="showProfile" v-else id="profile_dropdown" class="profile-dropdown__btn ui-dropdown__btn">
                <div class="profile-dropdown__avatar" data-current-user-avatar="">
                  <img id="img_avatar" alt="Avatar" src="https://www.grandactive.ru/UploadedFiles/Avatars/100x100/cbc5f4c6-1af2-4ab4-a268-e272260c685d.png">
                </div>
                <div class="profile-dropdown__name" data-current-user-short-name="">
                  {{useAppStore().user.name}}
                </div>
              </div>
              <div >
                <div v-if="show" id="profileId" class="profile-dropdown__content profile-dropdown__content_mobile ui-dropdown__content"
                     style="display: flex;">
                  <nuxt-link class="ui-dropdown__item" to="/adv/my-profile">Мои объявления</nuxt-link>
                  <nuxt-link class="ui-dropdown__item" to="/message/message-users">Сообщение</nuxt-link>

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
import "~/assets/css/mediaAdap.css"

import AuthUser from "~/components /auth/auth-user.vue";
import {useAppStore} from "~/store/index.ts";
import axios from "axios";
import DropdownForNav from "~/components /DropdownForNav.vue";

const show = ref(false)
const user = useAppStore().user
const showProfile = () => {
  show.value = !show.value
}

const logout = async () => {
  let token = useCookie('token')

  if (token.value) {
    onMounted(() => {
      token.value = null
    })
    await axios.post('/api/logout')
    useAppStore().user = null
    token.value = null
  }

  await useRouter().replace('/')
}

onMounted(() => {
  document.addEventListener('click' , (e) => {
    const profile =  document.querySelector('#img_avatar')
    const profileId =  document.querySelector('.profile-dropdown__name')
    if (profile != e.target) {
      show.value = false
    }
  })
})




</script>

<style >

.profile-dropdown__content{
  margin-right: 240px;
  margin-top: 12px;
}


@media only screen and (max-width:760px) {
  .profile-dropdown__content{
    margin-right: 25px;
    margin-top: 6px;
  }
}

</style>