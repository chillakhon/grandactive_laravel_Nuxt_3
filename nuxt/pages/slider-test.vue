<template>
  <div class="container">
    <div class="slider_my">
      <div class="swiper-container" id="swiper-container">
        <img src="/img/1.png" alt="">
        <img src="/img/2.png" alt="">
        <img src="/img/Снимок%20экрана%202023-02-26%20в%2001.59.31.png" alt="">
        <img src="/img/Снимок%20экрана%202023-02-22%20в%2002.27.43.png" alt="">
      </div>
    </div>
    <button id="next_button" class="btn btn-success next_button" type="button">next</button>
    <button id="perv_button" class="btn btn-danger perv_button" type="button">next</button>
  </div>
</template>

<script setup>
onMounted(() => {



  document.querySelector('.next_button').addEventListener('click',()=>{
    const swiper = document.getElementById('swiper-container')
  })

  let current = 0
  const swiper = document.getElementById('swiper-container')
  document.addEventListener('click', (e) =>{

    if (e.target.id === 'next_button') {
      current += 500
      if (current == 2000){
        current = 0
      }
      swiper.style.right = current + "px"
    }
    if (e.target.id === 'perv_button') {
      if (current == 0){
        current = 2000
      }
      current -= 500
      swiper.style.right =  current + "px"

    }
  })
})

</script>

<style scoped>

.container{
  border: 3px solid greenyellow;
}

.slider_my{
  width: 531px;
  height: 332px;
  margin: 30px auto;
  border: 10px solid #ccc;
  overflow: hidden;
}

.swiper-container {
  width: 2000px;
  height: 322px;
  background-color: #B01F7E;
  display: flex;
  position: relative;
}
.swiper-container img {
  width: 500px;
  height: 332px;
}

.next_button{
  position: absolute;
  top: 50%;
  left: 70%;

}
.perv_button{
  position: absolute;
  top: 50%;
  left: 25%;
}
</style>