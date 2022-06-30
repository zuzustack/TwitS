<template>
    <div class="modal" id="ShareModal" v-on:click="reset" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Link Post</h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex">
                        <p
                            ref="text"
                            v-on:click="copy"
                            class="text-link text-success"
                        >
                            {{ link }}
                        </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <p class="me-5 text-muted">{{ status }}</p>
                    <button
                        type="button"
                        class="btn btn-primary"
                        v-on:click="copy"
                    >
                        Copy
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            status: "",
            link: "",
            id: "",
        };
    },

    methods: {
        show(s, id) {
            this.link = "http://127.0.0.1:8000/sharing/" + s;
            this.id = id;
            console.log(this.link);
        },

        async copy() {
            navigator.clipboard.writeText(this.link);

            await axios
                .post("http://127.0.0.1:8000/api/add/share/" + this.id)
                .then((response) => {
                    this.status = "Link copied to clipboard";
                    this.$router.go();
                });

            setTimeout(() => {
                this.status = "";
            }, 2500);
        },
    },
};
</script>

<style>
.text-link {
    margin: 0;
    font-size: 14px;
    font-weight: bold;
    line-height: 38px;
    cursor: pointer;
}
</style>
