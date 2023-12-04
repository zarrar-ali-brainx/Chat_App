<script setup>

import {EllipsisVerticalIcon, MagnifyingGlassIcon, UserIcon} from "@heroicons/vue/24/solid";
import {threadItems} from "@/threadItems";
import {computed, onMounted, ref, toRefs} from "vue";
import {useThreadItemStore} from "@/stores/GlobalStore";
const threadItemStore = useThreadItemStore();
const {activeThreadItem} = toRefs(threadItemStore);
import {useConversationStore} from "@/stores/conversation";
const conversationStore = useConversationStore();
const conversations = ref([]);
onMounted(() => {
  conversationStore.fetchConversations();
});
onMounted(() => {
  console.log('Active Conversation Data:', activeConversationData);
});
const { activeConversationData } = useConversationStore();

console.log('Active Conversation Data:', activeConversationData);

// Function to get the active user's name
const getActiveUserName = () => {
  if (!activeConversationData) {
    console.log('Active Conversation Data is null. Returning Unknown User.');
    return 'Unknown User';
  }

  // Check if user_one and user_two are present
  const userOne = activeConversationData.value.user_one;
  const userTwo = activeConversationData.value.user_two;

  if (userOne) {
    console.log('User One Name:', userOne.name);
    return userOne.name || 'Unknown User';
  } else if (userTwo) {
    console.log('User Two Name:', userTwo.name);
    return userTwo.name || 'Unknown User';
  } else {
    console.log('Both user_one and user_two are missing. Returning Unknown User.');
    return 'Unknown User';
  }
};
</script>

<template>
  <div class="thread-header">
    <UserIcon class="user-icon text-white "/>
    <div   class="thread-title">{{  getActiveUserName(activeConversationData) }}</div>
    <MagnifyingGlassIcon class="magnifying-glass"/>
    <EllipsisVerticalIcon class="Ellipses-vertical" />
  </div>
</template>

<style scoped>
.thread-header{
  display: flex;
  position: relative;
  flex-direction: row;
  background-color: #f0f2f5;
  height: 59px;
  max-width: 100%;
  box-sizing: border-box;
}

.magnifying-glass{
  height: 29px;
  width: 25px;
  margin-top: 15px;
  color: grey;
  margin-right: 10px;
  margin-left: 10px;
  cursor: pointer;
}

.Ellipses-vertical{
  height: 28px;
  width: 30px;
  margin-top: 16px;
  margin-left: 15px;
  color: grey;
  cursor: pointer;
}

.thread-title{
  width: 85%;
  font-size: large;
  font-weight: bold;
  margin-top: 10px;
  box-sizing: border-box;
}

.user-icon{
  display: flex;
  flex-direction: column;
  position: relative;
  height: 40px;
  width: 40px;
  border-radius: 50%;
  border: 1px black;
  margin-left: 15px;
  margin-top: 10px;
  background-color: lightgray;
  margin-right: 10px;
  cursor: pointer;
  box-sizing: border-box;

}

</style>