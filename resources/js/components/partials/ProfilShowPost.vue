<template>
    <h3 class="text-muted">Postingan</h3>
    <div class="container">
        <Post ref="post" :showForm="showForm" :showOption="showOption" />
    </div>
</template>

<script>
import Post from "./Post.vue";
export default {
    props: ["showForm", "id", "backPath", "showOption"],
    mounted() {
        this.loadPost();
        console.log([this.$props.id, this.$route.params.username]);
    },

    watch: {
        "this.$props.id"() {
            this.loadPost();
        },
    },

    methods: {
        loadPost() {
            this.$refs.post.userPost(this.$props.id);
        },
    },

    components: {
        Post,
    },
};
</script>

<style></style>
