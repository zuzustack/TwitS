<template>
    <h3 class="text-muted">Postingan</h3>
    <div class="container">
        <Post ref="post" />
    </div>
</template>

<script>
import Post from "./Post.vue";
export default {
    mounted() {
        this.$refs.post.userPost(JSON.parse(localStorage.user).id);
    },

    components: {
        Post,
    },
};
</script>

<style></style>
