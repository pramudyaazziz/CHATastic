<script setup>
    import { Head, usePage } from "@inertiajs/vue3";
    import {ref, onMounted, onUnmounted} from 'vue';
    import MainLayout from "@/Layouts/MainLayout.vue";
    import CurrentUser from "@/Components/Main/CurentUser.vue";
    import SearchMessage from "@/Components/Main/SearchMessage.vue";
    import NewChat from "@/Components/Main/NewChat.vue";
    import ChatUser from "@/Components/Main/ChatUser.vue";
    import NoChatUser from "@/Components/Main/NoChatUser.vue";
    import Interlocutor from "@/Components/Main/Interlocutor.vue";
    import Message from "@/Components/Main/Message.vue";
    import FormSendMessage from "@/Components/Main/FormSendMessage.vue";
    import CloseInterlocutorProfileButton from "@/Components/Main/CloseInterlocutorProfileButton.vue";
    import InterlocutorProfile from "@/Components/Main/InterlocutorProfile.vue";

    // Get Breakpoint whether it isMobile or not
    const isMobile = ref(window.innerWidth < 768);
    const handleResize = () => {
      isMobile.value = window.innerWidth < 768;
    }
    onMounted(() => {
      window.addEventListener('resize', handleResize);
    })
    onUnmounted(() => {
      window.removeEventListener('resize', handleResize);
    })

    // Current authenticable user
    const user = usePage().props.auth.user;

    // Main Url
    const mainUrl = usePage().props.ziggy.url;
</script>

<template>
    <Head title="Conversation" />
    <MainLayout>
        <div :class="[{'col-md-3 p-0': true, 'd-none': conversationData && isMobile}]">
            <CurrentUser :user="user" />
            <div class="conversation-history bg-primary">
                <SearchMessage :chat-history="chatHistory" @filtered-chat-history="handleFilterChatHistory"/>
                <div class="chat-history">
                    <ChatUser @open-conversation="openConversation" :url="mainUrl" v-for="chat in (filteredChatHistories != null ? filteredChatHistories : chatHistory)" :chatUser="chat"/>
                    <NoChatUser v-if="chatHistory.length === 0"/>
                </div>
                <NewChat :url="mainUrl"/>
            </div>
        </div>
        <div :class="[{'col p-0 conversation-area': true, 'd-none': profileData && isMobile}]">
            <div v-if="conversationData" class="h-100">
                <Interlocutor @open-profile="openProfile()" @close-conversation="closeConversation()" :is-mobile="isMobile" :url="mainUrl"/>
                <div class="chat-area p-4">
                    <Message v-for="message in messages" :key="message.id" :user="user" :message="message"/>
                </div>
                <FormSendMessage :action="''"/>
            </div>
        </div>
        <div :class="[{'col-md-3 interlocutor-profile p-3': true}]" v-if="profileData">
            <CloseInterlocutorProfileButton @close-profile="closeProfile()"/>
            <InterlocutorProfile :url="mainUrl"/>
        </div>
    </MainLayout>
</template>


<script>
    export default {
        props: {
            chatHistory: {
                type: Object,
                required: true
            }
        },
        data() {
            return {
                conversationId: null,
                conversationData: null,
                profileId: null,
                profileData: null,
                filteredChatHistories: null,
                messages: [
                    {
                        id: 1,
                        from_id: 5,
                        to_id: 2,
                        body: 'Hei apakabar?',
                        created_at: 'Today 02:44'
                    },
                    {
                        id: 2,
                        from_id: 2,
                        to_id: 5,
                        body: 'Kerja Bagus',
                        created_at: 'Today 02:46'
                    }
                ]
            }
        },
        methods: {
            openConversation(id) {
                this.conversationData = 'ada'
            },
            closeConversation() {
                this.conversationData = null
            },
            openProfile(id) {
                this.profileData = 'ada'
            },
            closeProfile() {
                this.profileData = null
            },
            handleFilterChatHistory(chat) {
                this.filteredChatHistories = chat
            }
        }
    }
</script>
