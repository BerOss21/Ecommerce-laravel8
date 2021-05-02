<template>
    <app-layout>
        <div class="container mx-auto bg-white w-8/12 rounded shadow-md px-4 py-2 my-10">
            <div class="border-b-2 pb-4 text-2xl font-bold mb-4">
                Checkout
            </div>       
            <div v-if="cart.length">
                <form id="payment-form" @submit.prevent="handleSubmit">
                    <div class="mb-7">
                        <h3 class="font-bold pb-6 border-b-2 mb-4">Your Basic Information</h3>
                        <input type="text" class="py-2 rounded bg-gray-300 w-full mb-2" disabled :value="$page.props.user.name">
                        <input type="text" class="py-2 rounded bg-gray-300 w-full mb-2"  disabled :value="$page.props.user.email">
                        <textarea cols="30" rows="2" class="py-2 mb-2 rounded bg-gray-100 w-full"  v-model="adresse" placeholder="Adresse"></textarea>
                        <input type="number" class="py-2 rounded bg-gray-100 w-full" v-model="phone" placeholder="Phone number">
                    </div>
                    <div class="bg-indigo-500 h-full rounded shadow-md text-white p-2 mb-7">
                        <h3 class="font-bold text-xl border-b-2 pb-1 mb-1">Total</h3>
                        <h1 class="font-bold text-4xl mb-2 text-red-500">{{getPrice(totalCost)}}</h1>
                        <h3 class="font-bold text-xl border-b-2 pb-1 mb-1 mt-6">Detail</h3>
                        <ul class="list-disc mt-2">
                            <li class="mb-2" v-for="item in cart" :key="item.id">
                                <img :src="item.image" alt="image" style="width:20px" class="mr-1 inline-block">
                                <span>{{item.qty}} of {{item.name}}</span>
                            </li>
                        </ul>

                    </div>
                    <div>
                        <h3 class="font-bold pb-6 border-b-2 mb-4">Your Payment Information</h3>
                        <div id="card-element">
                            <!--Stripe.js injects the Card Element-->
                        </div>
                        <button 
                        type="submit" 
                        class="bg-indigo-500 rounded shadow-md w-full mt-3 py-2 hover:bg-green-400 hover:shadow-lg"
                        :disabled="processing || disabled || succeeded"
                        >
                            <span class="text-white font-bold text-xl"
                                v-text="paymentProcessing?'Processing':'Pay now'">
                            </span>
                            <span v-if="processing"> ...</span>
                        </button>
                        <p v-if="error" class="text-red-500">{{error}}</p>
                        <p class="result-message hidden" v-if="succeeded">
                            Payment succeeded, see the result in your
                            <a href="" target="_blank">Stripe dashboard.</a> Refresh the page to pay again.
                        </p>
                    </div>
                </form>
            </div>
            <div v-else>
                <div class="rounded text-center  bg-yellow-500 py-3 px-4">Your cart is empty</div>
            </div>
     
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '../Layouts/AppLayout.vue';
    import JetModal from '@/Jetstream/Modal';
    import {
        loadStripe
    } from "@stripe/stripe-js";
    import { mapState } from 'vuex';
    export default {
        name: "Checkout",
        components: {
            AppLayout,
            JetModal
        },
        data() {
            return {
                stripe: {}, //initialize stripe library
                elements: "",
                error: null,
                processing: "",
                cardElement: {},
                succeeded:false,
                disabled: true,
                clientSecret: "",
                paymentProcessing: false,
                adresse:"",
                phone:"",
            }
        },
        computed:{
            ...mapState(["cart","totalCost"]),
            // total(){
            //     return this.cart?this.cart.map(i=>i.total).reduce((acc,curr)=>acc+ curr):0;
            // }
        },
        methods: {
            getPrice(i){
                let val=+i;
                return val.toLocaleString('fr-FR',{style:'currency',currency:'DHS'});
            },
            async handleChange(event) {
                // Listen for changes in the CardElement
                // and display any errors as the customer types their card details
                this.disabled = event.empty;
                this.error = event.error ? event.error.message : "";
            },

            async handleSubmit(ev) {
                this.processing=true;
                const payload = await this.stripe.confirmCardPayment(this.clientSecret, {
                    payment_method: {
                        card: this.cardElement,
                        billing_details: {
                            name: ev.target.name.value
                        }
                    }
                });
                if (payload.error) {
                    this.error=`Payment failed ${payload.error.message}`;
                    this.processing=false;
                } else {
                    this.error=null;
                    this.processing=false;
                    this.succeeded=true;
                    this.$inertia.post(
                    '/orders',
                    {
                        amount:this.totalCost,
                        adresse:this.adresse,
                        phone:this.phone,
                        detail:this.cart.map(item=>{
                            return (
                                {'name':item.name,'qty':item.qty,'total':item.total}
                            )
                        })
                    }
                    )
                    // axios.post("/orders",{
                    //     amount:this.totalCost,
                    //     detail:this.cart.map(item=>{
                    //         return (
                    //             {'name':item.name,'qty':item.qty,'total':item.total}
                    //         )
                    //     })
                    // }).then(res=>{
                    //     console.log(res.data.order);
                    // }).catch(err=>{
                    //     console.log("error",err)
                    // })
                }
            }
        },
        async mounted() {
            // load stripe library
            this.stripe = await loadStripe(process.env.MIX_STRIPE_KEY);
            this.elements = this.stripe.elements();
            axios.post(`/checkout/create`, {
                price: +this.totalCost
            }).then(res => {
                this.clientSecret = res.data.clientSecret;
                this.cardElement = this.elements.create('card', {
                classes: {
                    base: 'bg-gray-100 rounded border border-gray-300 focus:border-indigo-500 text-base outline-none text-gray-700 p-3 leading-8 transition-colors duration-200 ease-in-out'
                    }
                });
            this.cardElement.mount('#card-element');
            this.cardElement.on("change",this.handleChange);
            }).catch(error => {
                console.log("error", error)
            })
            

        }

    }

</script>
