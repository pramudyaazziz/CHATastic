<template>
    <div :class="[{'new-chat d-flex flex-row-reverse': true, 'clicked': clicked}]" title="New Chat">
        <div class="btn-new-chat"  @click="toggleClicked">
            <i class="bi bi-plus text-primary fs-1"></i>
        </div>
        <div class="input-new-chat d-flex justify-content-center">
            <input type="text" placeholder="Type username" v-model="searchUser" @input="fetchUser">
        </div>
        <div class="result-input bg-white p-2" v-if="resultUser.length">
            <ResultUser :url="url" v-for="result in resultUser" :result="result" @click="handleClickResultUser(result)"/>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import { throttle } from "lodash";
import ResultUser from "./ResultUser.vue";

    export default {
        components: {
            ResultUser
        },
        props: {
            url: {
                type: String,
                required: true
            }
        },
        data() {
            return {
                clicked: false,
                searchUser: null,
                resultUser: []
            }
        },
        methods: {
            fetchUser: throttle(function() {
                axios.get( route('chat.new') + '?username=' + this.searchUser)
                    .then(response => {
                        const {users} = response.data
                        this.resultUser = users;
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }, 2000),
            toggleClicked() {
                this.clicked = !this.clicked;
                this.searchUser = null
                this.resultUser = []
            },
            handleClickResultUser(user) {
                if (user.conversation_id) {
                    this.$emit('open-conversation', user.conversation_id)
                } else {
                    this.$emit('new-conversation', user)
                }

                this.toggleClicked();
            }
        }
    }
</script>
