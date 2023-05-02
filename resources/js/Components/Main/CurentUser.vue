<script setup>
    import { Link, router} from "@inertiajs/vue3";
    const props = defineProps({
        user: {
            type: Object,
            required: true,
        }
    });

    const toProfile = () => {
        router.visit('/profile')
    }
</script>

<template>
    <div class="current-user p-3 justify-content-between" >
        <div class="d-flex justify-content-start w-100" @click="toProfile">
            <div class="avatar">
                <img :src="'http://127.0.0.1:8000/avatars/' + user.avatar + '?time=' + new Date().getTime()" alt="user_ava">
            </div>
            <div class="user">
                <div class="name">
                    <h6>{{ user.name }}</h6>
                    <small class="text-muted">@{{ user.username }}</small>
                </div>
            </div>
        </div>
        <div class="dropdown">
            <div type="button" data-bs-toggle="dropdown">
                <i class="bi bi-three-dots-vertical text-primary fs-5"></i>
            </div>
            <ul class="dropdown-menu">
                <li><Link class="dropdown-item" :href="route('profile.edit')">Profile</Link></li>
                <li><Link class="dropdown-item text-danger" :href="route('logout')" method="post">Logout</Link></li>
            </ul>
        </div>
    </div>
</template>
