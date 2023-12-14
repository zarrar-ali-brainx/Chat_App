import {ref} from "vue";

export const threadItems = ref([

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