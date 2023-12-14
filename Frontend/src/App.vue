<script setup>

import ThreadListingContainer from "@/components/ThreadListingContainer.vue";
import ThreadDisplayContainer from "@/components/ThreadDisplayContainer.vue";
import ThreadAppView from "@/components/ThreadAppView.vue";
import Login from "@/components/Login.vue";

import { ref, onMounted } from 'vue';
import axios from "axios";
import {useUserStore} from "@/stores/userStore";
const accessToken = ref(false);
const userStore = useUserStore();
onMounted(() => {
  checkAccessToken();
  check();
});

const checkAccessToken = () => {
  const apiToken = localStorage.getItem('api_token');

};
const  check = async() => {
  const accessToken = localStorage.getItem('api_token');
if(accessToken) {
  await axios.get(`http://127.0.0.1:8000/api/user`, {
        headers: {
          Authorization: `Bearer ${accessToken}`,
        }
      }
  ).then(response => {
    userStore.setAuthUser(response.data);

  }).catch(error => {
    console.log(error)
  })
}else {

}
};

</script>


<template>
  <router-view></router-view>


</template>

<style scoped>

.custom{
  margin: 0;
}

</style>
