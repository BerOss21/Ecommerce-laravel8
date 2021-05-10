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
                            <h1 class="font-bold">Edit categories</h1>
                            <inertia-link :href="route('categories.create')">
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
                           <input type="text" v-model="form.name" class="rounded w-full shadow-md py-2 bg-gray-100" placeholder="Name of category">
                           <span v-if="errors.name">{{errors.name}}</span>
                       </div>
                        <div class="mb-2">
                           <textarea v-model="form.description" class="rounded w-full shadow-md py-2 bg-gray-100" placeholder="Description of category"></textarea>
                            <span v-if="errors.description">{{errors.description}}</span>
                        </div>
                        <div class="mb-2">
                            <input type="file" @change="ImageChanged" class="rounded w-full shadow-md py-2 bg-gray-100" @input="form.image = $event.target.files[0]" >
                               <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                                 {{ form.progress.percentage }}%
                                </progress>
                            <span v-if="errors.image">{{errors.image}}</span>
                            <div class="mt-2">
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
                    name: null,
                    description: null,
                    image: null,
                }),
                currentImage:""
            }
        },
        props:["errors","category"],
        methods:{
            submit(){
                 this.form.post(route("categories.update",this.category.id));
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
        },
        mounted(){
            this.form.name=this.category.name;
            this.form.description=this.category.description;
            this.currentImage=this.category.image_path;
        }
    }

</script>