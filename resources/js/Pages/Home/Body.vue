<template>
    <section class="bg-white py-8">

        <div class="container mx-auto flex items-center flex-wrap pt-4 pb-12">

            <nav id="store" class="w-full z-30 top-0 px-6 py-1">
                <div class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 px-2 py-3">

                    <a class="uppercase tracking-wide no-underline hover:no-underline font-bold text-gray-800 text-xl "
                        href="#">
                        Our Products
                    </a>

                    <div class="flex items-center" id="store-nav-content">
                        <jet-dropdown>
                            <template #trigger>
                                <span class="pl-3 inline-block no-underline hover:text-black cursor-pointer">
                                    <svg class="fill-current hover:text-black" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24">
                                        <path d="M7 11H17V13H7zM4 7H20V9H4zM10 15H14V17H10z" />
                                    </svg>
                                </span>
                            </template>
                            <template #content>
                                <template v-if="categories">
                                    <p class="cursor-pointer block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition"
                                        :class="!selectedCategory?'bg-yellow-300':''" @click="selectedCategory=''">All
                                        products</p>
                                    <p v-for="category in categories" :key="category.id"
                                        class="cursor-pointer block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition"
                                        :class="category.id==selectedCategory?'bg-yellow-300':''"
                                        @click="selectedCategory=category.id">{{category.name}}</p>
                                </template>
                                <div v-else>
                                    No category
                                </div>
                            </template>
                        </jet-dropdown>
                        <jet-dropdown>
                            <template #trigger>
                                <span class="pl-3 inline-block no-underline hover:text-black cursor-pointer">
                                    <svg class="fill-current hover:text-black" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24">
                                        <path
                                            d="M10,18c1.846,0,3.543-0.635,4.897-1.688l4.396,4.396l1.414-1.414l-4.396-4.396C17.365,13.543,18,11.846,18,10 c0-4.411-3.589-8-8-8s-8,3.589-8,8S5.589,18,10,18z M10,4c3.309,0,6,2.691,6,6s-2.691,6-6,6s-6-2.691-6-6S6.691,4,10,4z" />
                                    </svg>
                                </span>
                            </template>
                            <template #content>
                                <input type="text" class="w-full rounded" v-model="searchable">
                            </template>
                        </jet-dropdown>

                    </div>
                </div>
            </nav>

            <template v-if="allProducts.length">
                <div class="w-full md:w-1/3 xl:w-1/4 p-6 flex flex-col" v-for='product in allProducts'
                    :key="product.id">
                    <inertia-link :href="route('show',product.id)">
                        <img class="hover:grow hover:shadow-lg w-full" :src="product.image_path">
                        <div class="pt-3 flex items-center justify-between">
                            <p class="">{{product.name}}</p>
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-6 w-6  text-gray-500 hover:text-black" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </div>
                        <span
                            class="pt-1 font-bold text-indigo-500">{{product.categories.map(i=>i.name).join(" ")}}</span>
                        <p class="pt-1 text-gray-900">{{getPrice(product.price)}}</p>
                    </inertia-link>
                </div>
            </template>
            <div v-else-if="searchable" class="w-full py-3 bg-yellow-500 shadow-xl rounded text-white text-center">
                No results for: '{{searchable}}'
            </div>
            <div v-else class="w-full py-3 bg-yellow-500 shadow-xl rounded text-white text-center">
                No products
            </div>
        </div>
        <div class="flex justify-center">
            <pagination v-if="allProducts.length" :links="links" class="my-5" />
        </div>
    </section>
</template>
<script>
    import JetDropdown from '@/Jetstream/Dropdown';
    import JetFormSection from '@/Jetstream/FormSection'
    import Pagination from "./Pagination";

    export default {
        name: "Body",
        props: ["products", "categories", "links"],
        components: {
            JetDropdown,
            JetFormSection,
            Pagination
        },
        data() {
            return {
                selectedCategory: "",
                searchable: ""
            }
        },
        computed: {
            filtredProducts() {
                return this.selectedCategory ? this.products.filter(i => i.categories.map(i => i.id).includes(this
                    .selectedCategory)) : this.products;
            },
            allProducts() {
                return this.searchable ? this.filtredProducts.filter(item => item.name.toLowerCase().split(" ")
                    .includes(this.searchable.toLowerCase())) : this.filtredProducts;
            }
        },
        methods: {
            getPrice(i) {
                let val = +i;
                return val.toLocaleString('fr-FR', {
                    style: 'currency',
                    currency: 'DHS'
                });
            }
        }
    }

</script>
