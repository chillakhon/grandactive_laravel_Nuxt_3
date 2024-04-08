<template>

<div class="homepage" >
<Sections/>
<CategoryInHome/>
  <PopularAds/>
  <NewAds/>
</div>

</template>

<script setup>
import Sections from "~/components /UI/homepage/Sections.vue";
import CategoryInHome from "~/components /UI/homepage/CategoryInHome.vue";
import PopularAds from "~/components /UI/homepage/PopularAds.vue";

import adForSwiperPopular from "~/middleware/adForSwiperPopular.js";
import NewAds from "~/components /UI/homepage/NewAds.vue";
adForSwiperPopular();
</script>

<style  scoped>
.homepage{
  margin:  -5% 0 0 0;
  border: orange solid 3px;
}
</style>