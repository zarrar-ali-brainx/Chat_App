<script setup>

import ThreadListingContainer from "@/components/ThreadListingContainer.vue";
import ThreadDisplayContainer from "@/components/ThreadDisplayContainer.vue";
</script>

<template>
  <div class=" custom-container">
    <div class="row custom-row1 ">
      <div class="app-view-container">
        <ThreadListingContainer />

        <ThreadDisplayContainer />
      </div>
    </div>
    <div class="row custom-row2 border"></div>
  </div>

</template>


<style scoped>


.custom-container{
  width: 100%;
  overflow: hidden;
  margin: 0 auto;

}
.custom-row1{

  height: 127px;
  background-color: #00a884;
}
.custom-row2{
  background-color: #dadada;
  height: 845px;
  overflow: hidden;
}
.app-view-container{
  display: flex;
  position: relative;
  //margin-top: 1.5%;
  margin-left: 5%;
  margin-right: 5%;
  flex-wrap: nowrap;
  overflow: hidden;
  box-sizing: border-box;

}
@media screen and (max-width: 1669px) {
  .app-view-container {

    margin-right: 2%;
    margin-left: 3.5%;
  }
}
@media screen and (max-width: 1597px) {
  .app-view-container {
    margin-left: 5%;
    margin-right: 1%;
    margin-top: 0;
  }
}
@media screen and (max-width: 1440px) {
  .app-view-container {

    margin-left: 2.5%;

  }
}



.app-view-container > div {
  background-color: #f1f1f1;

  font-size: 30px;
}
























</style>

