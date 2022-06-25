<template>
    <div class="card">
        <div class="card-body">
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">
                    Ketik apa yang anda pikirkan
                </label>
                <div class="d-flex">
                    <textarea
                        v-model="caption"
                        class="form-control me-3"
                        id="exampleFormControlTextarea1"
                        rows="3"
                    ></textarea>
                    <div class="w-25">
                        <div
                            class="btn btn-dark w-100 btn-post-form"
                            v-on:click="post"
                        >
                            Posting
                        </div>
                        <p
                            v-if="info"
                            :class="[type ? 'text-success' : 'text-danger']"
                        >
                            {{ message }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            caption: "",
            info: false,
            type: false,
            message: "",
        };
    },
    methods: {
        async post() {
            if (this.caption) {
                await axios
                    .post("http://127.0.0.1:8000/api/add/post", {
                        caption: this.caption,
                        user_id: JSON.parse(localStorage.user).id,
                    })
                    .then((response) => {
                        this.caption = "";
                        this.type = true;
                        this.message = "Postingan Diupload";
                        this.info = true;
                        this.$emit("updatePost");
                    });
            } else {
                this.type = false;
                this.message = "Postingan Kosong";
                this.info = true;
            }
        },
    },
};
</script>

<style>
.btn-post-form {
    max-height: 38px;
}
</style>
