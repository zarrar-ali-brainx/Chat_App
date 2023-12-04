<script setup>

import ThreadListingHeader from "@/components/ThreadListingHeader.vue";
import Searchbar from "@/components/Searchbar.vue";
import ThreadListing from "@/components/ThreadListing.vue";

</script>

<template>
  <div class="thread-listing-container">
    <ThreadListingHeader />
    <Searchbar />
    <ThreadListing />
  </div>
</template>

<style scoped>
.thread-listing-container{
  margin-top: 2%;
  display: flex;
  flex-direction: column;
  width: 30%;
  position: relative;



}
</style>