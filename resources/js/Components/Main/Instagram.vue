<template>
    <div class="instagram">
        <a :href="target-url" target="_blank">
            <img :src=" url + '/assets/icon/instagram.svg'" alt="ig">
        </a>
    </div>
</template>

<script>
    export default {
        props: ['url', 'target-url']
    }
</script>
