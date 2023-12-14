<script setup>
import {UserIcon, UsersIcon} from "@heroicons/vue/24/solid";
import {  defineEmits } from 'vue';
import { defineProps } from 'vue';
import {useUserStore} from "@/stores/userStore";
const userStore = useUserStore();
import {useThreadItemStore} from "@/stores/GlobalStore";
const threadItemStore = useThreadItemStore();
const { user,result } = defineProps(['user','result']);
import {useConversationStore} from "@/stores/conversation";
import {storeToRefs} from "pinia";
import UserSearch from "@/components/Group.vue";
const conversationStore = useConversationStore();
const {activeThreadItem} = storeToRefs(conversationStore);



const getOneToOneUserName = (item) => {
  const userOne = item.user_one;
  const userTwo = item.user_two;
  const currentUserId = userStore.authUser.id;

  if (userOne && userOne.id !== currentUserId) {
    return userOne.name;
  } else if (userTwo && userTwo.id !== currentUserId) {
    return userTwo.name;
  } else {
    return ''; // Handle the case when no valid user is found
  }
};
const setActiveThreadItem = (user) => {


if(user.type ===0 || user.type===1 ) {
  threadItemStore.setActiveThreadItem(user);


  conversationStore.setActiveConv(user.id);
  conversationStore.setActiveConversation(user.id);
  threadItemStore.fetchMessages(user.id);

}
else{
  threadItemStore.setActiveThreadItem(user);
  conversationStore.activeConversationData = null;

}



};

</script>

<template>

  <!--  <div  v-for="threadItem in threadItems"-->
  <!--        @click="(toggleActive )" class="thread-item ">-->
  <div  v-for="item in result"
        :key="item.id"
        @click="setActiveThreadItem(item)"
  >
    <div class="thread-item ">
      <div v-if="!item.group_name" class="ti-dp"><UserIcon class="user-icon text-white" style="margin-right: 10px; background-color: deepskyblue"/></div>
      <div v-else class="ti-dp"><UsersIcon class="user-icon text-white" style="margin-right: 10px; background-color: lightslategray"/></div>

      <div class="ti-info">
        <span  class="ti-title font-small">            {{
            item.type === 0
                ? item.group_name
                : item.type === 1
                    ? getOneToOneUserName(item)
                    : item.name || ''
          }}
</span>
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
