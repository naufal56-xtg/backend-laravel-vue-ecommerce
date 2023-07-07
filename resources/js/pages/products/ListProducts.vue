<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h2 class="fw-bold py-3 mb-4">Halaman Produk</h2>

        <div class="card">
            <div class="card-header text-center">
                <h4>List Data Produk</h4>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <button class="btn btn-primary" @click.prevent="addProduct">
                            Tambah Produk
                        </button>
                        <!-- <button v-if="selectedCate.length > 0" @click.prevent="bulkDelete"
                            class="btn btn-danger btn-select">
                            Hapus Kategori
                        </button>
                        <span class="cate-select">Total Pilih Kategori : {{ selectedCate.length }}</span> -->
                    </div>

                    <div>
                        <input type="text" v-model="searchQuery" class="form-control" placeholder="Search Nama Kategori">
                    </div>
                </div>

                <table class="table table-hover table-bordered mt-3 text-center">
                    <thead>
                        <tr>
                            <!-- <th>
                                <input type="checkbox" class="form-check-input" v-model="selectAll"
                                    @change="selectAllProducts" />
                            </th> -->
                            <th>No</th>
                            <th>Nama Product</th>
                            <th>Harga</th>
                            <th>Qty</th>
                            <th>Kategori</th>
                            <th>Gambar</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody v-if="products.data.length > 0">
                        <tr v-for="(product, index) in products.data" :key="product.id">
                            <!-- <td>
                                <input type="checkbox" class="form-check-input" :checked="selectAll"
                                    @change="toggleSelect(product)" />
                            </td> -->
                            <td>
                                {{ index + products.from }}
                            </td>
                            <td>{{ product.nama_produk }}</td>
                            <td>Rp. {{ product.harga }}</td>
                            <td>{{ product.qty }}</td>
                            <td>{{ product.category.nama_kategori }}</td>
                            <td>
                                <img :src="'http://localhost:8000/images/' + product.foto_produk" alt="" class="img-foto">
                            </td>
                            <td>
                                <button type="button" @click.prevent="editProduct(product)"
                                    class="btn btn-icon btn-warning">
                                    <span class="tf-icons mdi mdi-pencil-outline"></span>
                                </button>
                                <button type="button" @click.prevent="deleteProduct(product)"
                                    class="btn btn-icon btn-danger btn-delete">
                                    <span class="tf-icons mdi mdi-trash-can-outline"></span>
                                </button>
                                <button type="button" @click.prevent="getProductDetail(product)"
                                    class="btn btn-icon btn-success btn-detail">
                                    <span class="tf-icons mdi mdi-eye-circle"></span>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                    <tbody v-else>
                        <tr>
                            <td colspan="9">Data Product Kosong</td>
                        </tr>
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    <Bootstrap5Pagination class="mt-3" :data="products" @pagination-change-page="getProducts" />
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-product" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-simple modal-edit-user">
            <div class="modal-content p-3 p-md-5">
                <div class="modal-body py-3 py-md-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="text-center mb-4">
                        <h3 v-if="editing" class="mb-2">Form Ubah Data Produk</h3>
                        <h3 v-else class="mb-2">Form Membuat Data Produk</h3>
                    </div>

                    <Form @submit="handleSubmit" v-slot:default="{ errors }" class="row g-4">
                        <div class="col-12 col-md-6">
                            <div class="form-floating form-floating-outline">
                                <input type="text" v-model="form.nama_produk" :class="{ 'is-invalid': errors.nama_produk }"
                                    class="form-control" placeholder="Silahkan Input Nama Kategori" />
                                <label for="nama_produk">Nama Produk</label>
                                <span class="mt-1 invalid-feedback">{{ errors.nama_produk }}</span>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-floating form-floating-outline">
                                <select v-model="form.category_id" :class="{ 'is-invalid': errors.category_id }"
                                    class="form-select">
                                    <option v-for="category in categories" :value="category.id" :key="category.id">{{
                                        category.nama_kategori }}</option>
                                </select>
                                <label for="">Kategori</label>
                                <span class="mt-1 invalid-feedback">{{ errors.category_id }}</span>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-floating form-floating-outline">
                                <input type="number" v-model="form.harga" id="harga" :class="{ 'is-invalid': errors.harga }"
                                    class="form-control" placeholder="Silahkan Input Harga Produk" />
                                <label for="harga">Harga</label>
                                <span class="mt-1 invalid-feedback">{{ errors.harga }}</span>
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="form-floating form-floating-outline">
                                <input type="number" v-model="form.qty" :class="{ 'is-invalid': errors.qty }"
                                    class="form-control" id="qty" placeholder="Silahkan Input Jumlah Produk" />
                                <label for="qty">Qty</label>
                                <span class="mt-1 invalid-feedback">{{ errors.qty }}</span>
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="form-floating form-floating-outline">
                                <input type="number" v-model="form.berat" :class="{ 'is-invalid': errors.berat }"
                                    class="form-control" id="berat" placeholder="Silahkan Input Berat Produk" />
                                <label for="berat">Berat</label>
                                <span class="mt-1 invalid-feedback">{{ errors.berat }}</span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating form-floating-outline">
                                <input type="file" :class="{ 'is-invalid': errors.foto_produk }" @change="uploadFile"
                                    class="form-control" placeholder="Silahkan Input Gambar Produk" />
                                <label for="" class="form-label">Upload Image</label>
                                <span class="mt-1 invalid-feedback">{{ errors.foto_produk }}</span>
                                <!-- <div v-if="editing">
                                    <div v-if="form.foto_produk">
                                        <img :src="'http://localhost:8000/images/' + form.foto_produk" alt=""
                                            class="img-preview">
                                    </div>
                                    <div v-else>
                                        <img :src="previewImage" alt="" class="img-preview">
                                    </div>
                                </div>
                                <div v-else>
                                    <div v-if="form.foto_produk">
                                        <img :src="previewImage" alt="" class="img-preview">
                                    </div>
                                </div> -->
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating form-floating-outline">
                                <textarea v-model="form.deskripsi" name="nama_kategori" class="form-control h-px-200"
                                    placeholder="Silahkan Input Deksripsi Produk" />
                                <label for="nama_kategori">Deskripsi</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" :checked="form.rekomendasi" v-model="form.rekomendasi"
                                    type="checkbox" id="flexSwitchCheckDefault" />
                                <label class="form-check-label" for="flexSwitchCheckDefault">Rekomendasi</label>
                            </div>
                        </div>

                        <div class="col-12 text-center">
                            <button v-if="editing" type="submit" class="btn btn-warning me-sm-3 me-1">Update</button>
                            <button v-else type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                                aria-label="Close">
                                Cancel
                            </button>
                        </div>
                    </Form>

                </div>
            </div>
        </div>
    </div>

    <DetailProduct :form="form"></DetailProduct>
