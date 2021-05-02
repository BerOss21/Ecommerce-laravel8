<template>
     <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>
        <dash-layout>
            <div class="px-4 py-2">
                <div class="flex justify-between mb-3">
                    <h1 class="font-bold">Orders</h1>
                </div>
                <table class="border-collapse border rounded shadow-md w-full">
                    <thead class="bg-gray-300">
                        <tr>
                            <th class="border">Customer</th>
                            <th class="border">Amount</th>
                            <th class="border">Date</th>
                            <th class="border">Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-if="orders.length">
                        <tr v-for="order in orders" :key="order.id">
                            <td class="border p-1">{{order.user.name}}</td>
                            <td class="border p-1">{{getPrice(order.amount)}}</td>
                            <td class="border p-1">{{getDate(order.created_at)}}</td>
                            <td class="border p-1">
                                <div class="flex justify-center">
                                    <a href="" @click.prevent="showModel(order.id)" 
                                        class="py-1 px-2 rounded shadow-md bg-indigo-500 hover:bg-indigo-300">Show
                                    </a>
                                </div>
                            </td>
                        </tr>
                        </template>
                        <tr v-else>
                            <td colspan="4" class="text-center">No orders</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <jet-modal :show="show">
                    <template #title>
                        <div class="flex justify-between">
                            <h3> Detail Order</h3>
                            <span>Coupon: {{selectedOrder.detail[0].coupon}} %</span>
                        </div>
                       
                    </template>
                    <template #content>
                              <table class="border-collapse border rounded shadow-md w-full">
                    <thead class="bg-gray-300">
                        <tr>
                            <th class="border">Product</th>
                            <th class="border">Quantity</th>
                            <th class="border">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item,index) in selectedOrder.detail" :key="index">
                            <td class="border p-1">{{item.name}}</td>
                            <td class="border p-1">{{item.qty}}</td>
                            <td class="border p-1">{{getPrice(item.total)}}</td>
                        </tr>
                    </tbody>
                </table>
                    </template>
                    <template #footer>
                        <jet-button @click="show=false">Close</jet-button>
                    </template>
            </jet-modal>
        </dash-layout>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import DashLayout from '@/Layouts/DashLayout'
    import JetModal from '@/Jetstream/DialogModal'
    import JetButton from '@/Jetstream/Button'
    export default {
        components: {
            AppLayout,
            DashLayout,
            JetModal,
            JetButton
        },
        data(){
            return{
                show:false,
                selectedOrder:""
            }
        },
        props:["orders"],
        methods:{
            showModel(id){
                this.selectedOrder=this.orders.find(i=>i.id==id);
                this.show=true
            },
            getPrice(i){
                let val=+i;
                return val.toLocaleString('fr-FR',{style:'currency',currency:'DHS'});
            },

            getDate(d){
                let newDate=new Date(d);
                let date=newDate.toLocaleDateString('fr-FR');
                let time=newDate.toLocaleTimeString('fr-FR');
                return date+" "+time;
            }
        }
    }
</script>
