<template>
        <app-layout>
            <div class="flex justify-center mt-5">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="my-4">
                <h3 class="text-2xl text-center">Order sent successfully</h3>
            </div>
            <div class="md:flex justify-center">
                <inertia-link :href="route('home')" class="py-2 px-4 rounded shadow-lg bg-indigo-500 mr-1">Home</inertia-link>
                <inertia-link :href="route('orders.index')" class="py-2 px-4 rounded shadow-lg bg-gray-200">My orders</inertia-link>
            </div>
        </app-layout>
</template>
<script>
import { mapMutations } from 'vuex';
import AppLayout from '../Layouts/AppLayout.vue'
export default {
    components: { AppLayout },
    name:"Success",
    methods:{
        ...mapMutations(["clearCart"])
    },
    mounted(){
        localStorage.clear();
        this.clearCart();
    }
}
</script>