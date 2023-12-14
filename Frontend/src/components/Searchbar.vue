<script setup>
import axios from "axios";
import {ArrowLeftIcon} from "@heroicons/vue/24/solid";
import {ref, watch, computed, inject, reactive} from 'vue';
import {useUserStore} from "@/stores/userStore";
const {hide} = defineProps(['hide']);
import {useConversationStore} from "@/stores/conversation";
const emit = defineEmits(['create','result-click','search','undo']);
import {useRouter} from "vue-router";
const userStore = useUserStore();
  const searchQuery = ref('');
const searchResults = ref([]);
const conversationStore =useConversationStore();
const selectedResult = ref(null);
const showBackIcon = ref(false);


const sortedResults = computed(() => {
  return searchResults.value.sort((a, b) => {
    const typeOrder = { 'one-to-one': 1, 'group': 2, 'user': 3 };
    return typeOrder[a.type] - typeOrder[b.type];
  });
});
userStore.fetchUsers();

const updateDisplayedResults = () => {

  const users = userStore.userList;
  const conversations = conversationStore.conversations || [];
  const usersWithConversations = conversations.reduce((usersWithConv, conv) => {
    if (conv.user1_id) usersWithConv.add(conv.user1_id);
    if (conv.user2_id) usersWithConv.add(conv.user2_id);
    return usersWithConv;
  }, new Set());

  const filteredUsers = users.filter(user => {
    return (
        user.name.toLowerCase().includes(searchQuery.value.toLowerCase()) &&
        !usersWithConversations.has(user.id)
    );
  });

  const groups = conversations.filter(conv => conv.group_name);
  const oneToOneConversations = conversations.filter(conv => conv.user1_id && conv.user2_id);

  // const filteredUsers = users.filter(user => user.name.toLowerCase().includes(searchQuery.value.toLowerCase()));
  const filteredGroups = groups.filter(group => group.group_name.toLowerCase().includes(searchQuery.value.toLowerCase()));
  const filteredOneToOne = oneToOneConversations.filter(conv => {
    const userOne = conv.user_one;
    const userTwo = conv.user_two;
    const currentUserId = userStore.authUser.id;

    if (userOne && userOne.id !== currentUserId) {
      return userOne.name.toLowerCase().includes(searchQuery.value.toLowerCase());
    } else if (userTwo && userTwo.id !== currentUserId) {
      return userTwo.name.toLowerCase().includes(searchQuery.value.toLowerCase());
    } else {
      return false;
    }
  });




  searchResults.value = [ ...filteredOneToOne, ...filteredGroups,  ...filteredUsers];
  emit('search', searchResults.value);
};
const handleResultClick = (result) => {
  emit('result-click', result);
};





// const updateDisplayedUsers = (newValue) => {
//
//   userStore.searchUserInList(newValue)
// };
const back = () => {
emit('create');
};
const backToConversations = () => {
showBackIcon.value=false;
emit('undo');
};


const selectedUsers = inject('groupMembers');
const createGroup = async () => {
  const groupNameInput = document.getElementById('groupNameInput');
  const groupName = groupNameInput.value;
  if (groupName) {
    try {
      const creatorId = userStore.authUser.id;
      selectedUsers.value.push(creatorId);
      const response = await axios.post('http://127.0.0.1:8000/api/conversations', {
        type: 0,
        group_name: groupName,
        creator_id: userStore.authUser.id,
        groupMembers: selectedUsers.value,
      });

      const newConversation = response.data.conversation;
emit('create');
    } catch (error) {
      console.error('Error creating group conversation:', error);
    }
  }
};
watch(searchQuery, updateDisplayedResults);
</script>

<template>
  <div v-if="!hide" class="Searchbar" @focusin="showBackIcon = true" >
            <span class="Searchbar">
    <ArrowLeftIcon @click="backToConversations" v-show="showBackIcon" class="back-icon"  style="height: 20px; width: 20px; margin-left: 20px; margin-top: 10px; cursor: pointer"/>

      <input v-model="searchQuery" @click="updateDisplayedResults" type="text" placeholder="Search or start a new Chat">
              <span v-if="sortedResults.length > 0">

      <span v-for="result in sortedResults" :key="result.id" @click="handleResultClick(result)">
<!--        {{ result.name }} - {{ result.type }}-->
                  </span>
              </span>
            </span>

  </div>
  <div class="group" v-else >
    <span class="groupName ">
    <ArrowLeftIcon @click="back" style="height: 20px; width: 20px; margin-left: 20px; margin-top: 10px; cursor: pointer"/>
    <input id="groupNameInput" type="text" placeholder="Enter Group Name">
      <button @click="createGroup" class="btn btn-success">Create</button>
  </span>
  </div>
</template>

<style scoped>
.Searchbar{
  height: 49px;
  width: 485px;
  background-color: #ffffff;

}
.btn{
  margin-left: 17px;

}
.group{
  height: 49px;
  width: 485px;
  background-color: #ffffff;

}
.Searchbar > input{
  width: 400px;
  height: 35px;
  font-size: small;
  background-color: #f0f2f5;

  padding-left: 22px;
  margin-left: 25px;
  border: none;
  border-radius: 8px;



}
.groupName > input{
  width: 328px;
  height: 35px;
  font-size: small;
  background-color: #f0f2f5;

  padding-left: 22px;
  margin-left: 22px;
  border: none;
  border-radius: 8px;
  margin-top: -10px;



}
.Searchbar > input:focus{
  outline: none;
}

</style>