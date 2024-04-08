<template>
  <div class="input-group">
    <input v-model="searchValue" type="text" placeholder="Поиск..." class="form-control">
  </div>


  <ul  class="breadcrumbs catalog-content__breadcrumbs">
    <li class="breadcrumb__element" >
      <nuxt-link class="breadcrumb__element-link" to="/">
        <span >Главная</span>
      </nuxt-link>
    </li>

    <li  class="breadcrumb__element" :class="{ 'disabled-element': !useRoute().params.category  }" >
      <nuxt-link class="breadcrumb__element-link" :to="`/${useAppStore().filter_params.section?.urlName}`">
        <span>{{useAppStore().filter_params.section?.name}}</span>
      </nuxt-link>
    </li>

    <li  v-if="route.category" class="breadcrumb__element" :class="{ 'disabled-element': !useRoute().params.subCategory  }" >
      <nuxt-link class="breadcrumb__element-link" :to="`/${useAppStore().filter_params.section?.urlName}/${useAppStore().filter_params.category?.url_name}`">
        <span>{{filter_params.category?.name}}</span>
      </nuxt-link>
    </li>


    <li v-if="useRoute().params.subCategory" class="breadcrumb__element disabled" >
        <span>{{filter_params.subCategory?.subcategory_name}}</span>
    </li>
  </ul>



  <h1  class="catalog-title ">{{ route.category ? filter_params?.category?.name : filter_params?.section?.title }}</h1> {{useAppStore().ads?.length}}
  <h1 v-show="route.subCategory " class="catalog-title ">{{ ' / Подкатегории / ' + filter_params?.subCategory?.subcategory_name }}</h1>


  <div  class="category_modal">
    <ModalForCategory/>
  </div>

  <div class="cart-container">

    <div v-show="!filteredAds" class="spinner-border text-warning" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>

    <div v-if="!pageFinish" class="alert alert-danger d-flex align-items-center" role="alert">
      <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
        К сожалению, в данном разделе товар, который вы искали, отсутствует.
    </div>

    <div class="cart_item">
      <nuxt-link  v-for="ad in filteredAds"  class="short-card short-card_large" >
        <div class="short-card__img">
          <picture>
            <img :src="`${APP_URL}/api/image/${ad.images[0]?.image_path}`" class="card-img-top"
                 :alt="ad.name">
          </picture>
        </div>
        <div class="short-card__body">
          <div class="short-card__title short-card__title_bold" >{{ad.name}}</div>
          <div class="short-card__wrapper">
            <div class="short-card__data short-card-data">
              <div class="short-card-data__items">
                <div class="short-card-data__item">
                  <div v-if="ad.price" class="short-card-data__value">
                    <div class="short-card-data__value-name">Цена</div>
                    <div class="short-card-data__price">
                      {{ad.price?.toLocaleString()}}
                    </div>
                    <span class="short-card-data__currency">руб</span>
                  </div>
                  <span v-else class="short-card-data__currency">Цена не указана</span>

                </div>
                <div class="short-card-data__item short-card-data__item_list short-card-data__item_long short-card-data__item_row">
                  <div class="short-card-data__value short-card-data__value_views short-card-views" >
                    <font-awesome-icon :icon="['far', 'eye']" class="views_icon"/>
                    <div class="short-card-views__count">{{ad.views}}</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </nuxt-link>
    </div>

  </div>

  <nav v-if="pageFinish > 30" aria-label="...">
    <ul class="pagination">
      <li :class="{ 'disabled-element': currentPage === 1 }" class="page-item"  @click="currentPage > 1 ? currentPage-- : null">
        <a class="page-link" href="#">Назад</a>
      </li>

        <li v-for="(item) in visiblePageNumbers"  class="page-item" :class="{ active: currentPage == item }" @click="currentPage = item ">
          <a class="page-link" id='page' href="#">{{item}}</a>
        </li>

      <div v-if="Math.ceil(pageFinish / itemsPerPage) > 4" class="" style="display: flex">
        <span class="finish_span">...</span> <div class="page-link finished" @click="currentPage = Math.ceil(pageFinish / itemsPerPage)"> {{ Math.ceil(pageFinish / itemsPerPage)}} </div>
      </div>
      <li :class="{ 'disabled-element': currentPage === Math.ceil(pageFinish / itemsPerPage) }" class="page-item" @click="currentPage < Math.ceil(pageFinish / itemsPerPage) ? currentPage++ : null">
        <a class="page-link" href="#">Дальше</a>
      </li>
    </ul>
    <div class="input_for_pagination">
      <div class="input">
        <span class="input_page_text">
          Страница
        </span>
        <input type="text" class="form-control" placeholder="Введите номер страницы" v-model="inputValue">
        <span class="pages_for_input" >
          из {{ Math.ceil(pageFinish / itemsPerPage)}}
        </span>
        <div  class="input-group-btn">
          <button  class="btnn" type="button" @click="changePage">Перейти</button>
        </div>
      </div>
    </div>
  </nav>


