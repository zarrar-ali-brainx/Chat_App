// import { defineStore } from 'pinia';
// import axios from 'axios';
//
// export const useUserStore = defineStore({
//     id: 'userStore',
//     state: () => ({
//         isUserListVisible: false,
//         userList: [],
//         activeUser: null,
//
//     }),
//     actions: {
//         async toggleUserList() {
//
//             this.isUserListVisible = !this.isUserListVisible;
//             await this.fetchUsers();
//         },
//         async fetchUsers() {
//             try {
//                 const response = await axios.get('http://127.0.0.1:8000/api/users'); // Adjust the API endpoint
//                 this.userList = response.data;
//             } catch (error) {
//                 console.error('Error fetching user list:', error);
//             }
//         },
//         setActiveUser(user) {
//             this.activeUser = user;
//         },
//     },
//     // getters: {
//     //     getIsUserListVisible() {
//     //         return this.isUserListVisible;
//     //     },
//     // },
// });
// store/userStore.js
import { defineStore } from 'pinia';
import axios from 'axios';

export const useUserStore = defineStore({
    id: 'userStore',
    state: () => ({
        authUser: {},
        isUserListVisible: false,
        userList: [],
        activeUser: null,
    }),
    getters: {
        getActiveUser() {
            return this.activeUser;
        },
    },
    actions: {
        setAuthUser(user){
            this.authUser = user;
        },
        setActiveUser(user) {
            this.activeUser = user;
        },
        async toggleUserList() {
            this.isUserListVisible = !this.isUserListVisible;
            await this.fetchUsers();
        },
        async fetchUsers() {
            try {
                const accessToken = window.localStorage.getItem('api_token')
                const response = await axios.get('http://127.0.0.1:8000/api/users',{
                        headers: {
                            Authorization: `Bearer ${accessToken}`,
                        },
                    }
                    );
                this.userList = response.data;
            } catch (error) {
                console.error('Error fetching user list:', error);
            }
        },

        async sendMessage(messageText) {
            try {
                await axios.post(`http://127.0.0.1:8000/api/messages`, {
                    userId: this.activeUser.id,
                    text: messageText,
                });

                await this.fetchMessages(this.activeUser.id);
            } catch (error) {
                console.error('Error sending message:', error);
            }
        },
        async fetchMessages(userId) {
            try {
                const response = await axios.get(`http://127.0.0.1:8000/api/users/${userId}/messages`);
                this.activeUser.messages = response.data;
            } catch (error) {
                console.error('Error fetching messages:', error);
            }
        },
    },
});
