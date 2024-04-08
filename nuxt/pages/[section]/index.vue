<template>
  <div class="container-ad">
    <div class="sections">
      <Sections :urlSectionCurrent = 'urlSection'/>
    </div>
  </div>
</template>

<script setup>
import Sections from "~/components /Sections.vue";

const route = useRoute()
const urlSection = route.params.section


</script>

<style  scoped>
.container-ad {
  margin: -5% 2% 0 2%;
  border: 1px solid red;
}
.sections{

}

</style>