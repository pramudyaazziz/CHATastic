<script setup>
    import CloseConversationButton from "@/Components/Main/CloseConversationButton.vue"
</script>

<template>
    <div class="interlocutor w-100 p-4">
        <div :class="[{'close-conversation': true, 'd-none': !isMobile}]">
            <CloseConversationButton @close-conversation="$emit('close-conversation')"/>
        </div>
        <div class="avatar" @click="$emit('open-profile')">
            <img :src="url + '/avatars/default.png'" alt="user_ava">
        </div>
        <div class="user">
            <div class="name">
                <h6 class="mb-1">Migle's</h6>
                <small class=" text-primary">Online</small>
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
            url: {
                type: String,
                required: true
            }
        }
    }
</script>
