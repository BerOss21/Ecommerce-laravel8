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
                    <h1 class="font-bold">Coupons</h1>
                    <inertia-link :href="route('coupons.create')" class="py-1 px-2 shadow-md bg-blue-600 rounded">Add
                        new</inertia-link>
                </div>
                <table class="border-collapse border rounded shadow-md w-full">
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
                                        class="bg-green-300 hover:bg-green-200 py-1 px-2 rounded shadow-md mr-2">Edit
                                    </inertia-link>
                                     <inertia-link :href="route('coupons.destroy',coupon.id)" method="delete"
                                        class="bg-red-300 hover:bg-red-200 py-1 px-2 rounded shadow-md">Delete
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
        </dash-layout>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import DashLayout from '@/Layouts/DashLayout'
    export default {
        components: {
            AppLayout,
            DashLayout,
        },
        props: ["coupons"],
    }

</script>
