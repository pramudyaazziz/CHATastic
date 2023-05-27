<script setup>
    import { Head, usePage } from "@inertiajs/vue3";
    import {ref, onMounted, onUnmounted} from 'vue';
    import MainLayout from "@/Layouts/MainLayout.vue";
    import CurrentUser from "@/Components/Main/CurentUser.vue";
    import SearchMessage from "@/Components/Main/SearchMessage.vue";
    import NewConversation from "@/Components/Main/NewConversation.vue";
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

    // Main Url
    const mainUrl = usePage().props.ziggy.url;
</script>

<template>
    <Head title="Conversation" />
    <MainLayout>
        <div :class="[{'col-md-3 p-0': true, 'd-none': conversationData && isMobile}]">
            <CurrentUser :user="user" :url="mainUrl"/>
            <div class="conversation-history bg-primary">
                <SearchMessage :chat-history="conversation" @filtered-chat-history="handleFilterChatHistory"/>
                <div class="chat-history">
                    <ChatUser @open-conversation="openConversation" v-for="chat in (filteredChatHistories != null ? filteredChatHistories : conversation)" :chatUser="chat"/>
                    <NoChatUser v-if="conversation.length === 0"/>
                </div>
                <NewConversation :url="mainUrl" @open-conversation="openConversation" @new-conversation="newConversation"/>
            </div>
        </div>
        <div :class="[{'col p-0 conversation-area': true, 'd-none': profileData && isMobile}]">
            <div v-if="conversationData" class="h-100">
                <Interlocutor @open-profile="openProfile" @close-conversation="closeConversation()" :is-mobile="isMobile" :interlocutor="conversationData.interlocutor" :online-user-id="onlineUserId" :is-typing="typing"/>
                <div class="chat-area p-4 messages-container" ref="messagesContainer">
                    <Message v-for="message in conversationData.messages" :key="message.id" :user="user" :message="message"/>
                </div>
                <FormSendMessage :user="user" :interlocutor="conversationData.interlocutor" :conversation="conversationData" @send-new-message="handleSendNewMessage" @new-message="handleNewMessage" @typing="handleTyping" @not-typing="handleNotTyping"/>
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
            },
            auth: {
                type: Object,
                required: true
            }
        },
        data() {
            return {
                user: this.auth.user,
                onlineUserId: [],
                conversation: this.chatHistory,
                conversationId: null,
                conversationData: null,
                profileUsername: null,
                profileData: null,
                filteredChatHistories: null,
                channel: null,
                typing: {
                    typing: false,
                    from_id: null
                },
            }
        },
        methods: {
            fetchChatHistory(){
                axios.get(route('chat.history'))
                    .then(({data}) => {
                        this.conversation = data
                    });
            },
            newConversation(interlocutor){
                let conversation = {
                    id: null,
                    interlocutor: interlocutor,
                    messages: []
                }
                this.conversationId = conversation.id;
                this.conversationData = conversation;
            },
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
            handleSendNewMessage(data) {
                this.conversationData.messages.push(data)
                this.conversationId = data.conversation_id;
                this.$nextTick(() => {
                    this.scrollToBottom();
                });
            },
            handleNewMessage(data) {
                this.conversationId = data.conversation_id
                this.conversationData.messages.pop();
                this.conversationData.messages.push(data);
                this.$nextTick(() => {
                    this.scrollToBottom();
                });
            },
            markAsReadMessage(message) {
                try {
                    axios.get( route('mark.read', message.id))
                } catch (error) {
                    console.log(error);
                }
            },
            handleTyping() {
                this.channel.whisper('clients-typing', {
                    typing: true,
                    from_id: this.user.id
                })
            },
            handleNotTyping() {
                this.channel.whisper('clients-typing', {
                    typing: false,
                    from_id: this.user.id
                })
            },
            scrollToBottom() {
                const container = this.$refs.messagesContainer;
                if (container) {
                    container.scrollTop = container.scrollHeight;
                }
            }
        },
        mounted() {
            Echo.join('conversation')
                .here(users => {
                    this.onlineUserId = users.map(user => user.id);
                })
                .joining(user => {
                    this.onlineUserId.push(user.id)
                })
                .leaving(user => {
                    this.onlineUserId = this.onlineUserId.filter(id => id !== user.id);
                })
                .listen('ConversationEvent', ({message}) => {
                    console.log(message);
                    let memberConversation = [message.from_id, message.to_id]
                    if (memberConversation.includes(this.auth.user.id)) {
                        this.fetchChatHistory();
                    }
                })
        },
        watch: {
            conversationId() {

                if (this.channel) {
                    this.channel.stopListening('NewMessageEvent');
                }

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
                    this.channel.listen('NewMessageEvent', ({message}) => {
                                    this.conversationData.messages.push(message)
                                    this.$nextTick(() => {
                                        this.scrollToBottom();
                                    });
                                    this.markAsReadMessage(message);
                                });
                    this.channel.listenForWhisper('clients-typing', (data) => {
                        this.typing = data
                    });

                    // Fetch Chat History
                    this.fetchChatHistory();
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
