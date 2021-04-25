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
                    <h1 class="font-bold">New category</h1>
                    <inertia-link :href="route('categories.index')" class="py-1 px-2 shadow-md bg-blue-600 rounded">Return</inertia-link>
                </div>
               <div>
                   <form @submit.prevent="submit">
                       <div class="mb-2">
                           <input type="text" v-model="form.name" class="rounded w-full shadow-md py-2 bg-gray-100" placeholder="Name of category">
                           <span v-if="errors.name">{{errors.name}}</span>
                       </div>
                        <div class="mb-2">
                           <textarea v-model="form.description" class="rounded w-full shadow-md py-2 bg-gray-100" placeholder="Description of category"></textarea>
                            <span v-if="errors.description">{{errors.description}}</span>
                        </div>
                        <div class="mb-2">
                            <input type="file" class="rounded w-full shadow-md py-2 bg-gray-100" @input="form.image = $event.target.files[0]" @change="ImageChanged">
                               <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                                 {{ form.progress.percentage }}%
                                </progress>
                            <span v-if="errors.image">{{errors.image}}</span>

                            <div class="mt-2" v-if="currentImage">
                                <img :src="currentImage" alt="image" style="width:100px;height:100px">
                            </div>
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
                    name: null,
                    description: null,
                    image: null,
                }),
                currentImage:""
            }
        },
        props:["errors"],
        methods:{
            submit(){
                 this.form.post(route("categories.store"))
            },

             getBase64(file) {
                return new Promise((resolve, reject) => {
                    const reader = new FileReader();
                    reader.readAsDataURL(file);
                    reader.onload = () => resolve(reader.result);
                    reader.onerror = error => reject(error);
                });
            },

            ImageChanged(){
                this.getBase64(this.form.image).then(res=>{
                    this.currentImage=res;
                }).catch(err=>{
                    console.log(err)
                })          
            },
        }
    }

</script>