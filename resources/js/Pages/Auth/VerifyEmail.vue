<script setup>
import { computed } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    status: {
        type: String,
    },
});

const form = useForm({});

const image = window.location.origin + '/assets/auth/img/locked.svg';

const submit = () => {
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(() => props.status === 'verification-link-sent');
</script>

<template>
    <GuestLayout>
        <Head title="Email Verification" />

        <div class="col-md-6 p-5 d-flex align-items-center">
            <img :src="image" alt="locked" class="img-fluid">
        </div>
        <div class="col-md-6 p-4">
            <div class="card h-100 shadow">
                <div class="card-body d-flex align-items-center">
                    <div class="col p-4">
                        <h5>Verify</h5>
                        <h3 class="text-primary fw-bold">Email</h3>
                        <hr>
                        <p class="text-muted">Thanks for signing up! Before getting started, could you verify your email address by clicking on the link
                            we just emailed to you? If you didn't receive the email, we will gladly send you another</p>
                        <form @submit.prevent="submit">
                            <div class="mt-4 d-flex justify-content-between">
                                <button class="btn btn-primary">
                                    Resend Verification Email
                                </button>

                                <Link
                                    :href="route('logout')"
                                    method="post"
                                    as="button"
                                    class="btn btn-secondary"
                                    >Log Out</Link
                                >
                            </div>
                        </form>
                        <div class="mt-4 font-medium text-sm text-success" v-if="verificationLinkSent">
                            A new verification link has been sent to the email address you provided during registration.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>
