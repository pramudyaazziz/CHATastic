<template>
    <div class="d-flex px-4 py-2 chat-user mb-3" @click="$emit('open-conversation', chatUser.id)" :title="chatUser.last_message">
        <div class="col-3 avatar-chat-user">
            <img :src=" chatUser.interlocutor.avatar" alt="avatar">
        </div>
        <div class="col chat p-2 ms-2">
            <div class="d-flex text-white h-100 flex-column justify-content-center">
                <h6 class="name-chat-user">{{ chatUser.interlocutor.name }}</h6>
                <p class="last-message">{{ chatUser.last_message }}</p>
            </div>
        </div>
        <div class="col-2 d-flex justify-content-end" v-if="chatUser.unread_messages > 0">
            <p class="unread-message">{{ chatUser.unread_messages }}</p>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['url', 'chatUser']
    }
</script>
