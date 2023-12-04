<script setup>

import {MagnifyingGlassIcon} from "@heroicons/vue/24/solid";
</script>

<template>
  <div class="Searchbar">
            <span class="Searchbar">
<!--              <MagnifyingGlassIcon style="width: 21px;height: 35px; margin-top: 6px; margin-left: 20px; margin-right: -2px; cursor: pointer; background-color: #f0f2f5;-->
<!--border-top-left-radius: 8px; border-bottom-left-radius: 8px; padding-left: 8px"/>-->
              <input type="text"  placeholder="Search or start a new Chat">
            </span>
  </div>
</template>

<style scoped>
.Searchbar{
  height: 49px;
  width: 500px;
  background-color: #ffffff;




}
.Searchbar > input{
  width: 420px;
  height: 35px;
  font-size: small;
  background-color: #f0f2f5;

  padding-left: 22px;
  margin-left: 25px;
  border: none;
  border-radius: 8px;



}
.Searchbar > input:focus{
  outline: none;
}

</style>