</template>

<script setup>
import axios from 'axios';
import { onMounted, reactive, ref, watch } from 'vue';
import { Form } from "vee-validate";
import { useToastr } from "../../toastr.js";
import Swal from "sweetalert2";
import { debounce } from "lodash";
import { Bootstrap5Pagination } from 'laravel-vue-pagination';
import DetailProduct from '../../components/DetailProduct.vue';

let products = ref(
    {
        'data': []
    }
);

defineEmits(['getProductDetail']);

let categories = ref([]);

let editing = ref(false);

let toastr = useToastr();

let searchQuery = ref(null);

let previewImage = ref(null);

let form = reactive({
    id: '',
    nama_produk: '',
    harga: '',
    berat: '',
    qty: '',
    deskripsi: '',
    rekomendasi: '',
    foto_produk: null,
    category_id: ''
});

const getProductDetail = async (product) => {
    $('#modal-detail-product').modal('show');
    await axios(`/api/products/detail/` + product.id).then((response) => {
        form.nama_produk = response.data.nama_produk;
        form.harga = response.data.harga;
        form.qty = response.data.qty;
        form.berat = response.data.berat;
        form.category_id = response.data.category_id;
        form.foto_produk = response.data.foto_produk;
        form.deskripsi = response.data.deskripsi;
    })
}

