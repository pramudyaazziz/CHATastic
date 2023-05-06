<template>
    <div class="input-group p-4 search">
        <span class="input-group-text"><i class="bi bi-search text-white fs-4"></i></span>
        <input type="search" class="form-control input-search" placeholder="Search..." v-model="searchQuery" @input="searchConversations">
    </div>
</template>

<script>
    export default {
        props: {
            chatHistory: {
                type: Array,
                required: true
            }
        },
        data() {
            return {
                searchQuery: '',
                filteredChatHistory: [],
            }
        },
        methods: {
            searchConversations() {
                if (this.searchQuery != '') {
                    this.filteredChatHistory = this.chatHistory.filter(chat => {
                        const interlocutorName = chat.interlocutor.name.toLowerCase();
                        const lastMessage = chat.last_message.toLowerCase();
                        const searchQuery = this.searchQuery.toLowerCase();
                        if (!interlocutorName || !lastMessage) {
                            return false;
                        }
                        return interlocutorName.includes(searchQuery) || lastMessage.includes(searchQuery);
                    });
                } else {
                    this.filteredChatHistory = this.chatHistory;
                }
            }
        },
        watch: {
            filteredChatHistory(val) {
                this.$emit('filtered-chat-history', val);
            }
        }
    }
</script>
