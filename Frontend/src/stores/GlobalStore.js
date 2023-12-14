
import { defineStore } from "pinia";
import axios from 'axios';

export const useThreadItemStore = defineStore({
    id: 'threadItemStore',
    state: () => ({
        activeThreadItem: null,
        activeConv: null,

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
                const response = await axios.get(`http://127.0.0.1:8000/api/conversations/${conv}/messages`,{
                    headers: {
                        Authorization: `Bearer ${accessToken}`,
                    }});
                this.activeConv = response.data;
            } catch (error) {
                console.error('Error fetching messages:', error);
            }
        },


    },
});


