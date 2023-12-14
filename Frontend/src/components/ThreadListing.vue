<script setup>

import ThreadItem from "@/components/ThreadItem.vue";
import ContactItem from './ContactItem.vue';
import {useUserStore} from "@/stores/userStore";
const userStore = useUserStore();
import {useThreadItemStore} from "@/stores/GlobalStore";
import {threadItems} from "@/threadItems";
import threadItem from "@/components/ThreadItem.vue";
import {useConversationStore} from "@/stores/conversation";
import {onMounted, ref, watch} from "vue";
import Group from "@/components/Group.vue";
import SearchResultItems from "@/components/SearchResultItems.vue";
const threadItemStore = useThreadItemStore();
const conversationStore = useConversationStore();
const conversations = ref([]);
const {hide,show,searchResult} = defineProps(['hide','show','searchResult']);
const isGroupMode = ref(false);
const switchMode = () => {
  isGroupMode.value = !isGroupMode.value;
};


watch(() => conversationStore.conversations, (newConversations) => {
  conversations.value = newConversations;
});
</script>

<template>
  <div class="tl-listing">


    <div class="thread-items" v-if="userStore.isUserListVisible && !hide && !show" >
      <ContactItem/>
    </div>
    <div class="thread-items" v-else-if="hide && !show">
      <Group  />
    </div>
    <div  class="thread-items" v-else-if="!hide && !userStore.isUserListVisible && !show">
      <ThreadItem  />
    </div>
    <div v-else-if="show && !hide && !userStore.isUserListVisible" class="thread-items">
      <SearchResultItems :result="searchResult"/>
    </div>

  </div>
</template>

<style scoped>
.tl-listing {
  display: flex;
  width: 485px;
  height: 810px;
  background-color: #f0f2f5;
  max-height: 100%;
  position: relative;
  overflow: auto;
}
.thread-items{
  display: flex;
  flex-direction: column;
  position: relative;
  overflow: auto;
  box-sizing: border-box;
  width: 100%;
}


</style>