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
                    <ChatUser @open-conversation="openConversation" v-for="chat in (filteredChatHistories != null ? filteredChatHistories : chatHistory)" :chatUser="chat"/>
                    <NoChatUser v-if="chatHistory.length === 0"/>
                </div>
                <NewChat :url="mainUrl"/>
            </div>
        </div>
        <div :class="[{'col p-0 conversation-area': true, 'd-none': profileData && isMobile}]">
            <div v-if="conversationData" class="h-100">
                <Interlocutor @open-profile="openProfile" @close-conversation="closeConversation()" :is-mobile="isMobile" :interlocutor="conversationData.interlocutor" :is-typing="typing"/>
                <div class="chat-area p-4 messages-container" ref="messagesContainer">
                    <Message v-for="message in conversationData.messages" :key="message.id" :user="user" :message="message"/>
                </div>
                <FormSendMessage :user="user" :interlocutor="conversationData.interlocutor" :conversation="conversationData" @new-message="handleNewMessage" @typing="handleTyping" @not-typing="handleNotTyping"/>
            </div>
        </div>
        <div :class="[{'col-md-3 interlocutor-profile p-3': true}]" v-if="profileData">
            <CloseInterlocutorProfileButton @close-profile="closeProfile()"/>
            <InterlocutorProfile :interlocutor-profile="profileData" :url="mainUrl"/>
        </div>
    </MainLayout>
</template>


<script>
import axios from "axios";
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
                profileUsername: null,
                profileData: null,
                filteredChatHistories: null,
                channel: null,
                typing: false
            }
        },
        methods: {
            openConversation(id) {
                this.conversationId = id;
                this.profileData = null;
                this.profileUsername = null;
            },
            closeConversation() {
                this.conversationData = null;
                this.conversationId = null;
            },
            openProfile(username) {
                this.profileUsername = username;
            },
            closeProfile() {
                this.profileData = null;
                this.profileUsername = null;
            },
            handleFilterChatHistory(chat) {
                this.filteredChatHistories = chat;
            },
            handleNewMessage(data) {
                this.conversationData.messages.push(data);
                this.$nextTick(() => {
                    this.scrollToBottom();
                });
            },
            handleTyping() {
                this.channel.whisper('clients-typing', {
                    typing: true
                })
            },
            handleNotTyping() {
                this.channel.whisper('clients-typing', {
                    typing: false
                })
            },
            scrollToBottom() {
                const container = this.$refs.messagesContainer;
                if (container) {
                    container.scrollTop = container.scrollHeight;
                }
            }
        },
        watch: {
            conversationId() {
                if (this.conversationId) {
                    axios.get( route('conversation.show', this.conversationId))
                        .then(response => {
                            const {conversation} = response.data;
                            this.conversationData = conversation
                            this.$nextTick(() => {
                                this.scrollToBottom();
                            });
                        })
                        .catch(err => console.log(err));


                    // Listen private message channel

                    this.channel = Echo.private('message.' + this.conversationId);
                    this.channel.listen('NewMessage', ({message}) => {
                                    this.conversationData.messages.push(message)
                                    this.$nextTick(() => {
                                        this.scrollToBottom();
                                    });
                                });
                    this.channel.listenForWhisper('clients-typing', ({typing}) => {
                        this.typing = typing
                    });
                }

                if (!this.conversationId) {
                    this.channel.stopListening('NewMessage');
                }
            },
            profileUsername() {
                if (this.profileUsername) {
                    axios.get( route('profile.detail', this.profileUsername))
                        .then(response => {
                            this.profileData = response.data
                        })
                        .catch( err => console.log(err))
                }
            }
        }
    }
</script>
