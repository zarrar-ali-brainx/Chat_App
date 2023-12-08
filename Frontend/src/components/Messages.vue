
<script setup>
import { ref, onMounted, toRefs } from 'vue';
import { useThreadItemStore } from '@/stores/GlobalStore';
import {useConversationStore} from "@/stores/conversation";
import axios from 'axios';
import {storeToRefs} from "pinia";
const conversationStore = useConversationStore();
const threadItemStore = useThreadItemStore();

const {activeConversationData} = conversationStore;
const {  activeConv } = storeToRefs(threadItemStore);

const messageInput = ref('');



</script>

<template>
  <div ref="chatContainer" class="threadMsg">


    <div v-for="item in activeConv" :key="item.id" class="msg-send">
      {{ item.content }}
    </div>
  </div>
</template>

<style scoped>


.messages{
  display: flex;
  flex-direction: column;
  width: 1000px;
  box-sizing: border-box;
}
.threadMsg {

  display: flex;
  flex-direction: column;
  gap: 10px;
  padding: 10px;
  width: 1100px;
  position: relative;
  overflow-y: auto;


}

.msg-received {
  background-color: #fff;
  color: #000;
  padding: 15px;
  border-radius: 8px;
  margin-left: 10px;
  margin-bottom: 8px;
  align-self: flex-start;
  max-width: 500px;
  word-wrap: break-word;
  font-size: medium;
  width: fit-content;
}
.msg-send{
  background-color: #dcf8c6;
  color: #000;
  padding: 15px;
  border-radius: 8px;
  margin-bottom: 8px;
  margin-right: 10px;
  align-self: flex-end;
  max-width: 500px;
  word-wrap: break-word;
  width: fit-content;
  font-size: medium;
}



</style>