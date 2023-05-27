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

const emit = defineEmits(['new-message', 'send-new-message', 'typing', 'not-typing']);

const emitSendNewMessage = () => {
    emit('send-new-message', {
        'conversation_id': props.conversation.id,
        'from_id': props.user.id,
        'to_id': props.interlocutor.id,
        'body': message.text,
        'type': 'text',
    });
}

const sendMessageWithConversation = () => {
    emitSendNewMessage()
    axios.post(route('store.message.conversation', props.conversation.id), message)
        .then(({data}) => {
            emit('new-message', data)
        })
        .catch(error => console.log(error))
        .finally(() => {
            message.reset();
            emit('not-typing')
        })
}

const sendMessageWithInterlocutor = () => {
    emitSendNewMessage()
    axios.post(route('store.message.interlocutor', props.interlocutor.id), message)
        .then(({data}) => {
            emit('new-message', data)
        })
        .catch(error => console.log(error))
        .finally(() => {
            message.reset();
        })
}

const typing = () => {
    if (props.conversation.id) {
        if (message.text == null || message.text == '') {
            emit('not-typing')
        } else {
            emit('typing')
        }
    }
}

const submit = throttle(() => {
    // Check if no text message or attachment
    if (message.text || message.images || message.document) {
        // Check has conversation
        if (props.conversation.id) {
            sendMessageWithConversation()
        } else {
            sendMessageWithInterlocutor()
        }
    }
}, 3000);

// Temporary Function
const showAlert = () => {
    alert('Attachment Feature Under Development')
}

</script>

<template>
    <form @submit.prevent="submit()">
        <div class="send-message">
            <div class="input-group flex-nowrap">
                <div class="dropup">
                <span class="input-group-text" @click="showAlert()" data-bs-toggle="dropdown" data-bs-auto-close="outside" title="Under Development" aria-expanded="false" disabled> <i class="bi bi-paperclip fs-5"></i> </span>
                <ul class="dropdown-menu mb-3" disabled>
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
