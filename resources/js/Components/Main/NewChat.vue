<script setup>
    import { useForm } from "@inertiajs/vue3";
    import { ref } from "vue"

    const clicked = ref(false);

    const newMessage = useForm({
        input: null
    });

    const toggleClicked = () => {
        clicked.value = !clicked.value;
        newMessage.input = null
    }
</script>

<template>
    <div :class="[{'new-chat d-flex flex-row-reverse': true, 'clicked': clicked}]">
        <div class="btn-new-chat"  @click="toggleClicked">
            <i class="bi bi-plus text-primary fs-1"></i>
        </div>
        <div class="input-new-chat d-flex justify-content-center">
            <input type="text" placeholder="Type username" v-model="newMessage.input">
        </div>
        <div class="result-input bg-white p-2" v-if="clicked">
            <div class="result-user p-2">
                <div class="avatar" style="width: 50px; height: 50px;">
                    <img :src="'http://127.0.0.1:8000/avatars/default.png'" alt="user_ava">
                </div>
                <div class="user">
                    <div class="name">
                        <h6>Martin Luge</h6>
                        <small class="text-muted">@melies</small>
                    </div>
                </div>
            </div>
            <!-- <h6 class="text-muted text-center">No Result</h6> -->
        </div>
    </div>
</template>
