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

        <div class="col-md-6 p-5 d-md-flex d-none align-items-center">
            <img :src="image" alt="locked" class="img-fluid">
        </div>
        <div class="col-md-6 p-4 d-flex align-items-center">
            <div class="card shadow w-100">
                <div class="card-body d-flex align-items-center">
                    <div class="col p-4">
                        <h5>Verify</h5>
                        <h3 class="text-primary fw-bold">Email</h3>
                        <hr>
                        <span class="text-muted">Thanks for signing up! You could verify your email address by clicking on the link
                            we just emailed to you? If you didn't receive the email make sure to check spam section as well!</span>
                        <form @submit.prevent="submit">
                            <div class="mt-4 d-flex justify-content-between">
                                <button :class="[{ 'btn': true, 'btn-primary': true, 'loading': form.processing }]">
                                    <div v-if="form.processing">
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                            Sending...
                                    </div>
                                    <span v-else>Resend Verification Email</span>
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
                            New verification link has been sent to your email
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>
