<template>
  <div class="content">
    <div class="content_block" >

      <div class="content_block_imag">
        <img  :src="`${APP_URL}/api/image/${ad.images[0]?.image_path}`" id="for-pop-up" class="card-img-top"
             :alt="ad.name">
      </div>

      <div class="pop-up">
        <span id="close-pop-up">&times;</span>
        <img :src="`${APP_URL}/api/image/${ad.images[0]?.image_path}`" class="card-img-top"
             :alt="ad.name">
      </div>

      <div class="content_block_text">

        <div class="content_block_header">

          <div v-if="useAppStore().flash.success" id="flash" class="alert alert-success d-flex align-items-center" role="alert">
            <font-awesome-icon :icon="['fas', 'check']" />
            <div >
              Ваше сообщение успешно отправлено!
            </div>
          </div>


          <h1 class="card-title">{{ ad.name }}</h1>

          <ul class="breadcrumbs">
            <li class="breadcrumb__element">
              <nuxt-link class="breadcrumb__element-link" to="/">
                <span>Главная</span>
              </nuxt-link>
            </li>

            <li class="breadcrumb__element" >
              <nuxt-link class="breadcrumb__element-link" :to="`/${ad.section?.urlName}`">
                <span>{{ad.section?.name}}</span>
              </nuxt-link>
            </li>

            <li class="breadcrumb__element" >
              <nuxt-link class="breadcrumb__element-link" :to="`/${ad.section?.urlName}/${ad.category?.url_name}`">
                <span>{{ad.category?.name}}</span>
              </nuxt-link>
            </li>

            <li class="breadcrumb__element" >
              <nuxt-link class="breadcrumb__element-link" :to="`/${ad.section?.urlName}/${ad.category?.url_name}/${ad.sub_category?.url_name}`">
                <span>{{ad.sub_category?.subcategory_name}}</span>
              </nuxt-link>
            </li>

          </ul>
            <span class="disabled_element" style="margin-top: -15px; font-size: 14px">{{ad.name}}</span>
        </div>
        <hr style="margin-right: 3%;"/>

        <div class="content_info flex">
          <div class="content_info_data">
            <div class="content_info_data_item_title ">
              <span>Дата публикации</span>
            </div>
            <div class="content_info_data_item_value">
              <span>{{ formattedDatetime }} </span>
            </div>
          </div>

          <div class="content_info_views">
            <div class="content_info_data_item_title ">
              <span>Просмотров</span>
            </div>
            <div class="content_info_data_item_value">
              <span>{{ ad.views }}</span>
            </div>
          </div>
        </div>

        <div class="content_info_price_contact flex">
          <div class="content_info_data_item ">
            <div class="content_info_data_item_title ">
              <span>Цена</span>
            </div>
            <div v-if="ad.price" class="content_info_price_value">
              <span >{{ ad.price?.toLocaleString('ru-RU') }}</span>руб
            </div>
            <div v-else class="card-price_not ">Не указан</div>
          </div>

          <div class="content_for_modal">
            <button type="button" data-bs-toggle="modal" data-bs-target="#myModal" class="nuxt_button">
              <div class="content_info_contact_title">
                <span> Показать Контакты</span>
              </div>
            </button>
            <ModalForContact :ad='ad'/>

            <button type="button" data-bs-toggle="modal"  :data-bs-target="` ${ useAppStore().user ? '#modal_for_message' : '#exampleModal'  } `" class="modal_button_for_message">
              <div class="content_info_contact_message">
                <span>Нописать сообщение</span>
              </div>
            </button>
            <ModalForMessage :ad="ad"/>
          </div>
        </div>

        <div v-if="ad.city" class="city">
          <span>Город: </span>{{ad.city?.city}}
        </div>

        <hr style="margin-right: 3%;"/>

        <div class="content_info_description">
          <div class="content_info_description_title">
            <span>Описание</span>
          </div>
          <div class="content_info_description_value">
            <span>{{ ad.description }}</span>
        </div>
        </div>

        <div v-if="ad.city" class="content_info_city">
          <div class="content_info_city_title">
            <span>Где находится</span>
          </div>
          <div class="content_info_city_value">
            <span>Таджикистан, {{ ad.city.city }}</span>
          </div>
        </div>


        <div class="content_info_more">
          <div class="content_info_more_title">
            <span>Дополнительная информация</span>
          </div>
          <div class="content_info_more_value flex">
            <div>Форма собственности</div>
            <div class="title_type">{{ad.type}}</div>
          </div>

          <div v-if="ad.investment_size" class="content_info_more_value flex">
            <div>Размер инветиций </div>
            <div class="title_type" style="margin-left: 9%">{{ad.investment_size?.toLocaleString('ru-RU')}} руб</div>
          </div>

          <div v-if="ad.investment_sum_max" class="content_info_more_value flex">
            <div>Сумма инвестиций</div>
            <div class="title_type" style="margin-left: 9%">{{ad.investment_sum_min?.toLocaleString('ru-RU')}} - {{ad.investment_sum_max?.toLocaleString('ru-RU')}} руб</div>
          </div>


        </div>

      </div>

    </div>
  </div>
</template>

