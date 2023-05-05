<script setup>
    import Facebook from './Facebook.vue';
    import Instagram from './Instagram.vue';
    import Twitter from './Twitter.vue';
</script>

<template>
    <div class="d-flex flex-column justify-content-between align-items-center my-3">
        <div class="interlocutor-profile-avatar p-3">
            <img :src=" url + '/avatars/default.png'" alt="interlocutor_ava">
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
</template>

<script>
    export default {
        props: {
            url: {
                type: String,
                require: true
            }
        }
    }
</script>
