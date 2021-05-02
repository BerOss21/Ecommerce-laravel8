<template>
    <app-layout>
        <div class="grid grid-cols-12 gap-12 container mx-auto my-10 w-10/12">
            <div class="col-span-5 bg-white" style="max-height:90vh">
                <div class="border-2" style="height:70vh">
                    <img :src="selectedImage" alt="image" class="h-full w-full">
                </div>
                <div class="flex my-2">
                    <div class="w-2/12 mr-2">
                        <img :src="product.image_path" alt="gal" class="w-full h-full cursor-pointer"
                            :class="{'border-2 border-red-900':product.image_path==selectedImage}"
                            @click="selectImg(product.image_path)">
                    </div>
                    <div v-for="img in product.galleries" :key="img.id" class="w-2/12 mr-2">
                        <img :src="img.image_path" alt="gal" class="w-full h-full cursor-pointer"
                            :class="{'border-2 border-red-900':img.image_path==selectedImage}"
                            @click="selectImg(img.image_path)">
                    </div>
                </div>
            </div>
            <div class="col-span-7 px-10 py-6 bg-white">
                <div class="border-b p-4 font-extrabold text-4xl">
                    {{product.name}}
                </div>
                <div class="border-b p-4 text-2xl">
                    {{getPrice(product.price)}}
                </div>
                <div class="border-b p-4 text-xl text-green-300">
                    {{product.quantity}} Unities
                </div>
                <div class="border-b p-4">
                    {{product.description}}
                </div>
                <form @submit.prevent="addToCart">
                    <div class="border-b p-4 grid grid-cols-4 gap-2 w-7/12">
                        <input type="number" class="py-2 shadow-md col-span-1" v-model="qty">
                        <button type="submit"
                            class="py-2 px-4 bg-black text-white font-bold shadow-md col-span-3 transition ease-in-out duration-500 hover:bg-green-400">Add
                            to cart</button>
                    </div>
                </form>
            </div>
        </div>
        <jet-modal :show="showMessage">
            <div class="container py-3 mx-auto text-center w-full h-full relative bg-red-200">
                <span>{{msg}}</span>       
                <button class="py-2 px-4 shadow-md rounded ml-auto absolute right-0" @click="showMessage=false">X</button>             
            </div>
        </jet-modal> 
        <jet-modal :show="showSuccess">
            <div class="container py-3 mx-auto text-center w-full h-full relative bg-green-200">
                <span>{{msg}}</span>       
                <button class="py-2 px-4 shadow-md rounded ml-auto absolute right-0" @click="showSuccess=false">X</button>             
            </div>
        </jet-modal>    
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout';
    import JetModal from '@/Jetstream/Modal';
    import {
        mapMutations,
        mapState,
    } from "vuex";
    export default {
        name: "Details",
        data() {
            return {
                selectedImage: "",
                showMessage: false,
                showSuccess: false,
                msg: "",
                qty:1
            }
        },
        components: {
            AppLayout,
            JetModal
        },
        computed: mapState(["cart"]),
        methods: {
            selectImg(img) {
                this.selectedImage = img
            },
            getPrice(i){
                let val=+i;
                return val.toLocaleString('fr-FR',{style:'currency',currency:'DHS'});
            },
            addToCart() {
                if (this.qty <= 0) {
                    this.msg = "The quantity should be a positive integer";
                    this.showMessage = true;
                } 

                else if(+this.qty>+this.product.quantity){
                    this.msg = "Sorry there is only "+this.product.quantity+" unities";
                    this.showMessage = true;
                }
                
                else {
                    let cartItems = [...this.cart];
                    let productIndex=cartItems.findIndex(item=>item.id==this.product.id);
                    if(productIndex!=-1){               
                        if((+cartItems[productIndex].qty) + (+this.qty) > +this.product.quantity){
                            this.msg = "Sorry there is only "+this.product.quantity+" unities in stock";
                            this.showMessage = true;
                        }
                        else{
                            cartItems[productIndex].qty+=+this.qty;
                            cartItems[productIndex].total=this.qty*this.product.price
                        }                         
                    }
                    else{
                        cartItems.push({
                            id: this.product.id,
                            name: this.product.name,
                            image:this.product.image_path,
                            category:this.product.categories.map(item=>item.name).join(","),
                            price:this.product.price,
                            quantity:this.product.quantity,
                            qty: +this.qty,
                            total: this.qty * this.product.price
                        })
                    }    
                    let totalCost=cartItems.reduce((acc,curr)=>acc+curr);
                    localStorage.setItem("totalCost",totalCost);
                    localStorage.setItem("cart", JSON.stringify(cartItems));
                    this.updateCart();
                    this.msg = "Product added successfully"; 
                    this.showSuccess = true;              
                }
            },
            ...mapMutations(["updateCart"])
        },
        props: ["product"],
        mounted() {
            this.selectedImage = this.product.image_path
        }
    }
</script>

<style lang="css" scoped>


</style>
