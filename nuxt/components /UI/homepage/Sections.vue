<template>
  <div class="main-container" >
    <div class="homepage-hero__wrapper">
      <div class="homepage-hero__content">
        <h1 class="homepage-hero__title">
          Найди свой бизнес
        </h1>
        <div class="homepage-hero__subtitle">Выбирайте из сотен объявлений со всей страны</div>
      </div>

      <div  class="homepage-hero__links">
        <nuxt-link v-for="item in useAppStore().sections" class="homepage-hero-link" :to="`${item.urlName}`">
          <div class="homepage-hero-link__img">
            <img :alt="`${item.name}`" :src="`http://127.0.0.1:8000/storage/images/img_hompage/${item.img_homepage}`">
          </div>
          <div class="homepage-hero-link__title">{{item.name}}</div>
        </nuxt-link>
      </div>
    </div>
  </div>
</template>

<script setup>
import {useAppStore} from "~/store/index.ts";
import adsMiddleware from "~/middleware/adsMiddleware.js";
adsMiddleware()




</script>

<style lang="scss" scoped>

</style>