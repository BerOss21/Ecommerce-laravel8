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
                    <h1 class="font-bold">Categories</h1>
                    <inertia-link :href="route('categories.create')" class="py-1 px-2 shadow-md bg-blue-600 rounded">Add
                        new</inertia-link>
                </div>
                <table class="border-collapse border rounded shadow-md w-full">
                    <thead class="bg-gray-300">
                        <tr>
                            <th class="border">Image</th>
                            <th class="border">Name</th>
                            <th class="border">Description</th>
                            <th class="border">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-if="categories.length">
                        <tr v-for="category in categories" :key="category.id">
                            <td class="border p-1">
                                <img :src="category.image_path" class="mx-auto" alt="image"
                                    style="width:100px;height:100px">
                            </td>
                            <td class="border p-1">{{category.name}}</td>
                            <td class="border p-1">{{category.description.slice(0,40)}} ...</td>
                            <td class="border p-1">
                                <div class="flex justify-center">
                                    <inertia-link :href="route('categories.edit',category.id)"
                                        class="bg-green-300 mr-2 hover:bg-green-200 py-1 px-2 rounded shadow-md">Edit
                                    </inertia-link>
                                    <a href="" @click.prevent="showModel(category.id)" 
                                        class="bg-red-300 hover:bg-red-200 py-1 px-2 rounded shadow-md">Delete
                                    </a>
                                </div>
                            </td>
                        </tr>
                        </template>
                        <tr v-else>
                            <td colspan="4" class="text-center">No categories</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <jet-confirmation-modal :show="confirmingCategoryDeletion" @close="confirmingCategoryDeletion = false">
                <template #title>
                    Delete Category
                </template>

                <template #content>
                    Are you sure you want to delete this category? 
                </template>

                <template #footer>
                    <div>
                        <inertia-link href="" @click.prevent="confirmingCategoryDeletion = false" class="bg-gray-300 hover:bg-gray-200 py-1 px-2 rounded shadow-md mr-5">
                            Cancel
                        </inertia-link>
                        <inertia-link :href="route('categories.destroy',cat)" method="delete" 
                            class="bg-red-300 hover:bg-red-200 py-1 px-2 rounded shadow-md">Delete
                        </inertia-link>
                    </div>
                   
                </template>
            </jet-confirmation-modal>
        </dash-layout>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import DashLayout from '@/Layouts/DashLayout'
    import JetConfirmationModal from '@/Jetstream/ConfirmationModal'
    import JetDangerButton from '@/Jetstream/DangerButton'
    export default {
        components: {
            AppLayout,
            DashLayout,
            JetConfirmationModal,
            JetDangerButton
        },
        data(){
            return{
                confirmingCategoryDeletion:false,
                cat:""
            }
        },
        props: ["categories"],
        methods:{
            showModel(id){
                this.confirmingCategoryDeletion=true;
                this.cat=id
            },
            deleteCategory(){

            }
        },
        mounted() {
            console.log("cat", this.categories)
        },
        updated(){
            this.confirmingCategoryDeletion=false;
        }
    }

</script>