const getCategories = async () => {
    await axios.get('/api/categories/data').then((response) => {
        categories.value = response.data;
    }).catch((error) => {
        console.log(error);
    });
}

const getProducts = async (page = 1) => {
    await axios.get(`/api/products/?page=${page}`, {
        params: {
            query: searchQuery.value,
        }
    }).then((response) => {
        products.value = response.data;

    }).catch((error) => {
        console.log(error);
    });
}


// Menangani Upload File

const uploadFile = (e) => {
    form.foto_produk = e.target.files[0];
    previewImage = URL.createObjectURL(form.foto_produk);
}



const handleSubmit = (values, actions) => {
    if (editing.value === true) {
        updateProduct(values, actions);
    } else {
        createProduct(values, actions);
    }
}


// Create Category

const addProduct = () => {
    editing.value = false;
    $('#modal-product').modal('show');

}

const createProduct = async (values, actions) => {

    let formData = new FormData();

    formData.append('nama_produk', form.nama_produk);
    formData.append('berat', form.berat);
    formData.append('harga', form.harga);
    formData.append('qty', form.qty);
    formData.append('deskripsi', form.deskripsi);
    formData.append('rekomendasi', form.rekomendasi);
    formData.append('foto_produk', form.foto_produk);
    formData.append('category_id', form.category_id);

    await axios.post('/api/products/store', formData, {
        Headers: {
            'Content-Type': 'multipart/form-data'
        }
    }).then((response) => {
        getProducts();
        $('#modal-product').modal('hide');
        toastr.success(response.data.msg);
        form.nama_produk = '';
        form.harga = 0;
        form.qty = 0;
        form.berat = 0;
        form.deskripsi = '';
        form.foto_produk = null;
        form.rekomendasi = false;
        form.category_id = '';
        previewImage = null;
    }).catch((error) => {
        actions.setErrors(error.response.data.errors);
        // if (error.response.data.errors) {
        //     setFieldError('nama_kategori', error.response.data.errors.nama_kategori[0]);
        // }
        // console.log(error);
    });
}


// Edit Produk

const editProduct = (product) => {
    editing.value = true;
    form.id = product.id;
    form.nama_produk = product.nama_produk;
    form.harga = product.harga;
    form.berat = product.berat;
    form.qty = product.qty;
    form.deskripsi = product.deskripsi;
    form.foto_produk = product.foto_produk;
    form.category_id = product.category_id;
    form.rekomendasi = product.rekomendasi;
    $('#modal-product').modal('show');

}

// Update Produk

const updateProduct = async (values, actions) => {
    let formData = new FormData();
    formData.append('nama_produk', form.nama_produk);
    formData.append('berat', form.berat);
    formData.append('harga', form.harga);
    formData.append('qty', form.qty);
    formData.append('deskripsi', form.deskripsi);
    formData.append('rekomendasi', form.rekomendasi);
    formData.append('foto_produk', form.foto_produk);
    formData.append('category_id', form.category_id);
    // console.log(form.foto_produk);
    await axios.post('/api/products/update/' + form.id, formData, {
        Headers: {
            'Content-Type': 'multipart/form-data'
        }
    }).then((response) => {
        getProducts();
        $('#modal-product').modal('hide');
        toastr.success(response.data.msg);
    }).catch((error) => {
        actions.setErrors(error.response.data.errors);
        console.log(error);
    });
}

// Delete Produk

const deleteProduct = (product) => {
    Swal.fire({
        title: 'Apakah Kamu Yakin Ingin Hapus Produk Ini ?',
        text: "Menghapus Produk : " + product.nama_produk,
        icon: 'warning',
        showCancelButton: true,
        cancelButtonColor: '#d33',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Yakin, Hapus Produk'
    }).then(async (result) => {
        if (result.isConfirmed) {
            await axios.delete(`/api/products/delete/${product.id}`).then((response) => {
                getProducts();
                toastr.success(response.data.msg);
            });

        }
    });
}




watch(searchQuery, debounce(() => {
    getProducts();
}, 500));

onMounted(() => {
    getCategories();
    getProducts();
});

</script>

<style scoped>
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
