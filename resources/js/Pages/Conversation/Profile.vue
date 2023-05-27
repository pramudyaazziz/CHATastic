<script setup>
    import ProfileLayout from '@/Layouts/ProfileLayout.vue';
    import {Head, Link, useForm, usePage} from '@inertiajs/vue3';
    import {ref} from 'vue';

    const user = usePage().props.user;

    const formPersonalProfile = useForm({
        name: user.name,
        avatar: user.avatar,
        username: user.username,
        phone_number: user.phone_number,
        bio: user.bio,
    });

    const formSocialMedia = useForm({
        facebook: user.platform.facebook,
        twitter: user.platform.twitter,
        instagram: user.platform.instagram,
    })

    const avatar = useForm({
        file: null,
    })

    const mainUrl = usePage().props.ziggy.url;
    const avatarUrl = ref( mainUrl + '/avatars/' + formPersonalProfile.avatar) ;

    const uploadImage = (event) => {
        avatar.file = event.target.files[0];
        avatar.post(route('avatar.update'), {
            onFinish: () => {
                const timestamp = new Date().getTime();
                avatarUrl.value = mainUrl + '/avatars/' + formPersonalProfile.avatar + '?time=' + timestamp;
            }
        });
    }

    const submitPersonalProfile = () => {
        formPersonalProfile.patch(route('update.personal.profile'))
    }

    const submitSocialMedia = () => {
        formSocialMedia.patch(route('update.social.media'))
    }
</script>

<template>
    <Head title="Profile" />
    <ProfileLayout>
            <h4 class="text-center mt-3">Profile</h4>
            <div class="row justify-content-center mt-3">
                <div class="col-7" v-if="$page.props.status">
                    <div class="px-5">
                        <div class="alert alert-success" role="alert">
                            <div>{{ $page.props.status }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-2">
                    <div class="d-flex justify-content-center">
                        <div class="container-image-profile">
                            <img :src="avatarUrl" alt="avatar">
                        </div>
                    </div>
                    <p class="text-center text-danger">{{ avatar.errors.file }}</p>
                    <div class="mt-3 d-flex justify-content-center">
                        <label for="avatar" :class="[{ 'btn btn-primary': true, 'loading': avatar.processing }]">
                            <div v-if="avatar.processing">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Updating...
                            </div>
                            <span v-else>Change Avatar</span>
                        </label>
                        <input type="file" id="avatar" style="display: none;" @change="uploadImage">
                    </div>
                </div>
                <div class="col-md-4 px-5 mt-5 mt-md-0">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Personal Profile</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Social Media</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                            <form action="" @submit.prevent="submitPersonalProfile">
                                <div class="mb-3">
                                    <label for="nameInput" class="form-label">Name</label>
                                    <input type="text" :class="[{ 'is-invalid': formPersonalProfile.errors.name, 'form-control': true }]" id="nameInput" v-model="formPersonalProfile.name" placeholder="Name">
                                    <div class="invalid-feedback">{{ formPersonalProfile.errors.name }}</div>
                                </div>
                                <div class="mb-3">
                                    <label for="usernameInput" class="form-label">Username</label>
                                    <div class="input-group">
                                        <span class="input-group-text">@</span>
                                        <input type="text" :class="[{ 'is-invalid': formPersonalProfile.errors.username, 'form-control': true }]" placeholder="Username" v-model="formPersonalProfile.username" placeolder="Username">
                                        <div class="invalid-feedback">{{ formPersonalProfile.errors.username }}</div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="phoneNumberInput" class="form-label">Phone Number</label>
                                    <input type="text" :class="[{ 'is-invalid': formPersonalProfile.errors.phone_number, 'form-control': true }]" id="phoneNumberInput" v-model="formPersonalProfile.phone_number" placeholder="Phone Number">
                                    <div class="invalid-feedback">{{ formPersonalProfile.errors.phone_number }}</div>
                                </div>
                                <div class="mb-3">
                                    <label for="usernameInput" class="form-label">Bio</label>
                                    <textarea rows="3" :class="[{ 'is-invalid': formPersonalProfile.errors.bio, 'form-control': true }]" v-model="formPersonalProfile.bio"></textarea>
                                    <div class="invalid-feedback">{{ formPersonalProfile.errors.bio }}</div>
                                </div>
                                <button type="submit" class="btn btn-primary">Update Personal Profile</button>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
                            <form action="" @submit.prevent="submitSocialMedia">
                                <div class="mb-3">
                                    <label for="nameInput" class="form-label">Facebook</label>
                                    <input type="text" :class="[{ 'is-invalid': formSocialMedia.errors.facebook, 'form-control': true }]" id="nameInput" v-model="formSocialMedia.facebook" placeholder="Facebook url">
                                    <div class="invalid-feedback">{{ formSocialMedia.errors.facebook }}</div>
                                </div>
                                <div class="mb-3">
                                    <label for="usernameInput" class="form-label">Twitter</label>
                                    <div class="input-group">
                                        <span class="input-group-text">@</span>
                                        <input type="text" :class="[{ 'is-invalid': formSocialMedia.errors.twitter, 'form-control': true }]" placeholder="Username" v-model="formSocialMedia.twitter">
                                        <div class="invalid-feedback">{{ formSocialMedia.errors.twitter }}</div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="usernameInput" class="form-label">Instagram</label>
                                    <div class="input-group">
                                        <span class="input-group-text">@</span>
                                        <input type="text" :class="[{ 'is-invalid': formSocialMedia.errors.instagram, 'form-control': true }]" placeholder="Username" v-model="formSocialMedia.instagram">
                                        <div class="invalid-feedback">{{ formSocialMedia.errors.instagram }}</div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Update Social Media</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <form class="mt-4" @submit.prevent="submit">
                <div class="row m-0">

                    <!-- <div class="col-md-6 px-5">


                    </div> -->

                </div>
            </form>
        <!-- </div> -->
    </ProfileLayout>
</template>
