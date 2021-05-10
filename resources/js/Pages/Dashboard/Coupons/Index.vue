<template>
    <app-layout>
        <!-- <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template> -->
        <dash-layout>
            <div class="px-4 py-2">
                <div class="my-5">
                    <div class="px-4 py-2 sm:p-3 bg-gray-200 shadow sm:rounded-lg">
                        <div class="flex justify-between w-full">
                            <h1 class="font-bold">Coupons</h1>
                            <inertia-link :href="route('coupons.create')">
                                <jet-button :bg="'bg-indigo-500'">
                                    Add new
                                </jet-button>
                            </inertia-link>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-5 sm:p-6 bg-white  shadow sm:rounded-lg">
                    <table class="cell-border compact stripe " id="myTable">
                        <thead class="bg-gray-300">
                            <tr>
                                <th class="border">#</th>
                                <th class="border">Code</th>
                                <th class="border">Percent_off [%]</th>
                                <th class="border">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-if="coupons.length">
                            <tr v-for="(coupon,index) in coupons" :key="coupon.id">
                                <td class="border p-1">{{index+1}}</td>
                                <td class="border p-1">{{coupon.code}}</td>
                                <td class="border p-1">{{coupon.percent_off}}</td>
                                <td class="border p-1">
                                    <div class="flex justify-center">
                                        <inertia-link :href="route('coupons.edit',coupon.id)"
                                            class="bg-green-300 text-white hover:bg-green-200 py-1 px-2 rounded shadow-md mr-2">Edit
                                        </inertia-link>
                                        <inertia-link :href="route('coupons.destroy',coupon.id)" method="delete"
                                            class="bg-red-300 text-white hover:bg-red-200 py-1 px-2 rounded shadow-md">Delete
                                        </inertia-link>
                                    </div>
                                </td>
                            </tr>
                            </template>
                            <tr v-else>
                                <td colspan="4" class="text-center">No coupons</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </dash-layout>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import DashLayout from '@/Layouts/DashLayout'
    import JetButton from "@/Jetstream/Button"
    import $ from 'jquery'
    
    export default {
        components: {
            AppLayout,
            DashLayout,
            JetButton
        },
        props: ["coupons"],
        mounted(){
            $("#script").html($("#script").children());
        }
    }

</script>
