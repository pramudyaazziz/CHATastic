<template>
    <div class="facebook">
        <a :href="profileUrl" target="_blank">
            <img :src=" url + '/assets/icon/facebook.svg'" alt="fb">
        </a>
    </div>
</template>

<script>
    export default {
        props: ['url', 'profileUrl']
    }
</script>
