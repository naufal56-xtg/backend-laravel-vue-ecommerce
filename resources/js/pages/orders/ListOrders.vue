<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h2 class="fw-bold py-3 mb-4">Halaman Pesanan</h2>


        <div class="card">
            <div class="card-header text-center">
                <h4>Daftar Pesanan</h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No Pesanan</th>
                            <th>Jumlah</th>
                            <th>Total Bayar</th>
                            <th>Status Pemesanan</th>
                            <th>Tanggal Pesanan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(order, index) in orders.data" :key="order.id">
                            <td>{{ index + 1 }}</td>
                            <td>{{ order.no_pesanan ?? '-' }}</td>
                            <td>{{ order.qty ?? '-' }}</td>
                            <td>{{ order.total ?? '-' }}</td>
                            <td>{{ order.status_pesanan ?? '-' }}</td>
                            <td>
                                <button type="button" @click.prevent="getOrderDetail(order)"
                                    class="btn btn-icon btn-success btn-detail">
                                    <span class="tf-icons mdi mdi-eye-circle"></span>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</template>

<script setup>
import axios from 'axios';
import { onMounted } from 'vue';
import { ref } from 'vue';


let orders = ref({
    'data': [],
});

const getOrders = () => {
    axios.get('/api/orders').then((response) => {
        orders.value = response.data;
    }).catch((error) => {
        console.log(error);
    });
}


onMounted(() => {
    getOrders();
});
</script>

<style lang="scss" scoped></style>
