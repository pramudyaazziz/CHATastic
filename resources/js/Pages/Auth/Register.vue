<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const image = window.location.origin + '/assets/auth/img/welcome.svg';

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <div class="col-md-6 p-5 d-flex align-items-center">
            <img :src="image" alt="welcome" class="img-fluid">
        </div>

        <div class="col-md-6 p-4">
            <div class="card h-100 shadow">
                <div class="card-body d-flex align-items-center">
                    <div class="col p-4">
                        <h5>Register to</h5>
                        <h3 class="text-primary fw-bold">CHATastic</h3>
                        <hr>
                        <p class="text-danger">{{ form.errors.stats }}</p>
                        <form @submit.prevent="submit">
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" :class="[{ 'is-invalid': form.errors.name, 'form-control': true }]" v-model="form.name" autofocus>
                                <div class="invalid-feedback">{{ form.errors.name }}</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email address</label>
                                <input type="email" :class="[{ 'is-invalid': form.errors.email, 'form-control': true }]" v-model="form.email">
                                <div class="invalid-feedback">{{ form.errors.email }}</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" :class="[{ 'is-invalid': form.errors.password, 'form-control': true }]" v-model="form.password">
                                <div class="invalid-feedback">{{ form.errors.password }}</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" :class="[{ 'is-invalid': form.errors.password_confirmation, 'form-control': true }]" v-model="form.password_confirmation">
                                <div class="invalid-feedback">{{ form.errors.password_confirmation }}</div>
                            </div>
                            <div class="row ps-2 pe-2">
                                <button type="submit" class="btn btn-primary">Register</button>
                            </div>
                        </form>
                        <div class="mt-4">
                            <p class="text-center">Already have an account? <Link :href="route('login')">Login</Link></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>
