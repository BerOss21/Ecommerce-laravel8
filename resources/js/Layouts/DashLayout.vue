<template>
    <div>
         <div class="py-12 grid md:grid-cols-12 gap-2">
            <div class="px-6 lg:px-8 md:col-span-3">
                <div class="bg-white overflow-hidden shadow-xl rounded ">
                    <jet-nav-link  class="py-2 px-4 hover:bg-gray-500 w-full" :href="route('products.index')" :active="route().current('products.index')" >
                        <div>Products</div>
                    </jet-nav-link>
                    <jet-nav-link class="py-2 px-4 hover:bg-gray-500 w-full" :href="route('categories.index')" :active="route().current('categories.index')">
                        <div>Catgeories</div>
                    </jet-nav-link>
                    <jet-nav-link class="py-2 px-4 hover:bg-gray-500 w-full" :href="route('coupons.index')" :active="route().current('coupons.index')">
                        <div>Coupons</div>
                    </jet-nav-link>
                    <jet-nav-link class="py-2 px-4 hover:bg-gray-500 w-full" :href="route('orders.index')" :active="route().current('orders.index')">
                        <div>Orders</div>
                    </jet-nav-link>
                </div>
            </div>
            <div class="px-6 lg:px-8 md:col-span-9">
                <div class="bg-white overflow-hidden shadow-xl rounded">
                    <slot></slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import JetNavLink from '@/Jetstream/NavLink'
export default {
    name:"DashLayout",
    components:{
        JetNavLink
    }
}
</script>