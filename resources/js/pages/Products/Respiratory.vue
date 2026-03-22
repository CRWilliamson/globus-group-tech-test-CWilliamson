<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import Header from '@/components/Header.vue';

import { onMounted, ref } from 'vue'
import axios from 'axios'

const products = ref([])
const pagination = ref(null)
const loading = ref(false)
const search = ref('')

async function fetchProducts(page = 1) {
  loading.value = true

  try {
    const response = await axios.get('/api/productType/3/products', {
      params: {
        page,
        search: search.value,
      },
    })

    products.value = response.data.data.products.data
    pagination.value = {
      current_page: response.data.data.products.current_page,
      last_page: response.data.data.products.last_page,
      total: response.data.data.products.total,
    }
  } catch (error) {
    console.error('Failed to load products', error)
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  fetchProducts()
})
</script>

<template>
    <Head title="Respiratory Protection">
        <link rel="stylesheet" href="https://use.typekit.net/tmb4lmh.css" />
    </Head>

    <div class="page">
        <!-- Header -->
        <Header />

        <!-- Content -->
        <main class="main-content">
            <div class="container">
                <div class="content-area">
                    <h1>Respiratory</h1>
                    <ul>
                        <li v-for="product in products" :key="product.id">
                            <div>
                                {{ product.product_name }}
                                <img :src="product.variations[0].product_images[0].filename" alt="Product image" height="200" width="200" />
                            </div>
                        </li>
                    </ul>
                </div>
                <div v-if="pagination">
                    <button
                        :disabled="pagination.current_page <= 1"
                        @click="fetchProducts(pagination.current_page - 1)"
                    >
                        Previous
                    </button>

                    <span>
                        Page {{ pagination.current_page }} of {{ pagination.last_page }}
                    </span>

                    <button
                        :disabled="pagination.current_page >= pagination.last_page"
                        @click="fetchProducts(pagination.current_page + 1)"
                    >
                        Next
                    </button>
                </div>
            </div>
        </main>
    </div>
</template>

<style>
</style>
