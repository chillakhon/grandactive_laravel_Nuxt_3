<template>
  <!-- Button trigger modal -->

  <div class="d-grid gap-2">
    <button type="button" class=" btn btn-outline-primary btn-category-modal" data-bs-toggle="modal" data-bs-target="#categoryModal">
      Категории
    </button>
  </div>


  <div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Категории</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <ul class="list-group">
            <li class="list-group-item">
              <button  data-bs-dismiss="modal" aria-label="Close">
              <nuxt-link :to="`/${useAppStore().filter_params.section?.urlName}`">
                {{ useAppStore().filter_params.section?.name }}
                <font-awesome-icon :icon="  ['fas', 'chevron-down'] "/>
              </nuxt-link>
                </button>
              <ul id="category_id" class="categories " @click.stop="toggleCategory(category,$event)"
                  v-for="(category, index) in useAppStore().categories"
                  :key="index">
                <li>
                  <font-awesome-icon
                      :icon="category.subcategory.length > 0 ? ['fas', !category.isOpen ? 'chevron-right' : 'chevron-down'] : '' "/>
                  <button  data-bs-dismiss="modal" aria-label="Close">
                  <nuxt-link
                      :to="`/${useAppStore().filter_params.section?.urlName}/${category.url_name}`"
                      :class="{'rubricator_active' : route.params.category == category.url_name }"
                      class="category_name"
                  >
                    {{ category.name }}
                  </nuxt-link>
                  </button>
                </li>

                <ul v-show="category.isOpen" id="subcategory_id" class="subcategories"
                    v-for="subcategory in category.subcategory">
                  <button  data-bs-dismiss="modal" aria-label="Close">
                  <nuxt-link :to="`/${useAppStore().filter_params.section?.urlName}/${category.url_name}/${subcategory.url_name}`">
                    <li :class="{'rubricator_active' : route.params.subCategory == subcategory.url_name }">
                      {{ subcategory.subcategory_name }}
                    </li>
                  </nuxt-link>
                    </button>
                </ul>
              </ul>
            </li>
          </ul>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
        </div>
      </div>
    </div>
  </div>



</template>

<script setup>

import {useAppStore} from "~/store/index.ts";
import CatalogCards from "~/components /CatalogCards.vue";
import adsMiddleware from "~/middleware/adsMiddleware.js";
adsMiddleware()


const tabindex = () => {

}

const route = useRoute();
const activeCategory = ref(null);

watch(
    () => route.params.category,
    (newCategory) => {
      activeCategory.value = newCategory;
    }
);

const isActiveCategory = (category) => {
  return activeCategory.value === category.url_name;
};


const toggleCategory = (category, event) => {
  const isSubcategoryClicked = event.target.closest('.subcategories');
  if (!isSubcategoryClicked) {
    category.isOpen =!category.isOpen
  }
}

</script>

<style scoped>
.btn-category-modal{
  padding: 1% 5%;
  margin-top: 2%;
  margin-left: 1%;
}


li {
  margin: 3px;
  padding-bottom: 1.5px;
  font-size: 16px;
  color: #29222c;
  padding-right: 20px;
}



ul {
  line-height: 24px;
  color: #484848;
}

.category_name{
  font-size: 16px;
  color: #29222c;
  padding-left: 3px;
}

.rubricator_active {
  color: #B01F7E;
  font-weight: 500;
}

</style>