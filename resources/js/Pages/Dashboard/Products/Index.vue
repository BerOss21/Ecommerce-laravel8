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
                            <h1 class="font-bold">Products</h1>
                            <inertia-link :href="route('products.create')">
                                <jet-button :bg="'bg-indigo-500'">
                                    Add new
                                </jet-button>
                            </inertia-link>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-5 sm:p-6 bg-white  shadow sm:rounded-lg">
                    <table class="cell-border compact stripe " id="myTable">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border">Image</th>
                                <th class="border">Name</th>
                                <th class="border">Description</th>
                                <th class="border">Price</th>
                                <th class="border">Categories</th>
                                <th class="border">Gallery</th>
                                <th class="border">User</th>
                                <th class="border">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-if="products.length">
                                <tr v-for="product in products" :key="product.id">
                                    <td class="border p-1">
                                        <img :src="product.image_path" class="mx-auto" alt="image" style="width:100px;height:100px">
                                    </td>
                                    <td class="border p-1">{{product.name}}</td>
                                    <td class="border p-1">{{product.description.slice(0,40)}} ...</td>
                                    <td class="border p-1">{{product.price}}</td>
                                    <td class="border p-1">{{product.categories.length?product.categories.map(item=>item.name).join(","):"Unspecified"}}</td>
                                    <td class="border p-1">
                                        <img 
                                        v-for="img in product.galleries" 
                                        :key="img.id" 
                                        :src="img.image_path" 
                                        :alt="'gallery '+img.id"
                                        style="width:40px;height:30px"
                                        >
                                    </td>
                                    <td class="border p-1">{{product.user.name}}</td>
                                    <td class="border p-1">
                                        <div class="flex justify-around">
                                            <inertia-link :href="route('products.edit',product.id)" class="bg-green-300 text-white hover:bg-green-200 py-1 px-2 rounded shadow-md">Edit</inertia-link>
                                            <inertia-link :href="route('products.destroy',product.id)" method="delete" class="bg-red-300 text-white ml-1 hover:bg-red-200 py-1 px-2 rounded shadow-md">Delete</inertia-link>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                            <tr v-else class="text-center">
                                <td colspan="7">No products</td>
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
    import JetButton from "@/Jetstream/Button";


    import $ from "jquery";

    export default {
        components: {
            AppLayout,
            DashLayout,
            JetButton
        },
        props:["products"],
        mounted(){
            $("#script").html($("#script").children());
        }
    }

</script>
