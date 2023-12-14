<script setup>

import ThreadListingHeader from "@/components/ThreadListingHeader.vue";
import Searchbar from "@/components/Searchbar.vue";
import ThreadListing from "@/components/ThreadListing.vue";
import {ref, provide, watch} from "vue";
import {useUserStore} from "@/stores/userStore";

const userStore = useUserStore();
const emit = defineEmits(['isHide']);
const {create, back,search,undo} = defineProps(['create','back','search','undo']);
const isShow = ref(false)

const isHide = ref(false)
const isGroupMode = ref(false);
import {provideSharedState} from "@/sharedState";
provideSharedState();
const hideSearchBar = () => {
  isHide.value = !isHide.value;
  isGroupMode.value = !isGroupMode.value;
  userStore.toggleUserList();
};
const selectedResults = ref(null);

const showResults = (searchResults) =>{
  isShow.value = true;
  selectedResults.value = searchResults;

}
const showConvs = () =>{
  isShow.value = false;

}

const groupMembers = ref([]);
provide('groupMembers',groupMembers);


</script>

<template>
  <div class="thread-listing-container">
    <ThreadListingHeader  @create="hideSearchBar"  />
    <Searchbar @undo="showConvs" @search = showResults @create="hideSearchBar" :hide="isHide"/>

    <ThreadListing :show="isShow" :searchResult="selectedResults" :hide="isGroupMode"/>
  </div>
</template>

<style scoped>
.thread-listing-container{
  margin-top: 2%;
  display: flex;
  flex-direction: column;
  width: 26.52%;
  position: relative;
  flex-wrap: nowrap;



}
</style>