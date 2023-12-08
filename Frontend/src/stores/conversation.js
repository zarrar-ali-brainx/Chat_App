import { defineStore } from 'pinia';
import axios from 'axios';

export const useConversationStore = defineStore({
    id: 'conversationStore',
    state: () => ({
        conversations: [],
        activeConversationId: null,
        activeConversationData: null,
    }),
    actions: {
        async fetchConversations() {
            try {
                const accessToken = localStorage.getItem('api_token');
                const response = await axios.get('http://127.0.0.1:8000/api/conversations', {
                    headers: {
                        Authorization: `Bearer ${accessToken}`,
                    },
                });
                this.conversations = response.data;
            } catch (error) {
                console.error('Error fetching conversations:', error);
            }
        },
        setActiveConversation(conv_id) {
            this.activeConversationId = conv_id;
           this.fetchConversationData(conv_id);
        },
        setActiveConv(conv_id) {
            this.activeConversationId = conv_id;

        },
        async fetchConversationData(conv_id) {
            try {
                const accessToken = localStorage.getItem('api_token');
                const response = await axios.get(`http://127.0.0.1:8000/api/conversations/${conv_id}`, {
                    headers: {
                        Authorization: `Bearer ${accessToken}`,
                    },
                });
                if (response.data) {
                    this.activeConversationData = response.data;
                } else {
                    this.activeConversationData = null;
                }
            } catch (error) {
                console.error('Error fetching conversation data:', error);
            }
        },
    },
});