<script setup>
import axios from "axios";
import {useAppStore} from "~/store/index.ts";
import {date} from "~/ composables/date.js";
import ModalForContact from "~/components /ModalForContact.vue";
import ModalForMessage from "~/components /ModalForMessage.vue";
const APP_URL = useRuntimeConfig().public.APP_URL
const route = useRoute().params

const ad = await axios.get(`api/ad/${route.id}`).then(res => {
  return res.data
})
const { formattedDatetime } = date(ad.created_at)


watch(
    () => useAppStore().flash.success, (newValue, oldValue) => {
      if (newValue) {
        console.log('jb')
        setTimeout(() => {
          useAppStore().flash.success = false
        }, 3500)
      }
    }
)


onMounted(() => {
  document.addEventListener("click", imageClick)
})


const imageClick = (e) => {
  const imgClass =  document.getElementById('for-pop-up')
  const popUpClose = document.getElementById('close-pop-up')
  if (imgClass == e.target){
    document.querySelector('.pop-up').style.display = 'block'
  }
  if (popUpClose == e.target){
    document.querySelector('.pop-up').style.display = 'none'
  }
}


</script>

<style  scoped>


.content_for_modal{
  display: flex;
  flex-direction: column;
  margin-right: 20px;
}

.content_block_imag{
  width: 37%;
  height: 100%;
  overflow: hidden;
  border: 3px solid #ffffff;
  border-radius: 10px;
}

.content_block_imag img {
  cursor: pointer;
  object-fit: cover;
  transition: .5s ;
}
.content_block_imag img:hover{
  transform: scale(1.1);
}

.content_block .pop-up{
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.8);
  z-index: 1000;
  display: none;
}
.content_block .pop-up img {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  border: 5px solid white;
  border-radius: 10px;
  width: 65%;
}
.content_block .pop-up span {
  position: fixed;
  top: 5%;
  right: 5%;
  width: 40px;
  height: 40px;
  background-color: white;
  border-radius: 50%;
  cursor: pointer;
  z-index: 1001;
  font-size: 40px;
  text-align: center;
  line-height: 30px;
}



@media only screen and (max-width:1000px) {
  .content_block[data-v-cda31e94]{
    flex-direction: column;
  }
  .content_block_imag[data-v-cda31e94]{
    width: 100%;
  }
  .content_block_text[data-v-cda31e94]{
    width: 100%;
  }
  .content[data-v-cda31e94]{
    max-width: 97%;
  }
}

.content_info_more_value{
  margin-top: 2%;
}
.content_info_more{
  margin: 3% 0 3% 0;
}
.title_type{
  margin-left: 5%;
  font-weight: 600;
  font-size: 14px;
}
.content_info_more_title{
  font-weight: 700;
  font-size: 18px;
  line-height: 21px;
  margin-bottom: 8px;
  margin-top: 16px;
}

.content_info_city_title{
  font-weight: 700;
  font-size: 18px;
  line-height: 21px;
  margin-bottom: 8px;
}

.content_info_description_title{
  font-weight: 700;
  font-size: 18px;
  line-height: 21px;
  margin-bottom: 16px;
}
.content_info_description_value{
  font-size: 16px;
  line-height: 21px;
  margin-bottom: 2%;
  margin-right: 2%;
}

.city{
  font-size: 16px;
  font-weight: 100;
  margin-top: 2%;
  margin-bottom: 10px;
}

.city span {
  font-weight: bold;
  margin-right: 5px;
}

.nuxt_button{
 margin-top: 2%;
}
.nuxt_button :hover {
  background-color: #ff00a6;
  cursor: pointer;
}

.modal_button_for_message :hover {
  background-color: #13e109;
  cursor: pointer;
}

.content_info_data_item{
  margin-right: 14%;
}

.content_info_contact_title{
  margin-top: 4%;
  background-color: #B01F7E;
  border-radius: 10px;
  padding: 10px 20px;
}

.content_info_contact_message{
  margin-top: 4%;
  background-color: #1fb021;
  border-radius: 10px;
  padding: 10px 20px;
  color: white;
  font-weight: 600;
}


.content_info_contact_title span{
  color: white;
  font-weight: 600;
}


.content_info_price_value{
  color: #1976D2;
}
.content_info_price_value span{
  margin-right: 4px;
  font-size: 36px;
  line-height: 42px;
  color: #1976D2;
}

.card-price_not{
  font-size: 24px;
  line-height: 28px;
  align-items: baseline;
  color: #1976D2;
}

.content_info_price_contact{
  display: flex;
  align-items: center;
  justify-content: space-between;
}


.content_info_views{
  margin-left: 30%;
}

.content_info_data_item_title{
  font-weight: 500;
  color: #C4C4C4;
}

.breadcrumbs{
  margin-top: 1%;
}

.content{
  width: 100%;
  height: 100%;
  max-width: 85%;
  margin-left: 2%;
  margin-top: -4%;
}

.content_block{
  display: flex;
}

.content_block_imag img{
  width: 100%;
  height: 100%;
  border-radius: 1px;
}

.content_block_text{
  width: 65%;
  height: 100%;
  display: flex;
  flex-direction: column;
  justify-content: center;
  padding-left: 2%;
}

.disabled_element{
  pointer-events: none;
  opacity: 0.5;
}
.breadcrumbs{
  padding-bottom: 1px;
}

</style>