<template>
    <div class="facebook">
        <a :href="target-url" target="_blank">
            <img :src=" url + '/assets/icon/facebook.svg'" alt="fb">
        </a>
    </div>
</template>

<script>
    export default {
        props: ['url', 'target-url']
    }
</script>
