<template>
    <div>
        <div class="modal fade" id="modal-detail-user" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-simple modal-edit-user">
                <div class="modal-content p-3 p-md-5">
                    <div class="modal-body py-3 py-md-0">
                        <button type="button" class="btn-close" @click.prevent="closeForm"></button>
                        <div class="text-center mb-4">
                            <h3 class="mb-2">Pelanggan Detail : ({{ props.data.nama_lengkap }})</h3>
                        </div>

                        <table class="table table-bordered mt-3">
                            <thead class="text-left">
                                <tr>
                                    <th>Nama Pelanggan :</th>
                                    <td>{{ props.data.nama_lengkap }}</td>
                                </tr>
                                <tr>
                                    <th>Email :</th>
                                    <td>
                                        {{ props.data.email }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>No Handphone : </th>
                                    <td>{{ props.data.no_telp ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Lahir :</th>
                                    <td>{{ props.data.tanggal_lahir ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Jenis Kelamin :</th>
                                    <td>
                                        <div v-if="props.data.jk === 'L'">
                                            Laki - Laki
                                        </div>
                                        <div v-else>
                                            Perempuan
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-fp">Foto Profile</th>
                                    <td>
                                        <div v-if="props.data.foto_profile">
                                            <img :src="'http://localhost:8000/images/costumers/' + props.data.foto_profile"
                                                class="img-detail">
                                        </div>
                                        <div v-else>
                                            -
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Alamt</th>
                                    <td>
                                        {{ props.data.alamat ?? '-' }}

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
    data: Object,
});

const closeForm = () => {
    $('#modal-detail-user').modal('hide');
}


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
