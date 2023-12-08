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
      <UserIcon class="user-icon text-white"/>
      <p class="user-name">{{ userStore.authUser.name }}</p>
    </div>
    <div class="icons-container">

    <UsersIcon style="width: 23px;height: 23px; margin-top: 18px; margin-left: 70px; cursor: pointer; "/>
    <ChatBubbleOvalLeftEllipsisIcon style="width: 23px;height: 23px; margin-top: 17px; margin-left: 30px; cursor: pointer;"/>
    <PlusIcon @click="toggleUserList()" style="width: 23px;height: 23px; margin-top: 17px; margin-left: 30px; cursor: pointer;"/>
    <EllipsisVerticalIcon style="width: 23px;height: 23px; margin-top: 17px; margin-left: 20px; cursor: pointer;"/>
      <PowerIcon @click="Logout()" style="width: 21px;height: 21px; margin-top: 18px; margin-left: 20px; cursor: pointer;"/>
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



.users-icon{
  height: 40px;
  width: 40px;
  margin-top: 10px;

}
.tl-header {
  display: flex;
  flex-direction: row;
  flex-wrap: nowrap;
  height: 59px;
  width: 485px;
  background-color: #f0f2f5;
  position: relative;
  overflow: auto;
  box-sizing: border-box;
}

.user-info {
  display: flex;
  align-items: center;
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