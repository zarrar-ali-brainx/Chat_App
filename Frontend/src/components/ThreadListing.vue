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
const threadItemStore = useThreadItemStore();
const conversationStore = useConversationStore();
const conversations = ref([]);



watch(() => conversationStore.conversations, (newConversations) => {
  conversations.value = newConversations;
});

</script>

<template>
  <div>
    <div v-if="userStore.isUserListVisible" >
      <ContactItem/>
    </div>
    <div v-else>
      <ThreadItem  />
    </div>
  </div>
</template>

<style scoped>
.tl-listing {
  display: flex;
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