<script setup>
import {UserIcon} from "@heroicons/vue/24/solid";
import {  defineEmits } from 'vue';
import { defineProps } from 'vue';
import {useUserStore} from "@/stores/userStore";
const userStore = useUserStore();
import {useThreadItemStore} from "@/stores/GlobalStore";
const threadItemStore = useThreadItemStore();
const { user } = defineProps(['user']);
import {useConversationStore} from "@/stores/conversation";
import {storeToRefs} from "pinia";
import UserSearch from "@/components/Group.vue";
const conversationStore = useConversationStore();
const {activeThreadItem} = storeToRefs(conversationStore);

const setActiveThreadItem = (user) => {

  threadItemStore.setActiveThreadItem(user);

  userStore.toggleUserList();
  let userFind = userStore.userList.find(el=>el.id == user.id);
  if (userFind?.conversation) {
    const conv_id = userFind.conversation.id
    conversationStore.setActiveConv(conv_id);
    conversationStore.setActiveConversation(conv_id);
    threadItemStore.fetchMessages(conv_id);


  }
  else {
    conversationStore.activeConversationData =null;
  }

};

</script>

<template>

      <!--  <div  v-for="threadItem in threadItems"-->
      <!--        @click="(toggleActive )" class="thread-item ">-->
  <div  v-for="user in userStore.getUserList"
        :key="user.id"
          @click="setActiveThreadItem(user)"
        >
      <div class="thread-item ">
        <div class="ti-dp"><UserIcon class="user-icon text-white" style="margin-right: 10px;"/></div>
        <div class="ti-info">
          <span  class="ti-title font-small">    {{ user.name }} </span>
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
  width: 100%;
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

  width: 85%;
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
