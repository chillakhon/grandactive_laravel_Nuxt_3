<template>
  <div>
    <div class="dropdown">
      <button class=" dropdown_btn  dropdown-toggle" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">
        <font-awesome-icon :icon="['fas', 'bars']" />
      </button>
      <ul  class="dropdown-menu" aria-labelledby="dropdownMenu2">
        <li  class="dropdown-item title" >Разделы сайта</li>
        <hr />
        <li v-for="section in useAppStore().sections" ><nuxt-link class="dropdown-item"  :to="`${section.urlName}`" >{{section.name}}</nuxt-link></li>
        <div class="header-bottom__btn-create-card">
          <nuxt-link to="/adv" class="btn-create-card ">Подать объявление</nuxt-link>
        </div>
      </ul>
    </div>
  </div>
</template>

<script setup>
import {useAppStore} from "~/store/index.ts";

</script>

<style  scoped>

@media only screen and (max-width:1000px) {
  .dropdown[data-v-8c13ae91]{
    display: block;
  }
}
.dropdown{
  display: none;
}

.dropdown-menu{
  padding-left: 10px;
  padding-right: 10px;
}
.title{
  font-size: 20px;
  font-weight: 600;
}

.header-bottom__btn-create-card{
  margin-top:  20px;
  margin-bottom: 20px;
  display: flex;
  justify-content: center;
}
</style>