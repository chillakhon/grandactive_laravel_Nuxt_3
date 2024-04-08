<template>
  <div class="main-container">
    <div class="category_page">
      <h1 class="category_page_title">Готовый бизнес</h1>
      <div class="category_page_content">
        <div class="category_page_content_left">
          <div class="homepage-links homepage-links_ready-business">

            <div v-for=" item in appStore.categories?.slice(1,10)" class="homepage-links__item homepage-links__item_ready-business">
              <nuxt-link class="homepage-links__link" :to="`/gotovyj-biznes/${item.url_name}`">
                <div class="homepage-links__img">
                  <font-awesome-icon :icon="['fas', item.icon  ? item.icon : 'plane-up']" />
                </div>
                <div class="homepage-links__text">{{item.name}}</div>
              </nuxt-link>
            </div>

          </div>
          <nuxt-link class="btn__outline-secondary btn-base homepage__btn-catalog" to="/gotovyj-biznes">Перейти в каталог</nuxt-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import {useAppStore} from "~/store/index.ts";

const appStore = useAppStore()


</script>

<style  scoped>

.category_page_title{
  margin-bottom: 20px;
  margin-top: 20px;
}
.category_page_content_left{

}

</style>