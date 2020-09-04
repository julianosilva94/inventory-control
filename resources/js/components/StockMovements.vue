<template>
    <div>
        <div class="flex">
            <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                Movimentações do dia
            </h2>
            <date-picker class="my-6 ml-6 z-40" v-model="date" @input="load" type="date" :clearable="false" format="DD/MM/YYYY"></date-picker>
        </div>
        <div v-if="movements.length === 0">
            <h2 class="my-6 text-xl font-semibold text-gray-700 dark:text-gray-200">
                Nenhuma movimentação neste dia
            </h2>
        </div>
        <div v-if="movements.length > 0" class="w-full rounded shadow-xs">
            <div class="w-full">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-2 py-3"></th>
                        <th class="px-4 py-3">Produto</th>
                        <th class="px-4 py-3">Quantidade</th>
                        <th class="px-4 py-3">Horário</th>
                        <th class="px-4 py-3">Via</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        <tr v-for="movement in movements" class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3 text-xs">
                                <span v-if="movement.in" class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                              Entrada
                                            </span>
                                <span v-if="!movement.in" class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">
                                              Saída
                                            </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center text-sm">
                                    <div>
                                        <p class="font-semibold">{{ movement.product.name }}</p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400">
                                            SKU {{ movement.product.sku }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ movement.quantity }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ moment(movement.created_at).format('HH:mm:ss') }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ movement.system }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
import 'vue2-datepicker/locale/pt-br';
var moment = require('moment');

export default {
    name: "StockMovements",
    components: { DatePicker },
    data() {
        return {
            date: new Date(),
            movements: [],
            moment: moment,
        }
    },
    methods: {
      load: function () {
          axios
              .get(`estoque/historico/${this.date.toISOString().slice(0,10)}`)
              .then(({ data: { movements } }) => {
                  this.movements = movements;
              })
      }
    },
    mounted() {
        this.load()
    }
}
</script>

<style scoped>

</style>
