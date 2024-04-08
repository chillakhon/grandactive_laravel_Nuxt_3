<template>
  <div class="cart-container row row-cols-md-6">
    <div   class="card_img" >
      <nuxt-link :to="`/${ad.section?.urlName}/${ad.category?.url_name}/ad/${ad?.id}`">
        <img :src="`${APP_URL}/api/image/${ad.images[0]?.image_path}`" class="card-img-top"
             :alt="ad.name">
        <div class="card-body">
          <h5 class="card-title">{{ ad.name }}</h5>

          <div v-if="ad.price" class="short-card-data__value">
            <div class="short-card-data__value-name">Цена</div>
            <div class="short-card-data__price">
              {{ ad.price }}
            </div>
            <span class="short-card-data__currency">руб</span>

          </div>
          <div v-else class="price_not">
            <span class="short-card-data__currency">Цена не указана</span>
          </div>

          <div class="views">
            <font-awesome-icon :icon="['far', 'eye']" class="views_icon"/>
            {{ ad.views }}
          </div>
        </div>
      </nuxt-link>
    </div>
  </div>
</template>

<script setup>
import {useAppStore} from "~/store/index.ts";

const ad = defineProps({
  ad: {
    type: Object,
  }
})
console.log(ad)
</script>

<style scoped>

</style>