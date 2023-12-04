<!--<script setup>-->
<!--import {onMounted, ref, toRefs} from "vue";-->
<!--import {messages} from "@/messages";-->
<!--import {threadItems} from "@/threadItems"-->
<!--import {useThreadItemStore} from "@/stores/GlobalStore";-->
<!--const threadItemStore = useThreadItemStore();-->
<!--const {activeThreadItem} = toRefs(threadItemStore);-->


<!--</script>-->

<!--<template>-->
<!--  <div class="threadMsg">-->
<!--    <div v-for="item in activeThreadItem.msgReceived" :key="item.id" class="msg-received">-->

<!--      {{item.text}}-->
<!--    </div>-->
<!--    <div v-for="item in activeThreadItem.msgSend" :key="item.id" class="msg-send">-->
<!--      {{item.text}}-->
<!--    </div>-->
<!--  </div>-->
<!--</template>-->

<script setup>
import { ref, onMounted, toRefs } from 'vue';
import { useThreadItemStore } from '@/stores/GlobalStore';
import axios from 'axios';
const { fetchedMessages } = toRefs(['fetchedMessages']);

const threadItemStore = useThreadItemStore();
const { activeThreadItem, activeConv } = toRefs(threadItemStore);

const messageInput = ref('');

// const sendMessage = async () => {
//   if (messageInput.value.trim() !== '') {
//     try {
//       // Use Axios to send a message
//       await axios.post(`http://127.0.0.1:8000/api/threads/${activeThreadItem.value.id}/messages`, {
//         text: messageInput.value,
//       });
//       // Fetch messages again after sending a new message
//       await threadItemStore.fetchMessages(activeThreadItem.value.id);
//       messageInput.value = '';
//     } catch (error) {
//       console.error('Error sending message:', error);
//     }
//   }
// };




onMounted(() => {
  // Fetch messages when the component is mounted
  if (activeConv.value) {
    threadItemStore.fetchMessages(activeConv);
  }
});
</script>

<template>
  <div class="threadMsg">
    <div v-for="message in fetchedMessages" :key="message.id" class="message">
      {{ message.text }}
    </div>
    <div v-for="item in activeConv" :key="item.id" class="msg-received">
      {{ item.text }}
    </div>
    <div v-for="item in activeConv" :key="item.id" class="msg-send">
      {{ item.text }}
    </div>

  </div>
</template>















<style scoped>
.threadMsg{
  display: flex;
  flex-direction: column;
  gap: 10px;
  padding: 10px;
  width: 100%;

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
  align-self: flex-end; /* Right-align sent messages */
  max-width: 500px; /* Limit message width for better readability */
  word-wrap: break-word;
  width: fit-content;
  font-size: medium;
}



</style>