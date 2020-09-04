<template>
    <div>
        <div class="flex justify-between">
            <h1 class="text-2xl">Lista de Produtos</h1>
            <button @click="showModal = true" type="button" class="border rounded bg-red-500 hover:bg-red-600 text-white px-6 py-1">Cadastrar produto</button>
        </div>

        <table class="table-auto bg-white w-full rounded my-2">
            <thead>
            <tr>
                <th class="px-4 py-2">SKU</th>
                <th class="px-4 py-2">Nome</th>
                <th class="px-4 py-2">Descrição</th>
                <th class="px-4 py-2">Qtd em Estoque</th>
                <th class="px-4 py-2"></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="product in products">
                <td class="border px-4 py-2">{{ product.sku }}</td>
                <td class="border px-4 py-2">{{ product.name }}</td>
                <td class="border px-4 py-2">{{ product.description }}</td>
                <td class="border px-4 py-2">{{ product.quantity }}</td>
                <td class="border px-4 py-2">
                    <a @click="selectProduct(product)" href="#" class="text-yellow-600">Editar</a>
                </td>
            </tr>
            </tbody>
        </table>

        <modal
            :visible="showModal"
            title="Cadastrar produto"
            @onConfirm="saveProduct"
            @onCancel="onCancelModal"
        >
            <form class="flex flex-col gap-6">
                <div class="flex flex-col gap-1">
                    <label for="sku">SKU</label>
                    <input v-if="!product.id" v-model="product.sku" id="sku" name="sku" type="text" class="border rounded p-1 bg-gray-100">
                    <span v-if="product.id" class="font-bold">{{ product.sku }}</span>
                </div>
                <div class="flex flex-col gap-1">
                    <label for="name">Nome</label>
                    <input v-model="product.name" id="name" name="name" type="text" class="border rounded p-1 bg-gray-100">
                </div>
                <div class="flex flex-col gap-1">
                    <label for="description">Descrição</label>
                    <textarea v-model="product.description" id="description" name="description" type="text" class="border rounded p-1 bg-gray-100" rows="3"></textarea>
                </div>
                <div v-if="!product.id" class="flex flex-col gap-1">
                    <label for="quantity">Quantidade Inicial</label>
                    <input v-model="product.quantity" id="quantity" name="quantity" type="number" min="0" step="1" class="border rounded p-1 bg-gray-100" value="0">
                </div>
            </form>
        </modal>
    </div>
</template>

<script>
export default {
    name: "ProductsPage",
    data: function () {
        return {
            loading: true,
            showModal: false,
            products: [],
            product: this.getEmptyProduct(),
        }
    },
    methods: {
        onCancelModal: function () {
            this.showModal = false;
            this.product = this.getEmptyProduct();
        },
        getEmptyProduct: function () {
           return { sku: '', name: '', description: '', quantity: 0 };
        },
        selectProduct: function (product) {
            this.product = { ...product };
            this.showModal = true;
        },
        saveProduct: async function () {
            if (this.product.id) {
                await this.updateProduct();
            } else {
                await this.createProduct();
            }

            this.showModal = false;
            this.product = this.getEmptyProduct();
            this.loadProducts();
        },
        createProduct: function () {
            return axios.post('produtos', this.product);
        },
        updateProduct: function () {
            return axios.put(`produtos/${this.product.id}`, this.product);
        },
        loadProducts: function () {
            axios
                .get('produtos/listar')
                .then(({ data: { products } }) => {
                    this.products = products;
                    this.loading = false;
                })
        }
    },
    mounted() {
        this.loadProducts();
    }
}
</script>

<style scoped>

</style>
