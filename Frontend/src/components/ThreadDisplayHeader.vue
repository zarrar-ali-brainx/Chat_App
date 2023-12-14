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
onMounted(() => {
  conversationStore.fetchConversations();
});
onMounted(() => {
  });
const { conversations, activeConversationData } = storeToRefs(conversationStore);
const { activeThreadItem } = storeToRefs(threadItemStore);

const getGroupMembersNames = computed(() => {
  const currentUserId = userStore.authUser.id;

  if (activeConversationData.value?.type === 0) {
    const activeConversation = conversations.value.find(
        (conv) => conv.id === activeConversationData.value.id
    );

    if (activeConversation && activeConversation.users) {
      const groupMembers = activeConversation.users.filter(
          (user) => user.id !== currentUserId
      );

      return groupMembers;
    }
  }

  return [];
});

const getActiveUserName = computed(() => {
  if (activeConversationData.value) {
    const conversation = activeConversationData.value;
    const currentUserId = userStore.authUser.id;

    if (conversation.type === 0) {
      return conversation.group_name || 'Unknown Group';
    } else {
      const userOne = conversation.user_one;
      const userTwo = conversation.user_two;

      if (userOne && userOne.id !== currentUserId) {
        return userOne.name || 'Unknown User';
      } else if (userTwo && userTwo.id !== currentUserId) {
        return userTwo.name || 'Unknown User';
      } else {
        return 'Unknown User';
      }
    }
  }
    else if (activeThreadItem.value) {
    return activeThreadItem.value.name
  } else {
    return '';
  }
}
  );
</script>

<template>
  <div class="thread-header">
    <UserIcon class="user-icon text-white "/>
    <span   class="thread-title">{{  getActiveUserName }}<br>
      <span v-for="(member,index) in getGroupMembersNames" :key="member.id" class="thread-participants">
        {{member.name }}
          <span v-if="index < getGroupMembersNames.length - 1">, </span>

    </span>

    </span>

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
.thread-participants{
  font-weight: lighter;
  font-size: small;

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
  margin-top: 5px;
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