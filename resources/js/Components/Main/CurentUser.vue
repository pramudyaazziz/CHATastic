<script setup>
    import { Link, router, useForm} from "@inertiajs/vue3";
    const props = defineProps({
        user: {
            type: Object,
            required: true,
        }
    });

    const toProfile = () => {
        router.visit('/profile')
    }

    const form = useForm({});

    const logOut = () => {
        Echo.leave('conversation');
        form.post(route('logout'))
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
                <li class="dropdown-item text-danger" @click="logOut">Logout</li>
            </ul>
        </div>
    </div>
</template>
