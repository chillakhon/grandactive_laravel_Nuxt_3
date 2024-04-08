<template>
  <div class="main-container">
    <div class="homepage__title homepage__title_sm">Популярное</div>
    <div class="homepage-cards-slider-container">
      <div class="homepage-cards-slider">

          <swiper
              :modules="modules"
              :slidesPerView= colPages
              :centeredSlides="false"
              :spaceBetween="30"
              :pagination="{
        type: 'fraction',
      }"
              :navigation="true"
              :virtual="true"
              class="mySwiper"
              @swiper="setSwiperRef"
          >
            <swiper-slide
                v-for="(ad, index) in useAppStore()?.popularAds"
                :key="index"
                :virtualIndex="index">
              <div class="swiper-cart-container">
                <nuxt-link :to="`/${ad.section?.urlName}/${ad.category?.url_name}/ad/${ad.id}`">
                <img :src="`${APP_URL}/api/image/${ad.images[0]?.image_path}`" class="card-img-top" :alt="ad.name">
                </nuxt-link>
                <div class="card_swiper">
                  <div class="card_title_ ">{{ ad.name }}</div>

                  <div class="card-price">
                    <div class="card-price-amount">
                      {{ ad.price?.toLocaleString('ru-RU') }} <span> руб </span>
                    </div>
                  </div>
                  <div class="card-info">
                      <div class="card-info-item-title">{{ad.category.name}}</div>

                    <div class="card-info-views">
                      <div class="card-info-item-title">
                        <font-awesome-icon :icon="['fas', 'eye']" /> {{ad.views}}
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
}
.card_title_{
  display: flex;
  justify-content: left;
  font-size: 20px;
  font-weight: 600;
  padding: 15px 15px 10px 10px;
}
.card-price{
  display: flex;
  justify-content: left;
  padding-left: 10px;
  margin-top: 15px;
}
.card-price-amount{
  font-size: 20px;
  font-weight: 600;
  color: #1976D2;
}
.card-price-amount span{
  font-size: 15px;
  color: #5b5b5b;
}

.card-info{
  display: flex;
  justify-content: space-between;
  padding-left: 10px;
  margin-top: 20px;
  margin-bottom: 20px;
  color: #5b5b5b;
}
.card-info-item-title{
  margin-right: 10px;
}

</style>