<template>
    <svg
        xmlns="http://www.w3.org/2000/svg"
        :width="value"
        :height="value"
        fill="currentColor"
        class="bi bi-three-dots-vertical"
        viewBox="0 0 16 16"
    >
        <path
            d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"
        />
    </svg>
</template>

<script>
export default {
    props: {
        value: {
            type: Number,
            default: 16,
        },
    },
};
</script>

<style></style>
