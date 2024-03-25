<template>

  <div class="edit-card__page-back edit-card__page-back_mb-lg page-back">
    <nuxt-link to="/adv" class="page-back__link" >
      <svg fill="none" height="19" viewBox="0 0 19 19" width="19" xmlns="http://www.w3.org/2000/svg">
        <path d="M9.48528 17.9706L1 9.48528M1 9.48528L9.48528 1M1 9.48528H17.9706" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
      </svg>
    </nuxt-link>
    <h1 class="page-back__text">
      Рекламное объявление
    </h1>
  </div>

  <auth-user-new/>

  <div class="section">
  <form  class="form" @submit.prevent="createAdv(data)">
    <div class="edit-card-section">
      <div class="edit-card-section__content">
        <div class="edit-card-block edit-card-block_card-sections">
          <div class="edit-card-block__title">Выберите раздел</div>
          <div class="edit-card-block__content">
            <ul class="card-sections-list">
              <li class="card-sections-list__item" v-for="item in section">
                <div v-if="item.urlName === urlSection" class="card-sections-list__link card-sections-list__link_active">{{item.name}}
                </div>
                <nuxt-link v-else class="card-sections-list__link" :to="`/adv/${item.urlName}/new`">{{item.name}}</nuxt-link>
              </li>
            </ul>
          </div>
        </div>

        <div class="edit-card-block edit-card-block_mb-sm">
          <div class="edit-card-block__title edit-card-block__title_pt-sm edit-card-block__title_required">Название</div>
          <div class="edit-card-block__content">
            <input v-model="data.name"  name="title" class="ui-input ui-input_w100" placeholder="Введите название" type="text">
          </div>
        </div>

        <div class="edit-card-block edit-card-block_mb-md">
          <div class="edit-card-block__title edit-card-block__title_pt-sm edit-card-block__title_required">Категория</div>
          <div class="edit-card-block__content">
            <div class="edit-card__categories edit-card-block__row">
              <div class="dropdown-select dropdown-select__category">
                <button class="dropdown__button" @click="toggleDropdown" type="button">
                   {{selectedCategory ? selectedCategory.name : 'Выберите категорию'}}
                </button>
                <ul v-show="isDropdownOpen" class="dropdown__list">
                  <li @click="selectCategory(category)" v-for="category in categories" class="dropdown__list-item">{{category.name}}</li>
                </ul>
              </div>
              <div v-show="selectSubCategory" @click="toggleDropdownSub" class="dropdown-select  dropdown-select__subcategory ">
                <button class="dropdown__button" type="button">
                  {{selectedSubCategory ? selectedSubCategory.subcategory_name : 'Выберите подкатегорию'}}
                </button>
                <ul v-show="isDropdownOpenSub" class="dropdown__list">
                  <li @click="SubCategory(subCategory)" v-for="subCategory in selectSubCategory" class="dropdown__list-item">{{subCategory.subcategory_name}}</li>
                </ul>
              </div>
            </div>
          </div>
        </div>

        <div class="edit-card-block edit-card-block_mb-lg">
          <div class="edit-card-block__title edit-card-block__title_pt-sm edit-card-block__title_required">Описание</div>
          <textarea v-model="data.description"  class="ui-textarea ui-textarea_tinymce ui-textarea_w100" name="Description">
          </textarea>
        </div>

        <div class="edit-card-block edit-card-block_mb-lg">
          <div class="edit-card-block__title edit-card-block__title_pt-sm edit-card-block__title_required">Фотографии</div>
          <div class="edit-card-block__content">
            <div class="edit-card-block__upload-files upload-files">
              <div class="upload-files__previews">
                <div class='fff' >
                  <div class="image_Url"
                       v-for="(image, index) in imageUrl" :key="index">
                    <button type="button" class="button_btt" @click="deleteImage(index)">x</button>
                    <img class="img_btn" :src="image" alt="">
                  </div>
                  <label class="upload-files__btn upload-files-btn ">
                    <input
                        class="upload-files__input"
                        multiple=""
                        type="file"
                        @change="handleImageSelected"
                    >
                    <svg class="upload-files-btn__icon" fill="none" height="25" viewBox="0 0 24 25" width="24"
                         xmlns="http://www.w3.org/2000/svg">
                      <path
                          d="M6 4.17383C6 2.51697 7.34315 1.17383 9 1.17383H15C16.6569 1.17383 18 2.51697 18 4.17383H6Z"></path>
                      <path clip-rule="evenodd"
                            d="M4 4.17383C1.79086 4.17383 0 5.96469 0 8.17383V19.1738C0 21.383 1.79086 23.1738 4 23.1738H20C22.2091 23.1738 24 21.383 24 19.1738V8.17383C24 5.96469 22.2091 4.17383 20 4.17383H4ZM8 13.1738C8 10.9647 9.79086 9.17383 12 9.17383C14.2091 9.17383 16 10.9647 16 13.1738C16 15.383 14.2091 17.1738 12 17.1738C9.79086 17.1738 8 15.383 8 13.1738ZM12 7.17383C8.68629 7.17383 6 9.86012 6 13.1738C6 16.4875 8.68629 19.1738 12 19.1738C15.3137 19.1738 18 16.4875 18 13.1738C18 9.86012 15.3137 7.17383 12 7.17383Z"
                            fill-rule="evenodd"></path>
                    </svg>
                    <span class="upload-files-btn__text">Добавить</span>
                  </label>
                </div>
              </div>
            </div>
          </div>
        </div>


        <div v-if="urlSection === 'franshizy'" class="edit-card-block edit-card-block_mb-md">
          <div class="edit-card-block__title edit-card-block__title_pt-sm edit-card-block__title_required">Сумма инвестиций</div>
          <div class="edit-card-block__content">
            <div class="ui-input-wrapper ui-input-wrapper_align-center">
              <div class="ui-input-range">
                <input v-model="data.investment_sum_min"   type="number"  placeholder="от" class="ui-input-range__input ui-input-range__input_min" >
                <input v-model="data.investment_sum_max"  type="number" placeholder="до" class="ui-input-range__input ui-input-range__input_max" >
              </div>
              <span class="ui-input-wrapper__input-text">руб</span>
            </div>
          </div>
        </div>


        <div v-if="urlSection === 'gotovyj-biznes'"  class="edit-card-block edit-card-block_mb-md">
          <div class="edit-card-block__title edit-card-block__title_pt-sm edit-card-block__title_required">Цена
            бизнеса
          </div>
          <div class="edit-card-block__content">
            <div class="ui-input-wrapper ui-input-wrapper_align-center">
              <input v-model="data.price" class="ui-input ui-input_sm js-input_digit" type="number">
              <span class="ui-input-wrapper__input-text">руб</span>
            </div>
          </div>
        </div>

        <div v-if="urlSection === 'gotovyj-biznes'" class="edit-card-block edit-card-block_mb-md">
          <div class="edit-card-block__title edit-card-block__title_pt-sm edit-card-block__title_required">Форма собственности</div>
          <div class="edit-card-block__content">
            <div class="ui-radio-tabs">
              <div class="ui-radio-tabs__item">
                <input
                    class="ui-radio-tabs__input"
                    type="radio"
                    id="individual"
                    v-model="selectedType"
                    value="Физ.лицо"
                />
                <label class="ui-radio-tabs__span ui-radio-tabs__span_first" for="individual">Физ.лицо</label>
              </div>
              <div class="ui-radio-tabs__item">
                <input
                    class="ui-radio-tabs__input"
                    type="radio"
                    id="legal"
                    v-model="selectedType"
                    value='Юр.лицо'
                />
                <label class="ui-radio-tabs__span ui-radio-tabs__span_first" for="legal">Юр.лицо</label>
              </div>
            </div>
          </div>
        </div>

        <div v-if="urlSection !== 'franshizy'" class="edit-card-block edit-card-block_mb-md">
          <div class="edit-card-block__title edit-card-block__title_pt-sm edit-card-block__title_required">Местоположение</div>
          <div class="dropdown-select dropdown-select__category">
            <button class="dropdown__button" @click="toggleDropdownCity" type="button">
              {{selectedCity ? selectedCity.city : 'Выберете город'}}
            </button>
            <ul v-show="isDropdownOpenCity" class="dropdown__list">
              <li @click="selectCity(city)" v-for="city in cities" class="dropdown__list-item">{{city.city}}</li>
            </ul>
          </div>
        </div>

      </div>
    </div>

    <div class="edit-card-actions">
      <button class="btn__primary btn-base edit-card-actions__btn-publish" >Опубликовать объявление</button>
    </div>
  </form>
  </div>
