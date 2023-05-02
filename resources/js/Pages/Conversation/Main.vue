<script setup>
    import { Head, usePage } from "@inertiajs/vue3";
    import MainLayout from "@/Layouts/MainLayout.vue";
    import {ref, onMounted, onUnmounted} from 'vue';
    import CurrentUser from "@/Components/Main/CurentUser.vue";
    import SearchMessage from "@/Components/Main/SearchMessage.vue";
    import NewChat from "@/Components/Main/NewChat.vue";
    import ChatUser from "@/Components/Main/ChatUser.vue";

    const showSidebar = ref(true);
    const showConversation = ref(false);
    const showProfile = ref(false);
    const isMobile = ref(window.innerWidth < 768);

    const user = usePage().props.auth.user;

    const handleResize = () => {
      isMobile.value = window.innerWidth < 768;
    }

    onMounted(() => {
      window.addEventListener('resize', handleResize);
    })

    onUnmounted(() => {
      window.removeEventListener('resize', handleResize);
    })

    const toggleConversation = () => {
      showConversation.value = !showConversation.value;
      showProfile.value = false;
    };

    const toggleProfile = () => {
      showProfile.value = !showProfile.value;
    };
</script>

<template>
    <Head title="Conversation" />
    <MainLayout>
        <div :class="[{'col-md-3 p-0': true, 'd-none': showConversation && isMobile}]" v-if="showSidebar">
            <CurrentUser :user="user" />
            <div class="conversation-history bg-primary">
                <SearchMessage/>
                <div class="chat-history">
                    <ChatUser @toggle-conversation="toggleConversation"/>
                </div>
                <NewChat/>
            </div>
        </div>
        <div :class="[{'col p-0 conversation-area': true, 'd-none': showProfile && isMobile}]">
            <div v-if="showConversation" class="h-100">
                <div class="interlocutor w-100 p-4">
                    <div :class="[{'close-conversation': true, 'd-none': !isMobile}]">
                        <div class="close-conversation-button" @click="toggleConversation">
                            <i class="bi bi-arrow-left fs-2"></i>
                        </div>
                    </div>
                    <div class="avatar" @click="toggleProfile">
                        <img :src="'http://127.0.0.1:8000/avatars/default.png'" alt="user_ava">
                    </div>
                    <div class="user">
                        <div class="name">
                            <h6 class="mb-1">Migle's</h6>
                            <small class=" text-primary">Online</small>
                        </div>
                    </div>
                </div>
                <div class="chat-area p-4">
                    <div class="message">
                        <div class="not-my-message">
                            <div class="message-content bg-white p-2">
                                How are you?
                            </div>
                        </div>
                        <p class="message-time my-1">Today 02.44</p>
                    </div>
                    <div class="message mb-1">
                        <div class="is-my-message">
                            <div class="message-content bg-primary p-2">
                                I'm okay :)
                            </div>
                        </div>
                    </div>
                    <div class="message">
                        <div class="is-my-message">
                            <div class="message-content bg-primary p-2">
                                And you?
                            </div>
                        </div>
                        <p class="message-time my-1">Today 02.44</p>
                    </div>
                    <div class="message">
                        <div class="not-my-message">
                            <div class="message-content bg-white p-2">
                                Ah.. i'm fine thankyou
                            </div>
                        </div>
                        <p class="message-time my-1">Today 02.44</p>
                    </div>
                </div>
                <form action="" @submit.prevent>
                    <div class="send-message">
                        <div class="input-group flex-nowrap">
                            <div class="dropup">
                                <span class="input-group-text" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false"> <i class="bi bi-paperclip fs-5"></i> </span>
                                <ul class="dropdown-menu mb-3">
                                    <li>
                                        <label class="dropdown-item text-primary" for="image"><i class="bi bi-image-fill me-3"></i>Image</label>
                                        <input type="file" id="image" class="d-none" accept="image/*">
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <label class="dropdown-item text-primary" for="document"><i class="bi bi-file-earmark-text-fill me-3"></i>Document</label>
                                        <input type="file" id="document" class="d-none" accept=".pdf,.doc,.docx,.xls,.xlsx,.zip,.rar">
                                    </li>
                                </ul>
                            </div>
                            <input type="text" class="form-control shadow-none" placeholder="Type a message here..." >
                        </div>
                        <button type="submit" class="send-button bg-primary">
                            <i class="icon-send"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div :class="[{'col-md-3 interlocutor-profile p-3': true}]" v-if="showProfile">
            <div class="close-interlocutor-profile-button" @click.native="toggleProfile()">
                <i class="bi bi-x-lg fs-5 text-primary"></i>
            </div>
            <div class="d-flex flex-column justify-content-between align-items-center my-3">
                <div class="interlocutor-profile-avatar p-3">
                    <img :src="'http://127.0.0.1:8000/avatars/default.png'" alt="interlocutor_ava">
                </div>
                <div class="interlocutor-profile-info ps-3 pe-3 pb-3">
                    <h5 class="text-center interlocutor-user-name">Migle's</h5>
                    <p class="text-center interlocutor-user-username mt-1"><small class="text-muted">@meig.sle</small></p>
                    <p class="text-center interlocutor-user-bio mt-3">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean m</p>
                </div>
                <div class="interlocutor-profile-social-media p-3">
                    <div class="facebook">
                        <a href="">
                            <img src="http://127.0.0.1:8000/assets/icon/facebook.svg" alt="fb">
                        </a>
                    </div>
                    <div class="twitter">
                        <a href="">
                            <img src="http://127.0.0.1:8000/assets/icon/twitter.svg" alt="tw">
                        </a>
                    </div>
                    <div class="instagram">
                        <a href="">
                            <img src="http://127.0.0.1:8000/assets/icon/instagram.svg" alt="ig">
                        </a>
                    </div>
                </div>
            </div>
            <div class="interlocutor-profile-contact p-3">
                <div class="contact-number">
                    <div class="contact-icon">
                        <i class="bi bi-phone fs-3 text-muted"></i>
                    </div>
                    <span class="text-muted">0839883883</span>
                </div>
                <div class="contact-email">
                    <div class="contact-icon">
                        <i class="bi bi-envelope fs-3 text-muted"></i>
                    </div>
                    <span class="text-muted">mrfuncyxd@gmail.com</span>
                </div>
            </div>
        </div>
    </MainLayout>
</template>
