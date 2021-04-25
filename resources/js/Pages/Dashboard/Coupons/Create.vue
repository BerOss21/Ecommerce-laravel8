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
                    <h1 class="font-bold">New coupon</h1>
                    <inertia-link :href="route('coupons.index')" class="py-1 px-2 shadow-md bg-blue-600 rounded">Return</inertia-link>
                </div>
               <div>
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

    export default {
        components: {
            AppLayout,
            DashLayout
        },
        data(){
            return{
                 form: this.$inertia.form({
                    code: null,
                    percent_off: null,
                }),
            }
        },
        props:["errors"],
        methods:{
            submit(){
                 this.form.post(route("coupons.store"))
            }
        }
    }

</script>