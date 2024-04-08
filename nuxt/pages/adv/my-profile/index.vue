<template>
  <div class="user-profile__content">
    <div class="user-cards">
      <h1 class="user-cards__title">Мои объявления</h1>


      <div v-if="ads === 0">
        <h4 style="text-align: center; color: red"> У вас нет объявлений</h4>
      </div>


      <div v-if="useAppStore().flash" id="flash" class="alert alert-success d-flex align-items-center" role="alert">
        <font-awesome-icon :icon="['fas', 'check']" />
        <div >
          ваше объявления успешно обновлено!
        </div>
      </div>

      <div v-for="item in ads"  class="user-cards__list">
        {{item.id}}
        <div class="user-card">
          <nuxt-link  class="user-card__img " :to="`/${item.section?.urlName}/${item.category?.url_name}/ad/${item.id}`">
            <picture>
              <img :src="`${APP_URL}/api/image/${ item.images[0]?.image_path}`" alt="Изображение объявления">
            </picture>
          </nuxt-link>

          <div class="user-card__content">
            <div class="user-card__body">
              <div class="user-card__info">
                <div class="user-card__title" >{{item.name}}</div>
                <div class="user-card__category">
                  {{item.section?.name}} / {{item.category?.name}}  </div>
                <div v-if="item.price" class="user-card__price user-card-price">
                  <div class="user-card-price__value">{{item.price}}</div>
                  <span class="user-card-price__currency">руб</span>
                </div>
              </div>

              <div class="user-card__actions user-card__actions_desktop">
                <nuxt-link :to="`/adv/my-profile/${item.section?.urlName}/${item.id}`" class="user-card__action" >Редактировать</nuxt-link>
                <button type="submit" class="user-card__action" @click="deleteAd(item)" >Удалить</button>
              </div>


              <div class="dropdown">
                <a class=" dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                  <font-awesome-icon :icon="['fas', 'bars']" />
                </a>

                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                  <li><nuxt-link :to="`/adv/my-profile/${item.section?.urlName}/${item.id}`" class="dropdown-item" >Редактировать</nuxt-link></li>
                  <li><button type="submit" @click="deleteAd(item)" class="dropdown-item" >Удалить</button></li>
                </ul>
              </div>

            </div>
          </div>
        </div>
      </div>

    </div>


  </div>
</template>

<script setup>
import axios from "axios";
import {useAppStore} from "~/store/index.ts";
import adsUser from "~/middleware/adsUser.js";

const APP_URL = useRuntimeConfig().public.APP_URL
adsUser()

const ads = computed(() => useAppStore().adsUser);

const deleteAd = async (ad) => {
  if ( confirm('Вы уверены, что хотите удалить этот элемент?')){
    await axios.post('api/deleteAd', ad)
    useAppStore().updateAdsUser(ad)
    await useAppStore().fetchAdsUser()
  }
}


watch(() => {
  setTimeout(() =>{
    const flash = document.querySelector('#flash')
    flash.style.opacity = 0
  }, 2000)
  setTimeout(() =>{
    const flash = document.querySelector('#flash')
    flash.remove()
  }, 2800)
})

</script>

<style  scoped>

#flash{
  transition: opacity 1.5s;
}

@media only screen and (max-width:1200px) {
  .dropdown[data-v-08b06f27]{
    display: block;
  }
  .user-profile__content[data-v-08b06f27]{
    margin: 0;
  }
}

.dropdown{
  display: none;
}

.user-profile__content{
  margin-left: 10%;
}
.user-cards__list {
  margin-top: 1%;
}
</style>