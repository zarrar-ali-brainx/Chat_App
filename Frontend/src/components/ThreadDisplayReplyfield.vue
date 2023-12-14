<script setup>
import {FaceSmileIcon, MicrophoneIcon, PlusIcon, PaperAirplaneIcon} from "@heroicons/vue/24/solid";
import {ref, toRefs} from 'vue';
import {addMessageToThread} from "@/threadItems";
import {useThreadItemStore} from "@/stores/GlobalStore";
import {useConversationStore} from "@/stores/conversation";
const conversationStore = useConversationStore();
import axios from "axios";
const threadItemId =ref('')
const recipientId = ref('');
const threadItemStore = useThreadItemStore();
const {activeThreadItem} = toRefs(threadItemStore);
const {activeConversationData} = toRefs(conversationStore);
import {useUserStore} from "@/stores/userStore";
const userStore = useUserStore();
const isTyping = ref(false);
const newMessage = ref('');
const setConvId = (ConvId) => {
  threadItemStore.setConvId(ConvId);

};
const checkMessage = () => {
  isTyping.value = item.value.content.trim() !== '';
};
const {fetch} = defineProps(['fetch']);
const accessToken = localStorage.getItem('api_token');
const item =ref({
  content: '',
  recipientId: '',
  type: '0',
});
const groupItem = ref({
  content: '',
  recipientId:''
})
if(fetch){
  fetchMessages(activeConversationData.value.id);
}

const sendMessage = async () => {
  if (item.value.content.trim() !== '' || groupItem.value.content.trim() !== '') {

    if (activeConversationData.value?.group_name) {
      const previousConversationId = activeConversationData.value?.id;
      item.value.recipientId = activeConversationData.value.id;

      await axios.post(`http://127.0.0.1:8000/api/conversations/${item.value.recipientId}/group-messages`, item.value, {
        headers: {
          Authorization: `Bearer ${accessToken}`,
        }
      }).then(response => {
        fetchMessages(activeConversationData.value.id);


      }).catch(error => {
        console.log(error)
      })
      item.value.content = '';

    }

    else {

      try {
        let id = null;
        if (activeConversationData.value?.user2_id !== userStore.authUser.id) {
          id = activeConversationData.value?.user2_id;
        } else if (activeConversationData.value?.user1_id !== userStore.authUser.id) {
          id = activeConversationData.value?.user1_id;
        }
        const previousConversationId = activeConversationData.value?.id;

        item.value.recipientId = id || activeThreadItem.value?.id;
        await axios.post(`http://127.0.0.1:8000/api/conversations/${item.value.recipientId}/messages`, item.value, {
              headers: {
                Authorization: `Bearer ${accessToken}`,
              }
            }
        ).then(response => {

          fetchMessages(response.data.id);
          console.log(response.data.id);
          if (!previousConversationId) {

            conversationStore.fetchConversations();
            conversationStore.fetchConversationData(response.data.id)
          }

        }).catch(error => {
          console.log(error)
        })


        item.value.content = '';
      } catch (error) {
        console.error('Error sending message:', error);
      }
    }
  }
};

  const fetchMessages = async (conv_id) => {
    try {
      const response = await axios.get(`http://127.0.0.1:8000/api/conversations/${conv_id}/messages`,{
        headers: {
          Authorization: `Bearer ${accessToken}`,
        },

      }).then(response =>{
        threadItemStore.activeConv = response.data;

      });
    } catch (error) {
      console.error('Error fetching messages:', error);
    }
  };

    const message = {
      text: item.value.content,

    };





</script>

<template>

  <div class="thread-reply-field">
            <span class="tr-field">
              <FaceSmileIcon class="emoji"/>
              <PlusIcon class="plus-icon"/>
              <input v-model="item.content" @keydown.enter="sendMessage" @input="checkMessage" class="disable" type="text" placeholder="Type a message">
              <button @click="sendMessage" class="mic-button">
               <i v-if="!isTyping" class="microphone-icon"> <MicrophoneIcon class="microphone-icon"/></i>
              <i  v-else class="send-icon"><PaperAirplaneIcon class="send-icon"/></i>
                </button>
            </span>
  </div>
</template>

<style scoped>
.tr-field{
  display: flex;
  overflow: auto;
  position: relative;
  flex-direction: row;
  box-sizing: border-box;
}

.tr-field > input {
  background-color: #ffffff;
  font-size: medium;
  height: 40px;
  border-radius: 9px;
  width: 85%;
  border: none;
  margin-left: 20px;
  margin-top: 5px;
  padding-left: 15px;
}
.tr-field > input:focus{
  outline: none;
}

.emoji{
  height: 28px;
  width: 30px;
  margin-left: 15px;
  color: grey;
  cursor: pointer;
  margin-top: 12px;

}
.plus-icon{
  height: 28px;
  width: 30px;
  margin-left: 15px;
  color: grey;
  cursor: pointer;
  margin-top: 12px;

}
.microphone-icon{
  height: 25px;
  width: 30px;

  color: grey;
  cursor: pointer;


}
.mic-button{
  border: none;
  margin-left: 10px;
}
.send-icon{
  height: 25px;
  width: 30px;
  color: grey;
  cursor: pointer;

}
.disable{
  user-select: none;

}
</style>