</template>

<script setup>
import AuthUserNew from "~/components /auth/auth-user-new.vue";
import axios from "axios";
import {useImageUpload} from "~/ composables/useImageUpload.ts";

const route = useRoute()
const urlSection = route.params.section

const data = {
  name: null,
  description: null,
  price: null,
  selectedType: 'Физ.лицо',
  selectedCity: null,
  selectCategory: null,
  selectSubCategory: null,
  investment_sum_min: null,
  investment_sum_max: null,
  investment_size: null
}

//Forma
const createAdv = async (data) => {
  let section_id = ''

  for (let i = 0; i < section.length; i++) {
    let sections = section[i]
    if (sections.urlName === urlSection){
      section_id = sections.id
    }
  }

  const formNew = new FormData()

  const formData = {
    name: data.name,
    description: data.description,
    price: data.price,
    type: data.selectedType,
    city_id:  data.selectedCity?.id,
    category_id: data.selectCategory?.id,
    sub_category_id: data.selectSubCategory?.id,
    section_id: section_id,
    investment_sum_min: data.investment_sum_min,
    investment_sum_max: data.investment_sum_max,
    investment_size: data.investment_size
  }

  formNew.append('ad', JSON.stringify(formData))

  for (let i = 0; i < imageFile.value.length; i++) {
    formNew.append('images[]', imageFile.value[i])
  }

   await axios.post('/api/adv/create', formNew, {
    headers: {
      'Content-Type':'multipart/form-data'
    }
  })
}

