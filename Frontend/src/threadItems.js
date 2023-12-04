import {ref} from "vue";

export const threadItems = ref([
    { id: 1, name: 'John Doe', msgReceived: [{ id: 1, text: 'Hello' },{ id: 2, text: 'Yes' }], msgSend: [{ id: 2, text: 'Hi' }] },
    { id: 2, name: 'McGregor', msgReceived: [{ id: 1, text: 'Hello' },{ id: 2, text: 'Yes' }], msgSend: [{ id: 1, text: 'Hi' }] },
    { id: 3, name: 'Khabeeb', msgReceived: [{ id: 1, text: 'Salam' }], msgSend: [{ id: 2, text: 'W.salam' }] },

]);

export function addMessageToThread(threadId, message) {
    const thread = threadItems.value.find((item) => item.id === threadId);
    if (thread) {
        message.id = thread.msgSend.length + 1;
        thread.msgSend.push(message);
    }
}

// export function addMessageToThread(threadId, message) {
//     for (let i = 0; i < threadItems.value.length; i++) {
//         if (threadItems[i].id === threadId) {
//             message.id = threadItems[i].msgSend.length + 1;
//             threadItems[i].msgSend.push(message);
//             return;
//         }
//     }
// }