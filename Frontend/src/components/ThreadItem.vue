<script setup>
import { useThreadItemStore } from "@/stores/GlobalStore";
import {UserIcon, UsersIcon} from "@heroicons/vue/24/solid";
import {useUserStore} from "@/stores/userStore";
import {useConversationStore} from "@/stores/conversation";
import {defineProps, onMounted, ref, watch} from "vue";


const userStore = useUserStore();
const threadItemStore = useThreadItemStore();
const conversationStore = useConversationStore();
const {activeConversationData} = conversationStore;

const setActiveConversation = (conversation) => {
  conversationStore.setActiveConversation(conversation.id);
  // threadItemStore.setActiveConv(conversation.id);
  threadItemStore.fetchMessages(conversation.id);
};

const conversations = ref([]);
const { user } = defineProps(['user']);

onMounted(() => {
  conversationStore.fetchConversations();
});

watch(() => conversationStore.conversations, (newConversations) => {
  conversations.value = newConversations;
});
const getOtherUserName = (conversation) => {
  const currentUserId = userStore.authUser.id;
  if (conversation.type === 0) {
    // Group conversation
    return conversation.group_name;
  }
  else if (currentUserId === conversation.user_one.id) {
    return conversation.user_two.name;
  } else if (currentUserId === conversation.user_two.id) {
    return conversation.user_one.name;
  } else {
    return "Unknown User";
  }
};



</script>

<template>
  <div class="thread-items" >
    <!--  <div  v-for="threadItem in threadItems"-->
    <!--        @click="(toggleActive )" class="thread-item ">-->
    <div  v-for="conversation in conversations" :key="conversation.id"  class="thread-item " @click="setActiveConversation(conversation)">
      <div v-if="!conversation.group_name" class="ti-dp"><UserIcon class="user-icon text-white" style="margin-right: 10px; background-color: deepskyblue"/></div>
      <div v-else class="ti-dp"><UsersIcon class="user-icon text-white" style="margin-right: 10px; background-color: lightslategray"/></div>
      <div class="ti-info">
        <span  class="ti-title font-small" >{{ getOtherUserName(conversation) }}</span>
        <span class="ti-short-msg"></span>
      </div>
    </div>
  </div>
</template>

<style scoped>
.thread-items{
  display: flex;
  flex-direction: column;
  position: relative;
  overflow: auto;
  box-sizing: border-box;
  width: 485px;
}

.thread-item{
  display: flex;
  flex-direction: row;
  position: relative;
  overflow: auto;
  box-sizing: border-box;
  cursor: pointer;
  width: 100%;

}
.thread-item:hover{
  cursor: pointer;
  background-color: #f1f1f1;
}
.ti-dp{
  display: flex;
  flex-direction: column;
  width: 15%;
  position: relative;
  box-sizing: border-box;
}
.ti-info{
  position: relative;

  width: 75%;
  height: 60px;
  border-bottom: 3px solid #e9edef ;
  box-sizing: border-box;


}
.ti-title{
  font-size: large;

}
.ti-short-msg{
  font-size: medium;
}

.user-icon{
  height: 40px;
  width: 40px;
  overflow: auto;
  border-radius: 50%;
  border: 1px black;
  margin-left: 15px;
  margin-top: 10px;
  background-color: lightgray;
  margin-right: 165px;
  cursor: pointer;
  max-width: 100%;
  position: relative;

}
</style>