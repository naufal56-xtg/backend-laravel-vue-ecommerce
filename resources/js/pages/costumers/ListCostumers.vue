<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h2 class="fw-bold py-3 mb-4">Halaman Pelanggan</h2>

        <div class="card">
            <div class="card-header text-center">
                <h4>Daftar Data Pelanggan</h4>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <!-- <button v-if="selectedProduct.length > 0" @click.prevent="bulkDelete"
                            class="btn btn-danger btn-select">
                            Hapus Produk
                        </button> -->
                        <!-- <span class="cate-select">Total Pilih Kategori : {{ selectedProduct.length }}</span> -->
                    </div>

                    <div>
                        <input type="text" v-model="searchQuery" class="form-control"
                            placeholder="Search Nama Pelanggan/No Telp">
                    </div>
                </div>

                <table class="table table-hover table-bordered mt-3 text-center">
                    <thead>
                        <tr>
                            <!-- <th>
                                #
                            </th> -->
                            <th>No</th>
                            <th>Nama Pelanggan</th>
                            <th>Email</th>
                            <th>No Handphone</th>
                            <th>Tanggal Lahir</th>
                            <th>Foto Profile</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody v-if="users.data.length > 0">
                        <tr v-for="(user, index) in users.data" :key="user.id">
                            <!-- <td>
                                <input type="checkbox" class="form-check-input" :checked="selectAll"
                                    @change="toggleSelect(user)" />
                            </td> -->
                            <td>
                                {{ index + users.from }}
                            </td>
                            <td>{{ user.nama_lengkap }}</td>
                            <td>{{ user.email }}</td>
                            <td>{{ user.no_telp ?? '-' }}</td>
                            <td>{{ user.tanggal_lahir ?? '-' }}</td>
                            <td>
                                <div v-if="user.foto_profile">
                                    <img :src="'http://localhost:8000/images/costumers/' + user.foto_profile" alt=""
                                        class="img-foto">
                                </div>
                                <div v-else>
                                    -
                                </div>
                            </td>
                            <td>
                                <!-- <button type="button" @click.prevent="deleteProduct(user)"
                                    class="btn btn-icon btn-danger btn-delete">
                                    <span class="tf-icons mdi mdi-trash-can-outline"></span>
                                </button> -->
                                <button type="button" @click.prevent="getUserDetail(user)"
                                    class="btn btn-icon btn-success btn-detail">
                                    <span class="tf-icons mdi mdi-eye-circle"></span>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                    <tbody v-else>
                        <tr>
                            <td colspan="9">Data Pelanggan Kosong</td>
                        </tr>
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    <Bootstrap5Pagination class="mt-3" :data="users" @pagination-change-page="getUsers" />
                </div>
            </div>
        </div>
    </div>

    <DetailUser :data="data"></DetailUser>
</template>

<script setup>
import axios from 'axios';
import { onMounted, reactive, ref, watch } from 'vue';
import { debounce } from "lodash";
import { Bootstrap5Pagination } from 'laravel-vue-pagination';
import DetailUser from "../../components/DetailUser.vue";
let searchQuery = ref(null);
let users = ref({
    'data': [],
});

let data = reactive({
    nama_lengkap: '',
    email: '',
    alamat: '',
    no_telp: '',
    jk: '',
    foto_profile: null,
    tanggal_lahir: '',
});

const getUserDetail = (user) => {
    $('#modal-detail-user').modal('show');
    axios.get(`/api/users/detail/${user.id}`).then((response) => {
        data.nama_lengkap = response.data[0].nama_lengkap;
        data.email = response.data[0].email;
        data.alamat = response.data[0].alamat;
        data.no_telp = response.data[0].no_telp;
        data.jk = response.data[0].jk;
        data.foto_profile = response.data[0].foto_profile;
        data.tanggal_lahir = response.data[0].tanggal_lahir;
    }).catch((error) => {
        console.log(error);
    });
}

const getUsers = (page = 1) => {
    axios.get(`/api/users/?page=${page}`, {
        params: {
            query: searchQuery.value,
        }
    }).then((response) => {
        users.value = response.data
    }).catch((error) => {
        console.log(error);
    });
}

watch(searchQuery, debounce(() => {
    getUsers();
}, 500));

onMounted(() => {
    getUsers();
})

</script>

<style  scoped>
.btn-delete {
    margin-left: 10px !important;
    margin-right: 10px !important;
}

.btn-select {
    margin-left: 10px !important;
}

.cate-select {
    margin-left: 10px !important;
}

.img-preview {
    margin-top: 15px;
    width: 660px;
    height: 300px;
}

.img-foto {
    width: 100px;
    height: 50px;
}
</style>
