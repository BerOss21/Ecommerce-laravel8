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
                            <h1 class="font-bold">Edit coupon</h1>
                            <inertia-link :href="route('coupons.index')">
                                <jet-button :bg="'bg-indigo-500'">
                                    Return 
                                </jet-button>
                            </inertia-link>
                        </div>
                    </div>
                </div>
               <div class="px-4 py-5 sm:p-6 bg-white  shadow sm:rounded-lg">
                   <form @submit.prevent="submit">
                       <div class="mb-2">
                           <input type="text" v-model="form.code" class="rounded w-full shadow-md py-2 bg-gray-100" placeholder="Code of coupon">
                           <span v-if="errors.code">{{errors.code}}</span>
                       </div>

                       <div class="mb-2">
                           <input type="number" min="0" v-model="form.percent_off" class="rounded w-full shadow-md py-2 bg-gray-100" placeholder="Percent_off">
                           <span v-if="errors.percent_off">{{errors.percent_off}}</span>
                       </div>
            
                        <button type="submit" class="w-full font-bold rounded bg-indigo-800 text-white py-2 px-4 hover:text-black hover:bg-transparent transition ease-in-out duration-500" >Submit</button>
                   </form>
               </div>
            </div>
        </dash-layout>


    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import DashLayout from '@/Layouts/DashLayout'
    import JetButton from "@/Jetstream/Button"

    export default {
        components: {
            AppLayout,
            DashLayout,
            JetButton
        },
        data(){
            return{
                 form: this.$inertia.form({
                    _method:"patch",
                    code: null,
                    percent_off: null,
                }),
            }
        },
        props:["coupon","errors"],
        methods:{
            submit(){
                 this.form.post(route("coupons.update",this.coupon.id));
            }
        },
        mounted(){
            this.form.code=this.coupon.code;
            this.form.percent_off=this.coupon.percent_off;
        }
    }

</script>