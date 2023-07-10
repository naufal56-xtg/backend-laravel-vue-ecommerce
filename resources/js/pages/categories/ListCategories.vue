<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h2 class="fw-bold py-3 mb-4">Halaman Kategori</h2>

        <div class="card">
            <div class="card-header text-center">
                <h4>Daftar Data Kategori</h4>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <button class="btn btn-primary" @click.prevent="addCategory">
                            Tambah Kategori
                        </button>
                        <button v-if="selectedCate.length > 0" @click.prevent="bulkDelete"
                            class="btn btn-danger btn-select">
                            Hapus Kategori
                        </button>
                        <span class="cate-select">Total Pilih Kategori : {{ selectedCate.length }}</span>
                    </div>

                    <div>
                        <input type="text" v-model="searchQuery" class="form-control" placeholder="Search Nama Kategori">
                    </div>
                </div>

                <table class="table table-hover table-bordered mt-3 text-center">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" class="form-check-input" v-model="selectAll"
                                    @change="selectAllCategories" />
                            </th>
                            <th>No</th>
                            <th>Nama Kategori</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody v-if="categories.data.length > 0">
                        <tr v-for="(category, index) in categories.data" :key="category.id">
                            <td>
                                <input type="checkbox" class="form-check-input" :checked="selectAll"
                                    @change="toggleSelect(category)" />
                            </td>
                            <td>
                                {{ index + categories.from }}
                            </td>
                            <td>{{ category.nama_kategori }}</td>
                            <td>
                                <button type="button" @click.prevent="editCategory(category)"
                                    class="btn btn-icon btn-warning">
                                    <span class="tf-icons mdi mdi-pencil-outline"></span>
                                </button>
                                <button type="button" @click.prevent="deleteCategory(category)"
                                    class="btn btn-icon btn-danger btn-delete">
                                    <span class="tf-icons mdi mdi-trash-can-outline"></span>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                    <tbody v-else>
                        <tr>
                            <td colspan="4">Data Kategori Kosong</td>
                        </tr>
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    <Bootstrap5Pagination class="mt-3" :data="categories" @pagination-change-page="getCategories" />
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editUser" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-simple modal-edit-user">
            <div class="modal-content p-3 p-md-5">
                <div class="modal-body py-3 py-md-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="text-center mb-4">
                        <h3 v-if="editing" class="mb-2">Form Ubah Data Kategori</h3>
                        <h3 v-else class="mb-2">Form Membuat Data Kategori</h3>
                    </div>
                    <Form ref="from" @submit="handleSubmit" v-slot="{ errors }" class="row g-4" :initial-values="formValues"
                        :validation-schema="createCategorySchema">
                        <div class="col-12">
                            <div class="form-floating form-floating-outline">
                                <Field type="text" id="nama_kategori" :class="{ 'is-invalid': errors.nama_kategori }"
                                    name="nama_kategori" class="form-control" placeholder="Silahkan Input Nama Kategori" />
                                <label for="nama_kategori">Nama Kategori</label>
                                <span class="mt-1 invalid-feedback">{{ errors.nama_kategori }}</span>
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
</template>

<script setup>
import axios from 'axios';
import { onMounted, ref, watch } from 'vue';
import { Form, Field } from "vee-validate";
import * as yup from "yup";
import { useToastr } from "../../toastr.js";
import Swal from "sweetalert2";
import { debounce } from "lodash";
import { Bootstrap5Pagination } from 'laravel-vue-pagination';


let categories = ref(
    {
        'data': []
    }
);

let editing = ref(false);

let formValues = ref();

let toastr = useToastr();

let searchQuery = ref(null);

let selectedCate = ref([]);

let selectAll = ref(false);

const getCategories = async (page = 1) => {
    await axios.get(`/api/categories/?page=${page}`, {
        params: {
            query: searchQuery.value,
        }
    }).then((response) => {
        categories.value = response.data;
        selectedCate.value = [];
        selectAll.value = false;
    }).catch((error) => {
        console.log(error);
    });
}

const handleSubmit = (values, actions) => {
    if (editing.value === true) {
        updateCategory(values, actions);
    } else {
        createCategory(values, actions);
    }
}

// Create Category

const addCategory = () => {
    editing.value = false;
    formValues.value = {
        nama_kategori: '',
    }
    $('#editUser').modal('show');
}

const createCategorySchema = yup.object().shape({
    nama_kategori: yup.string().required('Form Input Kategori Tidak Boleh Kosong'),
});

const createCategory = async (values, { resetForm, setFieldError }) => {
    await axios.post('/api/categories/store', values).then((response) => {
        getCategories();
        $('#editUser').modal('hide');
        toastr.success(response.data.msg);
        resetForm();
    }).catch((error) => {
        if (error.response.data.errors) {
            setFieldError('nama_kategori', error.response.data.errors.nama_kategori[0]);
        }
    });
}

// Edit Category

const editCategory = (category) => {
    editing.value = true
    $('#editUser').modal('show');
    formValues.value = {
        id: category.id,
        nama_kategori: category.nama_kategori,
    }
}

const updateCategory = async (values, { setFieldError }) => {
    await axios.put(`/api/categories/update/${formValues.value.id}`, values).then((response) => {
        getCategories();
        toastr.success(response.data.msg);
        $('#editUser').modal('hide');
    }).catch((error) => {
        if (error.response.data.errors) {
            setFieldError('nama_kategori', error.response.data.errors.nama_kategori[0]);
        }
        toastr.error(error);
    });
}

// Delete Category

const deleteCategory = (category) => {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then(async (result) => {
        if (result.isConfirmed) {
            await axios.delete(`/api/categories/delete/${category.id}`).then((response) => {
                getCategories();
                toastr.success(response.data.msg);
            });

        }
    });
}

// Select Checkbox

const toggleSelect = (category) => {
    const index = selectedCate.value.indexOf(category.id);
    if (index === -1) {
        selectedCate.value.push(category.id);
    } else {
        selectedCate.value.splice(index, 1);
    }
    console.log(selectedCate.value);
}

// Bulk Delete

const bulkDelete = async () => {
    await axios.delete('/api/categories', {
        data: {
            ids: selectedCate.value,
        }
    }).then((response) => {
        getCategories();
        selectedCate.value = [];
        selectAll.value = false;
        toastr.success(response.data.msg);
    }).catch((error) => {
        console.log(error);
    });
}

// Delete Selected All Category

let selectAllCategories = () => {
    if (selectAll.value) {
        selectedCate.value = categories.value.data.map(category => category.id);
    } else {
        selectedCate.value = [];
    }
}


watch(searchQuery, debounce(() => {
    getCategories();
}, 500));

onMounted(() => {
    getCategories();

});

</script>

<style scoped>
.btn-delete {
    margin-left: 10px !important;
}

.btn-select {
    margin-left: 10px !important;
}

.cate-select {
    margin-left: 10px !important;
}
</style>
