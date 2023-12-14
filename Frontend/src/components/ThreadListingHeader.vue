<script setup>

import {
  ChatBubbleOvalLeftEllipsisIcon,
  ClockIcon,
  EllipsisVerticalIcon,
  PlusIcon, UserIcon,
  UsersIcon,
    PowerIcon
} from "@heroicons/vue/24/solid";
import {useUserStore} from "@/stores/userStore";
import {ref} from "vue";
import ContactItem from "@/components/ContactItem.vue";
import router from "@/router";
import {useRouter} from "vue-router";
const { create } = defineProps(['create']);
const emit = defineEmits(['create']);

const createGroup = () => {
  emit('create');
};
const isUserListVisible = ref(false);
const userStore = useUserStore();
const router1 = useRouter();
const toggleUserList = () => {
  userStore.toggleUserList()

};
const Logout = () => {
window.localStorage.removeItem('api_token');
window.location.href = '/login';
};

</script>

<template>
  <div class="tl-header">
    <div class="user-info">
      <UserIcon class="user-icon text-white" style="margin-right: 8px; height: 40px; width: 40px;  background-color: lightslategray"  />
      <p class="user-name" style="width: 15%; margin-top: 20px">{{ userStore.authUser.name }}</p>
    </div>
    <div class="icons-container">
    <UsersIcon class="users-icon" @click="createGroup()" style="width: 23px;height: 23px; margin-top: 18px; margin-left: 105px; cursor: pointer;" />
    <ChatBubbleOvalLeftEllipsisIcon style="width: 23px;height: 23px; margin-top: 17px; margin-left: 30px; cursor: pointer;"/>
    <PlusIcon @click="toggleUserList()" style="width: 23px;height: 23px; margin-top: 17px; margin-left: 30px; cursor: pointer;"/>
      <PowerIcon @click="Logout()" style="width: 21px;height: 21px; margin-top: 18px; margin-left: 20px; margin-right: 5px; cursor: pointer;"/>
<!--    <transition name="fade">-->
<!--      <div v-if="isUserListVisible">-->
<!--        &lt;!&ndash; Fetch and display user list using ContactItem component &ndash;&gt;-->
<!--        <ContactItem v-for="user in userStore.userList" :key="user.id" :user="user" />-->
<!--      </div>-->
<!--    </transition>-->
    </div>
  </div>

</template>

<style scoped>



.group-icon {
  display: none;
}

.users-icon:hover + .group-icon {
  display: block;
  color: red;
}
.tl-header {
  display: flex;
  flex: 0 0 auto; /* flex-grow: 0, flex-shrink: 0, flex-basis: auto */
  overflow: hidden; /* Hide content that overflows */
  white-space: nowrap;
  flex-direction: row;
  flex-wrap: nowrap;
  height: 59px;
  width: 485px;
  background-color: #f0f2f5;
  position: relative;
  box-sizing: border-box;
}

.user-info {
  display: flex;
  align-items: center;
  width: 40%;
}

.user-icon {
  height: 40px;
  width: 40px;
  overflow: auto;
  border-radius: 50%;
  border: 1px black;
  margin-left: 15px;
  margin-top: 10px;
  background-color: lightgray;
  margin-right: 10px; /* Adjust this margin as needed */
  cursor: pointer;
  max-width: 100%;
  position: relative;
}

.user-name {
  margin-left: 5px;
  font-size: 20px; /* Adjust font size as needed */
  font-weight: bold;
  margin-right: 80px;
}
.icons-container {
  display: flex;

}

.icons-container span {
  margin-right: 10px; /* Adjusted margin between icons */
}

</style>