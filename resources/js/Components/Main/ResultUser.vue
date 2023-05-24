<template>
    <div class="result-user p-2">
        <div class="avatar" style="width: 50px; height: 50px;">
            <img :src="result.avatar" alt="user_ava">
        </div>
        <div class="user">
            <div class="name">
                <h6>{{ result.name }}</h6>
                <small class="text-muted">@{{ result.username }}</small>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            url: {
                type: String,
                required: true
            },
            result: {
                type: Object,
                required: true
            }
        }
    }
</script>
