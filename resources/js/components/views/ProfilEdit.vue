<template>
    <div class="container w-75 mt-3">
        <div v-if="message" class="alert alert-success" role="alert">
            Account Has Changed
        </div>

        <h3 class="">Edit Profil</h3>
        <div class="container">
            <div class="mb-3">
                <label for="formFile" class="form-label">
                    Change Photo Profil
                </label>
                <input
                    class="form-control"
                    @change="uploadImage"
                    type="file"
                    id="formFile"
                />
            </div>

            <div class="form-floating mb-3">
                <input
                    v-model="name"
                    type="email"
                    class="form-control"
                    id="floatingInput"
                    placeholder="name@example.com"
                />
                <label for="floatingInput">Nama</label>
            </div>
            <div class="form-floating mb-3">
                <input
                    v-model="bio"
                    type="email"
                    class="form-control"
                    id="floatingInput"
                    placeholder="name@example.com"
                />
                <label for="floatingInput">Bio</label>
            </div>

            <div class="btn btn-primary me-3" v-on:click="upload">Edit</div>
            <router-link to="/profil" class="btn btn-primary">
                Kembali
            </router-link>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            message: false,
        };
    },

    beforeMount() {
        this.name = JSON.parse(localStorage.user).name;
        this.bio = JSON.parse(localStorage.user).bio;
    },

    methods: {
        uploadImage(e) {
            this.image = e.target.files[0];
        },

        async upload() {
            let data = new FormData();
            data.append("image", this.image);
            data.append("name", this.name);
            data.append("bio", this.bio);
            await axios
                .post("http://127.0.0.1:8000/api/upload/image", data, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then((response) => {
                    this.message = response.data.message;
                });

            this.$router.go();
        },
    },
};
</script>

<style></style>
