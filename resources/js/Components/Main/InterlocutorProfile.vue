<script setup>
    import Facebook from './Facebook.vue';
    import Instagram from './Instagram.vue';
    import Twitter from './Twitter.vue';
</script>

<template>
    <div class="d-flex flex-column justify-content-between align-items-center my-3">
        <div class="interlocutor-profile-avatar mb-3">
            <img :src="interlocutorProfile.avatar" alt="interlocutor_ava">
        </div>
        <div class="interlocutor-profile-info ps-3 pe-3 pb-3">
            <h5 class="text-center interlocutor-user-name">{{ interlocutorProfile.name }}</h5>
            <p class="text-center interlocutor-user-username mt-1"><small class="text-muted">@{{ interlocutorProfile.username }}</small></p>
            <p class="text-center interlocutor-user-bio mt-3">{{ interlocutorProfile.bio }}</p>
        </div>
        <div class="interlocutor-profile-social-media p-3">
            <Facebook v-if="interlocutorProfile.platform.facebook" :url="url" :profileUrl="interlocutorProfile.platform.facebook"/>
            <Twitter v-if="interlocutorProfile.platform.twitter" :url="url" :username="interlocutorProfile.platform.twitter"/>
            <Instagram v-if="interlocutorProfile.platform.instagram" :url="url" :username="interlocutorProfile.platform.instagram"/>
        </div>
    </div>
    <div class="interlocutor-profile-contact p-3">
        <div class="contact-number" v-if="interlocutorProfile.phone_number">
            <div class="contact-icon">
                <i class="bi bi-phone fs-3 text-muted"></i>
            </div>
            <span class="text-muted">{{ interlocutorProfile.phone_number }}</span>
        </div>
        <div class="contact-email">
            <div class="contact-icon">
                <i class="bi bi-envelope fs-3 text-muted"></i>
            </div>
            <span class="text-muted">{{ interlocutorProfile.email }}</span>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            interlocutorProfile: {
                type: Object,
                require: true
            },
            url: {
                type: String,
                require: true
            }
        }
    }
</script>
