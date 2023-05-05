<template>
    <div class="message mb-3">
        <div :class="[{'not-my-message': message.to_id == user.id, 'is-my-message': message.from_id == user.id}]">
            <div :class="[{'message-content p-2': true, 'bg-white': message.to_id == user.id, 'bg-primary': message.from_id == user.id}]">
                {{ message.body }}
            </div>
        </div>
        <p class="message-time my-1">{{ message.created_at }}</p>
    </div>
</template>

<script>
    export default {
        props: {
            message: {
                type: Object,
                required: true
            },
            user: {
                type: Object,
                required: true
            }
        }
    }
</script>
