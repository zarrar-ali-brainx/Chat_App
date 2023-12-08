<script setup>

import Messages from "@/components/Messages.vue";
import {useUserStore} from "@/stores/userStore";
import {useThreadItemStore} from "@/stores/GlobalStore";
import {useConversationStore} from "@/stores/conversation";
const userStore = useUserStore();
const threadItemStore = useThreadItemStore();
const conversationStore = useConversationStore();
</script>

<template>
  <div class="thread-screen">
    <div v-if="conversationStore.activeConversationData">
        <Messages />
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