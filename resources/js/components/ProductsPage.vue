<template>
    <div class="flex flex-col gap-y-4">
        <div class="flex justify-between">
            <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">
                Lista de Produtos
            </h2>
            <button @click="showModal = true" type="button" class="border rounded bg-green-500 hover:bg-green-600 text-white px-6 py-1">Cadastrar produto</button>
        </div>

        <div class="w-full rounded shadow-xs">
            <div class="w-full">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-2 py-3">SKU</th>
                        <th class="px-4 py-3">Produto</th>
                        <th class="px-4 py-3">Descrição</th>
                        <th class="px-4 py-3">Quantidade</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        <tr v-for="product in products">
                            <td class="px-4 py-3 text-sm">
                                {{ product.sku }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ product.name }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ product.description }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ product.quantity }}
                            </td>
                            <td class="border px-4 py-2">
                                <button type="button" @click="selectProduct(product)" class="px-3 hover:bg-gray-100 rounded text-yellow-600">Editar</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>


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
