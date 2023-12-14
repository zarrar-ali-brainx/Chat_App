import { reactive, provide, inject } from 'vue';

const state = reactive({
    selectedUsers: [],
});

export const provideSharedState = () => {
    provide('sharedState', state);
};

export const useSharedState = () => {
    const sharedState = inject('sharedState');
    if (!sharedState) {
        throw new Error('useSharedState must be used within a component provided with provideSharedState');
    }
    return sharedState;
};