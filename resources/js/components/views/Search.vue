<template>
    <div class="container mt-4">
        <div class="input-group mb-3 w-50 mx-auto">
            <input
                v-model="s"
                type="text"
                name="s"
                class="form-control"
                placeholder="Cari Postingan..."
                aria-label="Recipient's username"
                aria-describedby="button-addon2"
            />
            <button
                v-on:click="search"
                class="btn btn-outline-secondary"
                id="button-addon2"
            >
                Cari
            </button>
        </div>

        <hr />

        <div v-show="submit">
            <h3 class="text-muted">Cari {{ keySearch }}</h3>
            <div>
                <Post ref="getPost" />
            </div>
        </div>
        <div v-if="!submit">
            <h3 class="text-muted">Postingan Terbaru</h3>
        </div>
    </div>
</template>

<script>
import Post from "../partials/Post.vue";

export default {
    components: {
        Post,
    },

    mounted() {
        if (this.$route.query.s) {
            this.s = this.$route.query.s;
            this.search();
        }
    },

    data() {
        return {
            post: [],
            submit: false,
            keySearch: "",
        };
    },

    methods: {
        search() {
            this.submit = true;
            this.keySearch = this.s;
            this.$refs.getPost.getPost(this.s);
        },
    },
};
</script>

<style></style>
