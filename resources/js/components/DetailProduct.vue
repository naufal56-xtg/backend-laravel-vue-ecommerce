<template>
    <div>
        <div class="modal fade" id="modal-detail-product" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-simple modal-edit-user">
                <div class="modal-content p-3 p-md-5">
                    <div class="modal-body py-3 py-md-0">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="text-center mb-4">
                            <h3 class="mb-2">Product Detail : ({{ props.data.nama_produk }})</h3>
                        </div>

                        <table class="table table-bordered mt-3">
                            <thead class="text-left">
                                <tr>
                                    <th>Nama Produk :</th>
                                    <td>{{ props.data.nama_produk }}</td>
                                </tr>
                                <tr>
                                    <th>Kategori</th>
                                    <td>
                                        {{ props.data.category_id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Harga : </th>
                                    <td>Rp. {{ props.data.harga }}</td>
                                </tr>
                                <tr>
                                    <th>Qty (Jumlah) :</th>
                                    <td>{{ props.data.qty }}</td>
                                </tr>
                                <tr>
                                    <th>Berat</th>
                                    <td>{{ props.data.berat }} (GRAM)</td>
                                </tr>
                                <tr>
                                    <th class="text-fp">Foto Produk</th>
                                    <td>
                                        <img :src="'http://localhost:8000/images/' + props.data.foto_produk"
                                            class="img-detail">
                                    </td>
                                </tr>
                                <tr>
                                    <th>Deskripsi</th>
                                    <td>
                                        {{ props.data.deskripsi }}

                                    </td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>

const props = defineProps({
    data: Array,
});


</script>

<style scoped>
.img-detail {
    width: 300px;
    height: 150px;
}

.text-fp {
    padding-bottom: 80px !important;
}
</style>
