<template>
    <div class="twitter">
        <a :href="'https://twitter.com/' + username" target="_blank">
            <img :src=" url + '/assets/icon/twitter.svg'" alt="tw">
        </a>
    </div>
</template>

<script>
    export default {
        props: ['url', 'username']
    }
</script>
