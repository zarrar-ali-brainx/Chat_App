<script setup>

import {EllipsisVerticalIcon, MagnifyingGlassIcon, UserIcon} from "@heroicons/vue/24/solid";
import {computed, onMounted, ref, toRefs} from "vue";
import {useThreadItemStore} from "@/stores/GlobalStore";
const threadItemStore = useThreadItemStore();
import {useConversationStore} from "@/stores/conversation";
import {storeToRefs} from "pinia";
import {useUserStore} from "@/stores/userStore";
const userStore = useUserStore();
const conversationStore = useConversationStore();
const conversations = ref([]);
onMounted(() => {
  conversationStore.fetchConversations();
});
onMounted(() => {
  });
const { activeConversationData } = storeToRefs(conversationStore);
const { activeThreadItem } = storeToRefs(threadItemStore);


const getActiveUserName = computed(() => {
  if (activeConversationData.value) {
    const userOne = activeConversationData.value.user_one;
    const userTwo = activeConversationData.value.user_two;
    const currentUserId = userStore.authUser.id;

    if (userOne && userOne.id !== currentUserId) {
      return userOne.name || 'Unknown User';
    } else if (userTwo && userTwo.id !== currentUserId) {
      return userTwo.name || 'Unknown User';
    } else {
      return 'Unknown User';
    }
  } else if (activeThreadItem.value) {
    const currentUserId = userStore.authUser.id;
    return activeThreadItem.value.user_id === currentUserId
        ? activeThreadItem.value.name
        : 'Unknown User';
  } else {
    return '';
  }
});
</script>

<template>
  <div class="thread-header">
    <UserIcon class="user-icon text-white "/>
    <div   class="thread-title">{{  getActiveUserName }}</div>
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
.dropdown{
  display: inline-block;
  position: relative;
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