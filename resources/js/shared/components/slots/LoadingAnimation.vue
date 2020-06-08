<template>
    <div>
            <span v-if="!loading"> <slot> </slot></span>
            <span v-if="loading"> <i class="fas fa-circle-notch fa-spin"></i> <slot> </slot> </span>

    </div>

</template>

<script>
    export default {
        name: "LoadingAnimation",
        props: {
            loading: {
                type: Boolean,
                default: false
            },
        },
    }
</script>

<style scoped>

</style>
