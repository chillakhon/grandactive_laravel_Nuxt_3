<template>
  <div class="catalog-wrapper-Ad">

    <div class="catalog">

      <div class="catalog-section">
        <ul  class="">
          <li class="section-active ">
            <nuxt-link  :to="`/${useAppStore().filter_params.section?.urlName}`">
              {{useAppStore().filter_params.section?.name}}
              <font-awesome-icon :icon="  ['fas', 'chevron-down'] "/>
            </nuxt-link>

            <ul id="category_id"  class="categories " @click.stop="toggleCategory(category,$event)"
                v-for="(category, index) in useAppStore().categories"
                :key="index">
              <nuxt-link :to="`/${useAppStore().filter_params.section?.urlName}/${category.url_name}`">
                <li :class="{'rubricator_active' : route.params.category == category.url_name }">
                  <font-awesome-icon :icon="category.subcategory.length > 0 ? ['fas', !category.isOpen ? 'chevron-right' : 'chevron-down'] : '' " />
                     {{ category.name }}
                </li>
              </nuxt-link>


              <ul v-show="category.isOpen" id="subcategory_id" class="subcategories" v-for="subcategory in category.subcategory">
                <nuxt-link :to="`/${useAppStore().filter_params.section?.urlName}/${category.url_name}/${subcategory.url_name}`">
                  <li :class="{'rubricator_active' : route.params.subCategory == subcategory.url_name }">
                    {{ subcategory.subcategory_name }}
                  </li>
                </nuxt-link>
              </ul>


            </ul>
          </li>
        </ul>

      </div>

      <div class="catalog-cards-ad">
        <CatalogCards/>
      </div>

    </div>
  </div>
</template>

<script setup>
import {useAppStore} from "~/store/index.ts";
import CatalogCards from "~/components /CatalogCards.vue";
import adsMiddleware from "~/middleware/adsMiddleware.js";
adsMiddleware()


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

<style  scoped>


@media only screen and (max-width:1000px) {
  .section-active[data-v-f0578c2d]{
    display: none;
  }
  .catalog-section{
    display: none
  }
}


li {
  margin: 3px;
  padding-bottom: 1.5px;
  font-size: 16px;
  color: #3a3a3a;
  padding-right: 20px;
}

li :hover {
  color: #6c96ff;
}

ul {
  line-height: 24px;
  color: #484848;
}

.section-active{
  color: #101010;
}
.catalog{
  display: flex;
}

.catalog-section{
  max-width: 25%;
  padding: 0.5em;

}
.catalog-cards-ad{
  width: 1100px;
  padding: 0.5em;
}

.rubricator_active {
  color: #B01F7E;
  font-weight: 500;
}

</style>