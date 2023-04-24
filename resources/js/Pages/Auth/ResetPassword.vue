<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    email: {
        type: String,
        required: true,
    },
    token: {
        type: String,
        required: true,
    },
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const image = window.location.origin + '/assets/auth/img/setup.svg';

const submit = () => {
    form.post(route('password.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Reset Password" />

        <div class="col-md-6 p-5 d-flex align-items-center">
            <img :src="image" alt="locked" class="img-fluid">
        </div>
        <div class="col-md-6 p-4">
            <div class="card h-100 shadow">
                <div class="card-body d-flex align-items-center">
                    <div class="col p-4">
                        <h5>Setup new</h5>
                        <h3 class="text-primary fw-bold">Password</h3>
                        <hr>
                        <form @submit.prevent="submit">
                            <input type="hidden" :class="[{ 'is-invalid': form.errors.email, 'form-control': true, 'is-valid': status }]" v-model="form.email">
                            <p class="text-danger">{{ form.errors.email }}</p>
                            <div class="mt-4">
                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <input type="password" autofocus :class="[{ 'is-invalid': form.errors.password, 'form-control': true}]" v-model="form.password" autocomplete="new-password">
                                    <div class="invalid-feedback">{{ form.errors.password }}</div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <div class="mb-3">
                                    <label class="form-label">Confirm Password</label>
                                    <input type="password" :class="[{ 'is-invalid': form.errors.password_confirmation, 'form-control': true}]" v-model="form.password_confirmation" autocomplete="new-password">
                                    <div class="invalid-feedback">{{ form.errors.password_confirmation }}</div>
                                </div>
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <div class="row ps-2 pe-2">
                                    <button type="submit" :class="[{ 'btn': true, 'btn-primary': true, 'loading': form.processing }]">
                                        <div v-if="form.processing">
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                            Set Password
                                        </div>
                                        <span v-else>Set Password</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>
