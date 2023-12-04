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
            // Optionally, you can fetch additional data for the active conversation
           this.fetchConversationData(conv_id);
        },
        async fetchConversationData(conv_id) {
            try {
                const accessToken = localStorage.getItem('api_token');
                const response = await axios.get(`http://127.0.0.1:8000/api/conversations/${conv_id}`, {
                    headers: {
                        Authorization: `Bearer ${accessToken}`,
                    },
                });
                this.activeConversationData = response.data;
            } catch (error) {
                console.error('Error fetching conversation data:', error);
            }
        },
    },
});