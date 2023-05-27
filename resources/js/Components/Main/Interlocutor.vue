<script setup>
    import CloseConversationButton from "@/Components/Main/CloseConversationButton.vue"
</script>

<template>
    <div class="interlocutor w-100 p-4">
        <div :class="[{'close-conversation': true, 'd-none': !isMobile}]">
            <CloseConversationButton @close-conversation="$emit('close-conversation')"/>
        </div>
        <div class="avatar" @click="$emit('open-profile', interlocutor.username)">
            <img :src="interlocutor.avatar" alt="user_ava">
        </div>
        <div class="user">
            <div class="name">
                <h6 class="mb-1">{{ interlocutor.name }}</h6>
                <template v-if="onlineUserId.includes(interlocutor.id)">
                    <small class="text-primary" v-if="isTyping.typing && isTyping.from_id == interlocutor.id">Typing...</small>
                    <small class="text-primary" v-else>Online</small>
                </template>
                <template v-else>
                    <small class="text-muted">Offline</small>
                </template>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            isMobile: {
                type: Boolean,
                required: true
            },
            interlocutor: {
                type: Object,
                required: true
            },
            onlineUserId: {
                type: Array,
                required: true
            },
            isTyping: {
                type: Object,
                required: true
            }
        }
    }
</script>
