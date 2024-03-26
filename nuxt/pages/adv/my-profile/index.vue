<template>
  <div class="user-profile__content">
    <div class="user-cards">
      <h1 class="user-cards__title">Мои объявления</h1>

      <div v-for="item in useAppStore().adsUser"  class="user-cards__list">
        <div class="user-card">

          <a  class="user-card__img " href="/ishchu-partnera/nbef-1351">
            <picture>
              <img :src="`http://127.0.0.1:8000/storage/images/${ item.images[0]?.image_path}`" alt="Изображение объявления">
            </picture>
          </a>

          <div class="user-card__content">
            <div class="user-card__body">
              <div class="user-card__info">
                <a target="_blank" class="user-card__title" href="/ishchu-partnera/nbef-1351">{{item.name}}</a>
                <div class="user-card__category">
                  {{item.section.name}}
                  {{item.sub_category ? `/ ${item.sub_category.subcategory_name}` : '' }}</div>
                <div class="user-card__price user-card-price">
                  <div class="user-card-price__value">{{item.price}}</div>
                  <span class="user-card-price__currency">руб</span>
                </div>
              </div>

              <div class="user-card__actions user-card__actions_desktop">
                <nuxt-link :to="`/adv/my-profile/${item.section.urlName}/${item.id}`" class="user-card__action" >Редактировать</nuxt-link>
                <button type="submit" class="user-card__action" @click="deleteAd(item)" >Удалить</button>
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

const deleteAd = (ad) => {
  axios.post('api/deleteAd', ad).then(
      res => {
      useAppStore().adsUser = res.data
      }
  )
}


</script>

<style  scoped>
.user-profile__content{
  margin-left: 10%;
}
.user-cards__list {
  margin-top: 1%;
}
</style>