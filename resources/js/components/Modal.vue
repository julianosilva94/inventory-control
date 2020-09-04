<template>
    <transition name="fade">
        <div v-if="visible" class="bg-black bg-opacity-50 absolute inset-0 flex items-center justify-center">
            <div class="bg-gray-100 w-1/2 rounded">
                <div class="border-b-2 px-4 py-2 bg-gray-100">
                    <span class="text-xl">{{ title }}</span>
                </div>
                <div class="p-4 bg-white">
                    <slot></slot>
                </div>
                <div class="p-4 bg-gray-100 border-t-2 flex justify-end gap-x-2">
                    <button @click="confirm" type="button" class="border rounded bg-green-500 hover:bg-green-600 text-white px-6 py-1">Salvar</button>
                    <button @click="cancel" type="button" class="border rounded bg-gray-100 hover:bg-gray-200 px-6 py-1">Cancelar</button>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
export default {
    name: "Modal",
    props: [
        'title',
        'visible',
    ],
    data: function () {
        return {
        }
    },
    methods: {
        confirm: function () {
            this.$emit('onConfirm');
        },
        cancel: function () {
            this.$emit('onCancel');
        }
    }
}
</script>

<style scoped>
    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s;
    }
    .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
        opacity: 0;
    }
</style>
