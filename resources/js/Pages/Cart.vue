<template>
    <app-layout>
        <div class="container mx-auto mt-10">
            <div class="flex shadow-md my-10">
                <div class="w-3/4 bg-white px-10 py-10">
                    <div class="flex justify-between border-b pb-8">
                        <h1 class="font-semibold text-2xl">Shopping Cart</h1>
                        <h2 class="font-semibold text-2xl">{{cart.length}} items</h2>
                    </div>
                    <div class="flex mt-10 mb-5">
                        <h3 class="font-semibold text-gray-600 text-xs uppercase w-2/5">Product Details</h3>
                        <h3 class="font-semibold text-gray-600 text-xs uppercase w-1/5 text-center">Quantity</h3>
                        <h3 class="font-semibold text-gray-600 text-xs uppercase w-1/5 text-center">Price</h3>
                        <h3 class="font-semibold text-gray-600 text-xs uppercase w-1/5 text-center">Total</h3>
                    </div>
                  
                    <template v-if="cartItems.length">
                        <div class="flex items-center hover:bg-gray-100 -mx-8 px-6 py-5" v-for="(item,index) in cartItems"
                            :key="item.id">
                            <div class="flex w-2/5">
                                <!-- product -->
                                <div class="w-20">
                                    <img class="h-24" :src="item.image" alt="image">
                                </div>
                                <div class="flex flex-col justify-between ml-4 flex-grow">
                                    <span class="font-bold text-sm">{{item.name}}</span>
                                    <span class="text-red-500 text-xs">{{item.category}}</span>
                                    <a href="#" class="font-semibold hover:text-red-500 text-gray-500 text-xs">Remove</a>
                                </div>
                            </div>
                            <div class="flex justify-center w-1/5">
                                <input class="mx-2 border text-center w-20" type="number" @change="e=>qtyChanged(e,index)" @keyup="e=>qtyChanged(e,index)" :value="qty[index]">
                            </div>
                            <span class="text-center w-1/5 font-semibold text-sm">{{item.price}} DHS</span>
                            <span class="text-center w-1/5 font-semibold text-sm">{{total[index]}} DHS</span>
                        </div>
                    </template>
                    <div v-else class="text-center text-xl">
                        Cart empty
                    </div>
                </div>

                <div id="summary" class="w-1/4 px-8 py-10">
                    <h1 class="font-semibold text-2xl border-b pb-8">Order Summary</h1>
                    <div class="py-10">
                        <form action="" @submit.prevent="getCoupon" v-if="!coupon">
                            <label for="promo" class="font-semibold inline-block mb-3 text-sm uppercase">Promo Code</label>
                            <input type="text" v-model="code" placeholder="Enter your code" class="p-2 text-sm w-full">
                            <button type="submit" class="bg-red-500 hover:bg-red-600 px-5 py-2 text-sm text-white uppercase mt-5">Apply</button>
                        </form>

                        <template v-else>
                            <div class="py-3 px-5 bg-green-500 text-center rounded shadow-md mt-4">
                            Promo of  {{coupon}}% applied
                            </div>
                            <button class="bg-red-500 hover:bg-red-600 px-5 py-2 text-sm text-white uppercase mt-5" @click="coupon=''">Remove</button>
                        </template>
                    </div>
                   
                    <div class="border-t mt-8">
                        <div class="flex font-semibold justify-between py-6 text-sm uppercase">
                            <span>Total cost</span>
                            <span>{{totalCost}} DHS</span>
                        </div>
                        <inertia-link :href="route('checkout')" class="bg-indigo-500 block text-center font-semibold py-2 px-4 rounded w-full hover:bg-indigo-600 py-3 text-sm text-white uppercase">Checkout</inertia-link>
                    </div>
                </div>
            </div>
        </div>
         <jet-modal :show="showModal">
            <div class="container py-3 mx-auto text-center w-full h-full relative bg-red-200">
                <span>{{msg}}</span>       
                <button class="py-2 px-4 shadow-md rounded ml-auto absolute right-0" @click="showModal=false">X</button>             
            </div>
        </jet-modal>
    </app-layout>
</template>

<script>
    import {mapMutations, mapState} from "vuex";
    import AppLayout from '../Layouts/AppLayout.vue';
    import JetModal from '@/Jetstream/Modal';
    import axios from "axios";
    export default {
        name: "Cart",
        components: {
            AppLayout,
            JetModal
        },
        data(){
            return{
                cartItems:[],
                qty:[],
                code:"",
                coupon:"",
                showModal:false,
                msg:""
            }
        },
        computed:{
            ...mapState(["cart"]),

            total(){
                return this.qty.length?this.qty.map((item,key)=>item*this.cartItems[key].price):0
            },
            totalCost(){
                let subtotal= this.total.length?this.total.reduce( (accumulator, currentValue) => accumulator + currentValue):0;
                let remise=this.coupon?(subtotal*this.coupon)/100:0;
                localStorage.setItem("totalCost",subtotal-remise);
                localStorage.setItem("coupon",this.coupon);
                this.updateCart();
                return subtotal-remise;
            }
        },
        methods:{
            ...mapMutations(["updateCart"]),
            getCoupon(){
                if(this.code.length){
                     axios.get(`/coupon/${this.code}`).then(res=>{
                        if(res.data.coupon){
                            this.coupon=res.data.coupon;
                        }
                        else{
                            this.msg="Code not found"
                            this.showModal=true
                        }
                    }).catch(err=>{
                        console.log("error",err)
                    })
                }
                else{
                    this.msg="Enter your code"
                    this.showModal=true
                }
            },
            qtyChanged(e,index){
                if(e.target.value<=this.cartItems[index].quantity){
                    this.qty[index]=e.target.value;
                    this.cartItems[index].qty=e.target.value;
                    this.cartItems[index].total=this.cartItems[index].price*e.target.value;
                    localStorage.setItem("cart",JSON.stringify(this.cartItems));
                    this.updateCart();
                }
                else{
                    this.qty[index]=this.qty[index];
                    this.msg="you have exceeded the available quantity"
                    this.showModal=true
                }
            }
        },
        mounted(){
            this.cartItems=this.cart;
            this.qty=this.cart.map(item=>item.qty);
            localStorage.setItem("coupon","0")
        }
    }

</script>

<style scoped>
    #summary {
        background-color: #f6f6f6;
    }

</style>
