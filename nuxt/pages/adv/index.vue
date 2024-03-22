<template>

    <div class="ca">
      <div class="main-container">
        <h1 class="ca__suptitle">Подать объявление о продаже бизнеса</h1>
        <div class="ca__title">Выберите тип объявления</div>

        <div class="ca__blocks">
          <div class="ca__block ca-block ca-block_cards">
            <div class="ca-block__title ca-block__title_cards">Доска объявлений</div>
            <div class="ca-block__tiles row">
              <div class="col-6 col-sm-6 col-xxl-4 col-xl-4 col-lg-4 col-md-4" v-for="item in section">
              <nuxt-link rel="nofollow" class="ca-block__tile ca-tile" :to="`/adv/${item.urlName}/new`">
                <div class="ca-tile__img">
                  <img :src="item.img" :alt="item.name">
                </div>
                <div class="ca-tile__title">{{item.name}}</div>
              </nuxt-link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

</template>

<script setup>

import axios from "axios";

const section = await axios.get('api/section').then(res => {
  return res.data;
})

</script>

<style scoped>


@media  only screen and (max-width: 770px) {
  .ca__suptitle{
    font-size: 15px;
    line-height: 20px;
    margin-left: 10px
  }
  .ca__title{
    font-size: 20px;
    line-height: 20px;
    margin-left: 10px
  }
  .ca-block__title{

    margin-left: 10px
  }
}





</style>