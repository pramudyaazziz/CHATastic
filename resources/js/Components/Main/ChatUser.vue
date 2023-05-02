<template>
    <div class="d-flex px-4 py-2 chat-user mb-3" @click="$emit('toggle-conversation')">
        <div class="col-3 avatar-chat-user">
            <img :src="'http://127.0.0.1:8000/avatars/default.png'" alt="avatar">
        </div>
        <div class="col chat p-2 ms-2">
            <div class="d-flex text-white h-100 flex-column justify-content-center">
                <h6 class="name-chat-user">Migle's</h6>
                <p class="last-message">Ah.. i'm fine thankyou</p>
            </div>
        </div>
        <!-- <div class="col-2 d-flex justify-content-end">
            <p class="unread-message">6</p>
        </div> -->
    </div>
</template>
