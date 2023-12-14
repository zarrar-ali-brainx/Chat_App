
<script setup>
import {TrashIcon} from "@heroicons/vue/24/solid";
import {ref, onMounted, toRefs, watchEffect, computed} from 'vue';
import { useThreadItemStore } from '@/stores/GlobalStore';
import {useConversationStore} from "@/stores/conversation";
import {useUserStore} from "@/stores/userStore";
import axios from 'axios';
import {storeToRefs} from "pinia";
const conversationStore = useConversationStore();
const threadItemStore = useThreadItemStore();
const userStore = useUserStore();
const {activeConversationData} = storeToRefs(conversationStore);
const {  activeConv } = storeToRefs(threadItemStore);
const emit = defineEmits(['fetch'])
const messageInput = ref('');
const {fetchMessages} = storeToRefs(threadItemStore)
const formatTimestamp = (timestamp) => {
  const date = new Date(timestamp);
  const hours = date.getHours() % 12 || 12; // Convert 24-hour to 12-hour format
  const minutes = String(date.getMinutes()).padStart(2, '0');
  const period = date.getHours() < 12 ? 'am' : 'pm';

  return `${hours}:${minutes}${period}`;
};

const deleteMessage = async (messageId) => {
  try {
    const accessToken = localStorage.getItem('api_token');
    await axios.delete(`http://127.0.0.1:8000/api/messages/${messageId}`, {
      headers: {
        Authorization: `Bearer ${accessToken}`,
      },
    }).then(response =>{
      threadItemStore.fetchMessages(activeConversationData.value.id)
      console.log(response.data)
    }).catch(error =>{
      console.log(error);
    });


  } catch (error) {
    console.error('Error deleting message:', error);
  }
};
</script>

<template>
  <div ref="chatContainer" class="threadMsg">


    <div v-for="item in activeConv" :key="item.id" :class="{ 'msg-send': item.sender_id === userStore.authUser.id, 'msg-received': item.sender_id !== userStore.authUser.id }">
      <template v-if="item.sender && item.sender_id !== userStore.authUser.id">
        <strong class="sender-name">{{ item.sender.name }}:</strong> <br>
        <span class="msg-body">{{ item.content }}</span>
        <span class="msg-time">{{formatTimestamp(item.time)}}</span>
      </template>
      <template  v-else>
        <span class="msg-body">{{ item.content }}</span>
        <span class="msg-time">{{formatTimestamp(item.time)}}</span>
        <span @click="() => deleteMessage(item.id)" class="delete-button"><TrashIcon style="height: 15px; width: 15px"></TrashIcon></span>


      </template>
    </div>
  </div>
</template>

<style scoped>
.delete-button {
  margin-top: 5px;
  cursor: pointer;
}
.sender-name{
  font-size: 12px;
  color: red;
}
.messages{
  display: flex;
  flex-direction: column;
  width: 100%;
  box-sizing: border-box;
}
.threadMsg {

  display: flex;
  flex-direction: column;
  gap: 10px;
  padding: 10px;
  width: 1158px;
  position: relative;
  overflow-y: auto;


}

.msg-time{
  font-size: 10px;
  color: #888;

}
.msg-body{
  display: flex;
  align-items: center;
  justify-content: center;
  margin-top: 2px;
}

.msg-received {
  background-color: #fff;
  color: #000;
  padding-left: 15px;
  padding-right: 15px;
  padding-bottom: 10px;
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
  padding: 12px;
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