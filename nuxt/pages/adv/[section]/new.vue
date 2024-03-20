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
  <form  class="form">
    <div class="edit-card-section">
      <div class="edit-card-section__content">
        <div class="edit-card-block edit-card-block_card-sections">
          <div class="edit-card-block__title">Выберите раздел</div>
          <div class="edit-card-block__content">
            <ul class="card-sections-list">
              <li class="card-sections-list__item" v-for="item in section">
                <div v-if="item.urlName === urlSection" class="card-sections-list__link card-sections-list__link_active">{{item.name}}</div>
                <nuxt-link v-else  class="card-sections-list__link" :to="`/adv/${item.urlName}/new`">{{item.name}}</nuxt-link>
              </li>
            </ul>
          </div>
        </div>

        <div class="edit-card-block edit-card-block_mb-sm">
          <div class="edit-card-block__title edit-card-block__title_pt-sm edit-card-block__title_required">Название</div>
          <div class="edit-card-block__content">
            <input class="ui-input ui-input_w100" placeholder="Введите название" type="text">
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
          <textarea  class="ui-textarea ui-textarea_tinymce ui-textarea_w100" name="Description">
          </textarea>
        </div>

        <div class="edit-card-block edit-card-block_mb-lg">
          <div class="edit-card-block__title edit-card-block__title_pt-sm edit-card-block__title_required">Фотографии</div>
          <div class="edit-card-block__content">
            <div class="edit-card-block__upload-files upload-files">
              <div class="upload-files__previews">
                <label class="upload-files__btn upload-files-btn ">
                  <input
                      class="upload-files__input"
                      multiple=""
                      type="file">
                  <svg class="upload-files-btn__icon" fill="none" height="25" viewBox="0 0 24 25" width="24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6 4.17383C6 2.51697 7.34315 1.17383 9 1.17383H15C16.6569 1.17383 18 2.51697 18 4.17383H6Z"></path>
                    <path clip-rule="evenodd" d="M4 4.17383C1.79086 4.17383 0 5.96469 0 8.17383V19.1738C0 21.383 1.79086 23.1738 4 23.1738H20C22.2091 23.1738 24 21.383 24 19.1738V8.17383C24 5.96469 22.2091 4.17383 20 4.17383H4ZM8 13.1738C8 10.9647 9.79086 9.17383 12 9.17383C14.2091 9.17383 16 10.9647 16 13.1738C16 15.383 14.2091 17.1738 12 17.1738C9.79086 17.1738 8 15.383 8 13.1738ZM12 7.17383C8.68629 7.17383 6 9.86012 6 13.1738C6 16.4875 8.68629 19.1738 12 19.1738C15.3137 19.1738 18 16.4875 18 13.1738C18 9.86012 15.3137 7.17383 12 7.17383Z" fill-rule="evenodd"></path>
                  </svg>
                  <span class="upload-files-btn__text">Добавить</span>
                </label>
              </div>
            </div>
          </div>
        </div>

        <div class="edit-card-block edit-card-block_mb-md">
          <div class="edit-card-block__title edit-card-block__title_pt-sm edit-card-block__title_required">Цена бизнеса</div>
          <div class="edit-card-block__content">
            <div class="ui-input-wrapper ui-input-wrapper_align-center">
              <input min="1" class="ui-input ui-input_sm js-input_digit" type="number">
              <span class="ui-input-wrapper__input-text">руб</span>
            </div>
            </div>



        </div>
        <div class="edit-card-block edit-card-block_mb-md">
          <div class="edit-card-block__title edit-card-block__title_pt-sm edit-card-block__title_required">Форма собственности</div>
          <div class="edit-card-block__content">
            <div class="ui-radio-tabs">
              <div class="ui-radio-tabs__item">
                <input checked="" class="ui-radio-tabs__input" type="radio" value="NaturalPerson" >
                <span class="ui-radio-tabs__span ui-radio-tabs__span_first">Физ. лицо</span>
              </div>
              <div class="ui-radio-tabs__item">
                <input class="ui-radio-tabs__input" type="radio" >
                <span class="ui-radio-tabs__span ui-radio-tabs__span_last ui-radio-tabs__span_next">Юр. лицо</span>
              </div>
            </div>
            <div class="edit-card-block__footer">
              <span class="form-validation-error field-validation-valid" data-valmsg-for="OwnershipType" data-valmsg-replace="true"></span>
            </div>
          </div>
        </div>
        <div class="edit-card-block edit-card-block_mb-md">
          <div class="edit-card-block__title edit-card-block__title_pt-sm edit-card-block__title_required">Доля в бизнесе</div>
          <div class="edit-card-block__content">
            <div class="ui-input-wrapper ui-input-wrapper_align-center">
              <input class="ui-input ui-input_disabled ui-input_xs" readonly="" value="100" type="number" data-val="true" data-val-range="Введите значение от 1 до 100" data-val-range-max="100" data-val-range-min="1" data-val-required="Введите значение от 1 до 100" id="SharePercent" name="SharePercent">
              <span class="ui-input-wrapper__input-text">%</span>
            </div>
            <div class="edit-card-block__footer">
              <span class="form-validation-error field-validation-valid" data-valmsg-for="SharePercent" data-valmsg-replace="true"></span>
            </div>
          </div>
        </div>
        <div class="edit-card-block edit-card-block_mb-md">
          <div class="edit-card-block__title edit-card-block__title_pt-sm">Срок окупаемости</div>
          <div class="edit-card-block__content">
            <div class="edit-card__payback-wrapper ui-input-wrapper ui-input-wrapper_align-center">
              <div class="ui-input-quantity " data-input-quantity-length="3">
                <div class="ui-input-quantity__control ui-input-quantity__control_minus" style="padding: 8px 0 0 7px">+</div>
                <input class="ui-input-quantity__value" min="1" type="number" data-val="true" data-val-range="Превышено допустимое значение поля">
                <div class="ui-input-quantity__control ui-input-quantity__control_plus" style="padding: 8px 0 0 7px">-</div>
              </div>
              <span class="ui-input-wrapper__input-text">в годах</span>
              <div class="edit-card__payback-checkbox ui-checkbox ui-checkbox_ml-lg">
                <input class="ui-checkbox__input" type="checkbox" name="PaybackLessThenYear" value="true">
                <label class="ui-checkbox__label ui-checkbox__label_gray" for="PaybackLessThenYear">Меньше года</label>
              </div>
            </div>
            <div class="edit-card-block__footer">
              <span class="form-validation-error field-validation-valid" data-valmsg-for="Payback" data-valmsg-replace="true"></span>
            </div>
          </div>
        </div>
        <div class="edit-card-block edit-card-block_mb-md">
          <div class="edit-card-block__title edit-card-block__title_pt-sm edit-card-block__title_required">Местоположение</div>
        </div>
      </div>
    </div>

    <div class="edit-card-actions">
      <button class="btn__primary btn-base edit-card-actions__btn-publish" type="submit">Опубликовать объявление</button>
    </div>
  </form>
  </div>
</template>

<script setup>
import AuthUserNew from "~/components /auth/auth-user-new.vue";
import axios from "axios";

const route = useRoute()
const urlSection = route.params.section

const isDropdownOpen = ref(false)
const isDropdownOpenSub = ref(false)
const selectedCategory = ref(null)

const selectSubCategory = ref(null)
const selectedSubCategory = ref(null)

const SubCategory = (category) => {
  selectedSubCategory.value = category
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