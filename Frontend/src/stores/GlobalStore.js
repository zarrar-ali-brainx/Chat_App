
import { defineStore } from "pinia";
import axios from 'axios';

export const useThreadItemStore = defineStore({
    id: 'threadItemStore',
    state: () => ({
        activeThreadItem: null,
        activeConv: null
    }),
    getters: {
        getActiveThreadItem() {
            return this.activeThreadItem;
        },
        getActiveConv() {
            return this.activeConv;
        },
    },
    actions: {
        setActiveThreadItem(threadItem) {
            this.activeThreadItem = threadItem;

        },

        setActiveConv(conv) {
            this.activeConv = conv;

        },


        async fetchMessages(conv) {
            try {
                const accessToken = localStorage.getItem('api_token');
                console.log(accessToken);
                const response = await axios.get(`http://127.0.0.1:8000/api/conversations/${conv}/messages`,{
                    headers: {
                        Authorization: `Bearer ${accessToken}`,
                    }});
                // this.activeConv.msgReceived = response.data;
            } catch (error) {
                console.error('Error fetching messages:', error);
            }
        },

        // async sendMessage(conv, messageText) {
        //     try {
        //         await axios.post(`http://127.0.0.1:8000/api/conversations/${conv}/messages`, {
        //             text: messageText,
        //         });
        //         // Fetch messages again after sending a new message
        //         await this.fetchMessages(conv);
        //     } catch (error) {
        //         console.error('Error sending message:', error);
        //     }
        // },
        // async sendMessageAndStore(messageText) {
        //     try {
        //         if (!this.activeThreadItem) {
        //             const response = await axios.post('http://127.0.0.1:8000/api/threads', {
        //                 title: 'New Conversation',
        //             });
        //
        //             this.setActiveThreadItem(response.data);
        //
        //             await this.fetchMessages(this.activeThreadItem.id);
        //         }
        //
        //         // Send the message to the server
        //         await axios.post(`http://127.0.0.1:8000/api/threads/${this.activeThreadItem.id}/messages`, {
        //             text: messageText,
        //         });
        //
        //         // Fetch messages again after sending a new message
        //         await this.fetchMessages(this.activeThreadItem.id);
        //     } catch (error) {
        //         console.error('Error sending message:', error);
        //     }
        // },
    },
});


