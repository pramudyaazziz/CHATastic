<script setup>
    import Navbar from '@/Components/Navbar.vue';
</script>

<template>
    <div class="container-fluid">
        <div class="row">
            <Navbar></Navbar>
        </div>
        <slot />
    </div>
</template>
