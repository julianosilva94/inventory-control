<template>
    <div class="flex gap-8">
        <button @click="openCheckIn" type="button" class="w-1/2 border rounded bg-green-500 hover:bg-green-600 text-white text-lg px-6 py-1">Registrar Entrada de Produtos</button>
        <button @click="openCheckOut" type="button" class="w-1/2 border rounded bg-red-500 hover:bg-red-600 text-white text-lg px-6 py-1">Registrar Saída de Produtos</button>

        <modal
            :visible="showModal"
            :title="this.action === 'in' ? 'Entrada de Produtos' : 'Saída de Produtos'"
            @onConfirm="registerEntries"
            @onCancel="onCancelModal"
        >
            <form class="flex flex-col gap-y-3">
                <div v-for="(entry, index) in entries" class="flex flex-row gap-2">
                    <div class="flex flex-col gap-y-1">
                        <label>
                            SKU
                            <span v-if="entry.sku.trim().length > 0" class="ml-2">
                                <small v-if="!entry.validSku" class="text-red-500">não encontrada</small>
                                <small v-if="entry.validSku" class="text-green-500">válida</small>
                            </span>
                        </label>
                        <input v-model="entry.sku" @input="checkEntry(entry, index)" name="sku" type="text" class="border rounded p-1 bg-gray-100">
                    </div>
                    <div class="flex flex-col gap-1" v-if="entry.sku.trim().length > 0 && entry.validSku">
                        <label>
                            Quantidade
                            <span class="ml-2">
                                <small v-if="!entry.validQty" class="text-red-500">não permitida</small>
                                <small v-if="entry.validQty" class="text-green-500">permitida</small>
                            </span>
                        </label>
                        <input v-model="entry.quantity" @input="checkEntry(entry, index)" name="quantity" type="number" min="1" step="1" class="border rounded p-1 bg-gray-100">
                    </div>
                    <div class="flex flex-col-reverse">
                        <button @click="removeEntry(index)" type="button" class="border rounded bg-red-500 text-white hover:bg-red-600 px-6 py-1">Remover</button>
                    </div>
                </div>
                <button @click="addEmptyEntry" type="button" class="mt-2 w-3/4 border-dashed border-2 rounded bg-gray-100 hover:bg-gray-200 px-6 py-1">Adicionar linha</button>
            </form>
        </modal>
    </div>
</template>

<script>
export default {
    name: "StockManager",
    data: function () {
        return {
            showModal: false,
            action: 'in',
            entries: [],
        }
    },
    methods: {
        openCheckIn: function () {
            this.showModal = true;
            this.action = 'in';
        },
        openCheckOut: function () {
            this.showModal = true;
            this.action = 'out';
        },
        addEmptyEntry: function () {
            this.entries.push({
                sku: '',
                quantity: 1,
                validSku: false,
                validQty: true,
            });
        },
        removeEntry: function (index) {
            this.entries.splice(index, 1)
        },
        onCancelModal: function () {
            this.showModal = false;
            this.entries = [];
        },
        registerEntries: function () {
            let url = 'estoque/entrada';

            if (this.action === 'out') {
                url = 'estoque/saida';
            }

            let entries = this.entries.map(({ sku, quantity }) => {
                return { sku, quantity };
            });

            axios
                .post(url, { products: entries })
                .then(({ data }) => {
                    console.log(data);
                })
        },
        checkEntry: function (entry, index) {
            const sku = entry.sku.trim();

            if (sku) {
                axios
                    .get(`produtos/buscar-sku/${sku}`)
                    .then(({ data: { product } }) => {
                        const validSku = !!product;

                        this.entries[index].validSku = validSku;
                        this.entries[index].validQty = (validSku && entry.quantity > 0 && entry.quantity <= product.quantity);
                    })
            }
        },
    },
    mounted() {
    }
}
</script>

<style scoped>

</style>
