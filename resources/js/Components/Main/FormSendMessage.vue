<script setup>
import { useForm } from '@inertiajs/vue3';
import axios from 'axios';
import { throttle } from 'lodash';

const props = defineProps({
    user: {
        type: Object,
        required: true
    },
    interlocutor: {
        type: Object,
        required: true
    },
    conversation: {
        type: Object,
        default: null
    },
});

const message = useForm({
    text: null,
    images: null,
    document: null
});

// watch(() => message.text, val => {
//     if (val == null || val == '') {
//         emit('not-typing')
//     }
// })

const emit = defineEmits(['new-message', 'send-new-message', 'typing', 'not-typing']);

const sendMessageWithConversation = (conversation, user, interlocutor) => {
    emit('send-new-message', {
        'conversation_id': conversation.id,
        'from_id': user.id,
        'to_id': interlocutor.id,
        'body': message.text,
        'type': 'text',
    });
    axios.post(route('store.message.conversation', conversation.id), message)
        .then(({data}) => {
            emit('new-message', data)
        })
        .catch(error => console.log(error))
        .finally(() => {
            message.reset();
            emit('not-typing')
        })
}

const sendMessageWithoutConversation = () => {
    console.log('test')
}

const typing = () => {
    if (message.text == null || message.text == '') {
        emit('not-typing')
    } else {
        emit('typing')
    }
}

const submit = throttle((conversation, user, interlocutor) => {
    // Check if no text message or attachment
    if (message.text || message.images || message.document) {
        // Check has conversation
        if (conversation) {
            sendMessageWithConversation(conversation, user, interlocutor)
        } else {
            sendMessageWithoutConversation()
        }
    }
}, 3000);

</script>

<template>
    <form @submit.prevent="submit(conversation, user, interlocutor)">
        <div class="send-message">
            <div class="input-group flex-nowrap">
                <div class="dropup">
                    <span class="input-group-text" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false"> <i class="bi bi-paperclip fs-5"></i> </span>
                    <ul class="dropdown-menu mb-3">
                        <li>
                            <label class="dropdown-item text-primary" for="image"><i class="bi bi-image-fill me-3"></i>Image</label>
                            <input type="file" id="image" class="d-none" accept="image/*">
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <label class="dropdown-item text-primary" for="document"><i class="bi bi-file-earmark-text-fill me-3"></i>Document</label>
                            <input type="file" id="document" class="d-none" accept=".pdf,.doc,.docx,.xls,.xlsx,.zip,.rar">
                        </li>
                    </ul>
                </div>
                <input type="text" class="form-control shadow-none" v-model="message.text" placeholder="Type a message here..." @input="typing">
            </div>
            <button type="submit" class="send-button bg-primary">
                <i class="icon-send"></i>
            </button>
        </div>
    </form>
</template>
