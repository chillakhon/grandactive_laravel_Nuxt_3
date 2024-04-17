<template>
  <div class="main-container">
    <div class="homepage__title homepage__title_sm">Новое</div>
    <div class="homepage-cards-slider-container">
      <div class="homepage-cards-slider">

        <swiper
            :modules="modules"
            :slidesPerView= colPages
            :centeredSlides="false"
            :spaceBetween="30"
            :navigation="true"
            :virtual="true"
            :loop="true"
            class="mySwiper"
            @swiper="setSwiperRef"
        >
          <swiper-slide
              v-for="(ad, index) in useAppStore()?.newAds"
              :key="index"
              :virtualIndex="index">
            <div class="swiper-cart-container">
              <nuxt-link :to="`/${ad.section?.urlName}/${ad.category?.url_name}/ad/${ad.id}`">
                <img :src="`${APP_URL}/api/image/${ad.images[0]?.image_path}`" class="card-img-top" :alt="ad.name">
              </nuxt-link>
              <hr style="margin: 0"/>
              <div class="card_swiper">
                <div class="card_title_ ">{{ ad?.name }}</div>

                <div v-if="ad.price" class="card-price-amount">
                  {{ ad.price?.toLocaleString('ru-RU') }} <span> руб </span>
                </div>


                <div v-else class="card-price-amount">
                  <span> Цена не указана </span>
                </div>


                <div class="card-info">
                  <div class="card-info-item-title">{{ad.category?.name}}</div>

                  <div class="card-info-views">
                    <div class="card-info-item-title">
                      <font-awesome-icon :icon="['fas', 'eye']" /> {{ad?.views}}
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </swiper-slide>
        </swiper>

      </div>
    </div>
  </div>
</template>

<script >
import { ref } from 'vue';
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/navigation';
import 'swiper/css/virtual';
import "~/assets/css/swiper.css"

import { Pagination, Navigation, Virtual } from 'swiper/modules';
import ContentAdForSwiper from "~/components /UI/homepage/ContentAdForSwiper.vue";
import {useAppStore} from "~/store/index.ts";


export default {

  methods: {useAppStore},
  components: {
    ContentAdForSwiper,
    Swiper,
    SwiperSlide,
  },
  setup() {
    let swiperRef = null;
    let APP_URL = useRuntimeConfig().public.APP_URL;
    let colPages = ref(4)
    const setSwiperRef = (swiper) => {
      swiperRef = swiper;
    };
    const slideTo = (index) => {
      swiperRef.slideTo(index - 1, 0);
    };

    onMounted(()=> {
      handleResize()
      window.addEventListener('resize', handleResize)
    })

    const  handleResize = () => {
      if (window.innerWidth < 1208) {
        colPages.value = 3
      }
      if (window.innerWidth < 900) {
        colPages.value = 2
      }
      if (window.innerWidth < 560) {
        colPages.value = 1
      }
    }

    return {
      swiperRef: null,
      setSwiperRef,
      slideTo,
      colPages,
      modules: [Pagination, Navigation, Virtual],
      APP_URL,
    };
  },
};

</script>

<style scoped>

.main-container{
  margin-top: 5%;
}
.swiper-cart-container{
  width: 100%;
  height: 100%;
  border: 1px solid #c5c5c5;
  border-radius: 10px;
  background-color: white;
  overflow: hidden;
  cursor: pointer;
}
.swiper-cart-container:hover{
  box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
}

.card_swiper{
  display: flex;
  flex-direction: column;
  margin: 10px;
}
.card_title_{
  display: flex;
  height: 50px;
  font-size: 17px;
  color: #5b5b5b;

}
.card-price-amount{
  display: flex;
  font-size: 17px;
  color: #4f72e7;
  font-weight: 500;
}
.card-price-amount span {
  color: #8f8f8f;
  font-size: 14px;
  margin-left: 5px;
}
.card-info{
  display: flex;
  justify-content: space-between;
  padding-top: 20px;
  font-size: 16px;
  color: #656565;
}

</style>