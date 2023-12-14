<script setup>

import Messages from "@/components/Messages.vue";
import {useUserStore} from "@/stores/userStore";
import {useThreadItemStore} from "@/stores/GlobalStore";
import {useConversationStore} from "@/stores/conversation";
import {onMounted, ref} from "vue";
import {storeToRefs} from "pinia";
const userStore = useUserStore();
const threadItemStore = useThreadItemStore();
const conversationStore = useConversationStore();
const activeConversationData = storeToRefs(conversationStore)
const {fetch} = defineProps(['fetch'])
const emit = defineEmits(['fetchMsg'])
const fetchMsgs = () =>{
  emit('fetchMsg');
}
</script>

<template>
  <div ref="chatContainer" class="thread-screen">
    <div v-if="conversationStore.activeConversationData">
        <Messages @fetch="fetchMsgs"/>
      </div>
    </div>

</template>

<style scoped>
.thread-screen{
  display: flex;
  height: 810px;
  background-color: #ECE5DD;
  max-width: 100%;
  position: relative;
  overflow: auto;

}

</style>