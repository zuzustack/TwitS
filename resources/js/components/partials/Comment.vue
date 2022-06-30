<template>
    <div
        class="offcanvas offcanvas-end"
        tabindex="-1"
        id="offcanvasRight"
        aria-labelledby="offcanvasRightLabel"
    >
        <div v-if="showContent">
            <div class="offcanvas-header">
                <div class="profil d-flex">
                    <img
                        class="rounded-circle profil-picture me-3"
                        :src="'/' + post.user.image"
                        alt=""
                    />
                    <div>
                        <h5 class="offcanvas-title" id="offcanvasRightLabel">
                            {{ post.user.name }}
                        </h5>
                        <h6 class="text-muted">{{ post.user.username }}</h6>
                    </div>
                </div>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="offcanvas"
                    aria-label="Close"
                ></button>
            </div>
            <div class="offcanvas-body pt-0">
                <div class="content-comment">
                    <div class="caption">{{ post.caption }}</div>
                    <!-- Action -->
                    <div class="action-user d-flex mt-3">
                        <div
                            v-if="liked"
                            v-on:click="like(post.id, index)"
                            :class="['love d-flex m-0 logo me-3', status_text]"
                        >
                            <IconFullLike class="me-1" />
                            <small class=""> {{ post.likes_count }} </small>
                        </div>
                        <div
                            v-else
                            v-on:click="like(post.id, index)"
                            :class="['love d-flex m-0 logo me-3', status_text]"
                        >
                            <IconLike />
                            <small class=""> {{ post.likes_count }} </small>
                        </div>
                        <div
                            v-on:click="share(post.slug, post.id)"
                            data-bs-toggle="modal"
                            data-bs-target="#ShareModal"
                            class="love d-flex m-0 logo text-primary"
                        >
                            <IconShare />
                            <small class=""> {{ post.share }} </small>
                        </div>
                    </div>
                </div>
                <hr />
                <div class="comment-section">
                    <div
                        v-if="post.comments.length > 0"
                        class="comment container"
                        v-for="comment in post.comments"
                    >
                        <div class="d-flex container mb-0">
                            <img
                                :src="'/' + comment.user.image"
                                alt=""
                                class="rounded-circle comment-profile me-2"
                            />
                            <div class="body">
                                <h5 class="mb-0">{{ comment.user.name }}</h5>
                                <p>{{ comment.body }}</p>
                            </div>
                        </div>
                        <hr class="mt-0" />
                    </div>
                    <div v-else class="no-comment">
                        <p class="text-center">No Comment</p>
                    </div>
                </div>

                <hr />

                <div class="comment-post">
                    <div class="input-group mb-3">
                        <input
                            v-model="body"
                            type="text"
                            class="form-control"
                            placeholder="Berkomentar sebagai..."
                            aria-label="Recipient's username"
                            aria-describedby="button-addon2"
                        />
                        <button
                            class="btn btn-outline-secondary"
                            type="button"
                            id="button-addon2"
                            v-on:click="addComment"
                        >
                            Kirim
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import IconShare from "../icons/IconShare.vue";
import ModalShare from "./ModalShare.vue";
import IconLike from "../icons/IconLike.vue";
import IconFullLike from "../icons/IconFullLike.vue";

export default {
    data() {
        return {
            isDelay: false,
            status_text: "text-danger",
            body: "",
            liked: "",
            index: "",
            id: "",
            post: "",
            showContent: false,
        };
    },
    components: {
        IconShare,
        ModalShare,
        IconFullLike,
        IconLike,
    },

    methods: {
        show(id, index, liked, post, show) {
            this.id = id;
            this.index = index;
            this.liked = liked;
            this.post = post;
            this.showContent = show;
        },
        share(s, id) {
            this.$emit("showShare", s, id);
        },

        like() {
            if (!this.isDelay) {
                if (this.liked && !this.isDelay) {
                    this.post.likes_count -= 1;
                    this.liked = false;
                } else {
                    this.liked = true;
                    this.post.likes_count += 1;
                }

                this.$emit("like", this.id, this.index);
                this.status_text = "text-secondary";
                this.isDelay = true;
            }

            setTimeout(() => {
                this.isDelay = false;
                this.status_text = "text-danger";
            }, 900);
        },
        async addComment() {
            if (this.body) {
                await axios
                    .post("http://127.0.0.1:8000/api/add/comment", {
                        body: this.body,
                        user_id: JSON.parse(localStorage.user).id,
                        post_id: this.post.id,
                    })
                    .then((response) => {
                        this.body = "";
                        this.post.comments = response.data;
                    });

                this.$emit("incComment", this.index);
            }
        },
    },
};
</script>

<style>
.comment-profile {
    width: 35px;
    height: 35px;
}

.comment-section {
    display: block;
    height: 325px;
    overflow: scroll;
}
</style>