//выбрать город
const selectedCity = ref(null)
const isDropdownOpenCity = ref(false)
const selectCity = (city) => {
  selectedCity.value = city
  data.selectedCity = city
  isDropdownOpenCity.value = false
}
const toggleDropdownCity = () => {
  isDropdownOpenCity.value =!isDropdownOpenCity.value
}
const cities = await axios.get('/api/cities').then(
    res => res.data
)

//собственности
const selectedType = ref('Физ.лицо')
watch(
    selectedType, (newValue) => {
      selectedType.value = newValue
      data.selectedType = newValue
    }
)


const { imageFile, imageUrl, handleImageSelected } = useImageUpload()
const deleteImage = (index) => {
  imageUrl.value.splice(index, 1)
  imageFile.value.splice(index, 1)
}


const isDropdownOpen = ref(false)
const isDropdownOpenSub = ref(false)
const selectedCategory = ref(null)

const selectSubCategory = ref(null)
const selectedSubCategory = ref(null)

const SubCategory = (category) => {
  selectedSubCategory.value = category
  data.selectSubCategory = category
}
const toggleDropdownSub = () => {
  isDropdownOpenSub.value =!isDropdownOpenSub.value
}
const toggleDropdown = () => {
  isDropdownOpen.value =!isDropdownOpen.value
}

const selectCategory = (category) => {
  if(category.subcategory.length > 0){
    selectSubCategory.value = category.subcategory
  }else {
    selectSubCategory.value = null
  }
  selectedCategory.value = category
  data.selectCategory = category
  isDropdownOpen.value =!isDropdownOpen.value
}



const section = await axios.get('api/section').then(res => {
  return res.data;
})

 const categories = await axios.get('api/categories').then(
      res => {
        return res.data;
      }
 )



</script>

<style scoped>

.button_btt{
  position: relative;
  bottom: 40px;
  left: 180px;
  color: #ff0000;
}
.fff{
  display: flex;
  margin: 10px;
  flex-wrap: wrap;
}

.upload-files__previews{
  display: flex;
}

.image_Url{
  max-width: 25%;
  display: flex;
  margin: 10px;

}
.img_btn{
  margin: 6px;
  border: 2px solid #0046f6
}
.dropdown__list{
  display: block;
}
.dropdown-select__subcategory{
  display: block;
}

.section{
  border: 1px solid red;
  padding: 20px;
  margin: 20px;
  max-width: 70%;
}


</style>