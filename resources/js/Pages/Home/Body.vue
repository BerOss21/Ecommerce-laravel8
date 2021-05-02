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

                            <a class="pl-3 inline-block no-underline hover:text-black" href="#">
                                <svg class="fill-current hover:text-black" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24">
                                    <path d="M7 11H17V13H7zM4 7H20V9H4zM10 15H14V17H10z" />
                                </svg>
                            </a>

                            <a class="pl-3 inline-block no-underline hover:text-black" href="#">
                                <svg class="fill-current hover:text-black" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24">
                                    <path
                                        d="M10,18c1.846,0,3.543-0.635,4.897-1.688l4.396,4.396l1.414-1.414l-4.396-4.396C17.365,13.543,18,11.846,18,10 c0-4.411-3.589-8-8-8s-8,3.589-8,8S5.589,18,10,18z M10,4c3.309,0,6,2.691,6,6s-2.691,6-6,6s-6-2.691-6-6S6.691,4,10,4z" />
                                </svg>
                            </a>

                        </div>
                    </div>
                </nav>

                <template v-if="products.length">
                    <div class="w-full md:w-1/3 xl:w-1/4 p-6 flex flex-col" v-for='product in products' :key="product.id">
                        <inertia-link :href="route('show',product.id)">
                            <img class="hover:grow hover:shadow-lg w-full" :src="product.image_path">
                            <div class="pt-3 flex items-center justify-between">
                                <p class="">{{product.name}}</p>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 fill-current text-gray-500 hover:text-black" viewBox="0 0 24 24"
                                    fill="currentColor">
                                    <path
                                        d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                                </svg>
                            </div>
                            <p class="pt-1 text-gray-900">{{getPrice(product.price)}}</p>
                        </inertia-link>
                    </div>
                </template>
                <div v-else class="w-full py-3 bg-yellow-500 shadow-xl rounded text-white text-center">
                    No products
                </div>
            </div>
        </section>
</template>
<script>
export default {
    name:"Body",
    props:["products"],
    methods:{
        getPrice(i){
            let val=+i;
            return val.toLocaleString('fr-FR',{style:'currency',currency:'DHS'});
        }
    }
}
</script>