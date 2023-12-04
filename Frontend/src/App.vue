<script setup>

import ThreadListingContainer from "@/components/ThreadListingContainer.vue";
import ThreadDisplayContainer from "@/components/ThreadDisplayContainer.vue";
import ThreadAppView from "@/components/ThreadAppView.vue";
import Login from "@/components/Login.vue";

import { ref, onMounted } from 'vue';

const accessToken = ref(false);

onMounted(() => {
  checkAccessToken();
});

const checkAccessToken = () => {
  const apiToken = localStorage.getItem('api_token');

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
