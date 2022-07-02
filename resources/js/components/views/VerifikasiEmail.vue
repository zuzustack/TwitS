<template>
    <div class="container mt-3">
        <h3>Verifikasi Email</h3>
        <div class="container w-50">
            <div class="d-flex">
                <p>
                    Belum menerima confirmasi email?
                    <span class="text-primary cursor-pointer">kirim email</span>
                </p>
            </div>
            <div class="input-group mx-auto w-100 mb-3">
                <input
                    type="text"
                    class="form-control"
                    placeholder="Confirm Email"
                    aria-label="Confirm Email"
                    aria-describedby="button-addon2"
                />
                <button
                    class="btn btn-outline-primary"
                    type="button"
                    id="button-addon2"
                >
                    Confirm
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {};
</script>

<style>
.cursor-pointer {
    cursor: pointer;
}
</style>
