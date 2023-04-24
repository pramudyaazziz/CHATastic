<script setup>
    import MainLayout from '@/Layouts/MainLayout.vue';
    import {Head, Link, useForm, usePage} from '@inertiajs/vue3';
    import {ref} from 'vue';

    const user = usePage().props.user;

    const form = useForm({
        name: user.name,
        avatar: user.avatar,
        username: user.username,
        phone_number: user.phone_number,
        bio: user.bio,
        facebook: user.platform.facebook,
        twitter: user.platform.twitter,
        instagram: user.platform.instagram,
    });

    const avatar = useForm({
        file: null,
    })

    const mainUrl = usePage().props.ziggy.url;
    const avatarUrl = ref( mainUrl + '/avatars/' + form.avatar) ;

    const uploadImage = (event) => {
        avatar.file = event.target.files[0];
        avatar.post(route('avatar.update'), {
            onFinish: () => {
                const timestamp = new Date().getTime();
                avatarUrl.value = mainUrl + '/avatars/' + form.avatar + '?time=' + timestamp;
            }
        });
    }

    const submit = () => {
        form.patch(route('update.profile'))
    }
</script>

<template>
    <Head title="Profile" />
    <MainLayout>
        <div class="profile">
            <div class="row">
                <div class="col">
                    <div class="mt-4 d-flex justify-content-center">
                        <div class="container-image-profile">
                            <img :src="avatarUrl" alt="">
                        </div>
                    </div>
                    <p class="text-center text-danger">{{ avatar.errors.file }}</p>
                    <div class="mt-3 d-flex justify-content-center">
                        <label for="avatar" class="btn btn-primary">
                            <div v-if="avatar.processing">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Updating...
                            </div>
                            <span v-else>Change Avatar</span>

                        </label>
                        <input type="file" id="avatar" style="display: none;" @change="uploadImage">
                    </div>
                </div>
            </div>
            <form class="mt-4" @submit.prevent="submit">
                <div class="row m-0">
                    <div class="px-5" v-if="$page.props.status" >
                        <div class="alert alert-success alert-dismissible" role="alert">
                           <div>{{ $page.props.status }}</div>
                           <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                    <div class="col-md-6 px-5">
                        <div class="mb-3">
                            <label for="nameInput" class="form-label">Name</label>
                            <input type="text" :class="[{ 'is-invalid': form.errors.name, 'form-control': true }]" id="nameInput" v-model="form.name" placeholder="Name">
                            <div class="invalid-feedback">{{ form.errors.name }}</div>
                        </div>
                        <div class="mb-3">
                            <label for="usernameInput" class="form-label">Username</label>
                            <div class="input-group">
                                <span class="input-group-text">@</span>
                                <input type="text" :class="[{ 'is-invalid': form.errors.username, 'form-control': true }]" placeholder="Username" v-model="form.username" placeolder="Username">
                                <div class="invalid-feedback">{{ form.errors.username }}</div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="phoneNumberInput" class="form-label">Phone Number</label>
                            <input type="text" :class="[{ 'is-invalid': form.errors.phone_number, 'form-control': true }]" id="phoneNumberInput" v-model="form.phone_number" placeholder="Phone Number">
                            <div class="invalid-feedback">{{ form.errors.phone_number }}</div>
                        </div>
                        <div class="mb-3">
                            <label for="usernameInput" class="form-label">Bio</label>
                            <textarea rows="3" :class="[{ 'is-invalid': form.errors.bio, 'form-control': true }]" v-model="form.bio"></textarea>
                            <div class="invalid-feedback">{{ form.errors.bio }}</div>
                        </div>
                    </div>
                    <div class="col-md-6 px-5">
                        <h3 class="mb-3">Link another platform</h3>
                        <div class="mb-3">
                            <label for="nameInput" class="form-label">Facebook</label>
                            <input type="text" :class="[{ 'is-invalid': form.errors.facebook, 'form-control': true }]" id="nameInput" v-model="form.facebook" placeholder="Facebook url">
                            <div class="invalid-feedback">{{ form.errors.facebook }}</div>
                        </div>
                        <div class="mb-3">
                            <label for="usernameInput" class="form-label">Twitter</label>
                            <div class="input-group">
                                <span class="input-group-text">@</span>
                                <input type="text" :class="[{ 'is-invalid': form.errors.twitter, 'form-control': true }]" placeholder="Username" v-model="form.twitter">
                                <div class="invalid-feedback">{{ form.errors.twitter }}</div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="usernameInput" class="form-label">Instagram</label>
                            <div class="input-group">
                                <span class="input-group-text">@</span>
                                <input type="text" :class="[{ 'is-invalid': form.errors.instagram, 'form-control': true }]" placeholder="Username" v-model="form.instagram">
                                <div class="invalid-feedback">{{ form.errors.instagram }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center my-3">
                        <button type="submit" class="btn btn-primary w-25 mx-3">Update</button>
                        <Link :href="route('home')" class="btn btn-danger w-25 mx-3" type="button">Back</Link>
                    </div>
                </div>
            </form>
        </div>
    </MainLayout>
</template>