</template>

<script setup>
import {useAppStore} from "~/store/index.ts";
import DropdownForNav from "~/components /DropdownForNav.vue";
import ModalForCategory from "~/components /ModalForCategory.vue";
const APP_URL = useRuntimeConfig().public.APP_URL;
const router = useRoute()
const route = router.params
const filter_params = ref(useAppStore().filter_params)

const inputValue = ref(null)
let currentPage = ref(1);
let itemsPerPage = ref(30);
let searchValue = ref(null)



const changePage = () => {
    currentPage.value = parseInt(inputValue.value)
}

let pageFinish = computed(() => {
  const ads = useAppStore().ads
  if (ads){
    return ads.length}
})

  const startIndex = computed(() => (currentPage.value - 1) * itemsPerPage.value);
  const endIndex = computed(() => startIndex.value + itemsPerPage.value);
  const filteredAds = computed(() => {
    const  ads = useAppStore().ads

    if (searchValue.value){
      return ads.filter((ad) => {
        return ad.name?.toLowerCase().includes(searchValue?.value.toLowerCase())
      })
    }

    if (ads){
      return ads.slice(startIndex.value, endIndex.value)
    } else {
      return null
    }


  });

const totalPages = computed(() => Math.ceil(pageFinish.value / itemsPerPage.value));

const visiblePageNumbers = computed(() => {

  let pages =  []

  for (let i = Math.max(1, currentPage.value - 1); i <= Math.min(totalPages.value, currentPage.value + 2); i++) {
    pages.push(i);
  }
  return pages
});

</script>

<style scoped>

@media only screen and (max-width:500px) {
  .short-card[data-v-efa81297]{
    width: 100%;
    }
  .short-card_large .short-card__img{
    height: 100%;
  }
}
@media only screen and (max-width:680px) {
  nav[data-v-efa81297]{
  }
}


.input-group{
  float: right;
  margin-right: 40px;
  width: 300px;
}

.finished{
 margin-right: 8px;
  cursor: pointer;
  color: #b000f6;
}
.finish_span{
  font-size: 18px;
  color: #4f72e7;
  margin-left: 15px;
  margin-right: 5px;
}


.pages_for_input{
  font-size: 14px;
  font-weight: 600;
  color: #8d8d8d;
}
.input_page_text{
  font-size: 14px;
  font-weight: 600;
  color: #8d8d8d;
}

nav{
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
}
.input{
  display: flex;
  align-items: center;
}
.form-control{
  width: 90px;
  margin: 10px;
  height: 35px;
  border-radius: 10px;

}

.btnn{
  border: 2px solid rgb(227, 218, 221);
  background-color: white;
  height: 35px;
  width: 90px;
  align-items: center;
  margin-left: 10px;
  font-size: 14px;
  font-weight: 600;
  color: #8d8d8d;
  border-radius: 10px;
}
.btnn:hover{
  background-color: greenyellow;
}
.input_for_pagination{

}

.category_modal{
  display: none;
}
.cart_item{
  display: flex;
  flex-wrap: wrap;
  margin-top: 10px;
}
.short-card-data__items{
  display: flex;
  justify-content: space-between;
}
.short-card_large{
  height: 100%;
  background-color: white;
}
.short-card__title {
  height: 48px;
}
.short-card__wrapper{
  display: block;
}
.short-card{
  cursor: pointer;
  border-radius: 10px;
  margin-left: 0;
  margin-right: 5px;
  width: 250px;
}
.short-card__img img{
  display: block;
}
.disabled-element{
  pointer-events: none;
  opacity: 0.5;
}

</style>

