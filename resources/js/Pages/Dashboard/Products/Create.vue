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
                            <h1 class="font-bold">New product</h1>
                            <inertia-link :href="route('products.index')">
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
                           <input type="text" v-model="form.name" class="rounded w-full shadow-md py-2 bg-gray-100" placeholder="Name of product">
                           <span class="text-red" v-if="errors.name">{{errors.name}}</span>
                       </div>
                        <div class="mb-2">
                           <textarea v-model="form.description" class="rounded w-full shadow-md py-2 bg-gray-100" placeholder="Description of product"></textarea>
                           <span class="text-red" v-if="errors.description">{{errors.description}}</span>
                        </div>
                        <div class="mb-2">
                            <select v-model="form.categories" multiple class="rounded w-full shadow-md py-2 bg-gray-100">
                                <option value="" disabled>Choise categories</option>
                                <template v-if="categories">
                                    <option v-for="category in categories" :key="category" :value="category.id">{{category.name}}</option>
                                </template>
                                <option v-else value="">No category</option>
                            </select>
                            <span class="text-red" v-if="errors.categories">{{errors.categories}}</span>
                        </div>
                        <div class="mb-2">
                            <input type="number" v-model="form.price" class="rounded w-full shadow-md py-2 bg-gray-100" placeholder="Price">
                            <span class="text-red" v-if="errors.price">{{errors.price}}</span>
                        </div>
                        <div class="mb-2">
                            <input type="number" v-model="form.quantity" class="rounded w-full shadow-md py-2 bg-gray-100" placeholder="Quantity">
                            <span class="text-red" v-if="errors.quantity">{{errors.quantity}}</span>
                        </div>
                        <div class="mb-2">
                            <input type="file" class="rounded w-full shadow-md py-2 bg-gray-100" @input="form.image = $event.target.files[0]"  @change="ImageChanged">
                            <span class="text-red" v-if="errors.image">{{errors.image}}</span>
                             <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                                {{ form.progress.percentage }}%
                             </progress>
                             <div class="mt-2" v-if="currentImage">
                                 <img :src="currentImage" alt="image" style="width:200px;height:200px">
                             </div>
                        </div>
                        <div class="mb-2">
                            <input type="file" multiple class="rounded w-full shadow-md py-2 bg-gray-100" @input="form.galleries = $event.target.files" @change="GalleryChanged">
                            <span class="text-red" v-if="errors.galleries">{{errors.galleries}}</span>
                             <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                                {{ form.progress.percentage }}%
                             </progress>
                              <div class="mt-2" v-if="form.currentGallery">
                                  <div v-for="(img,index) in form.currentGallery" :key="img.id" class="inline-block relative border border-red-800 w-2/12 h-36">
                                        <img  :src="img" alt="images" style="width:100%;height:100%;z-index:1">
                                       <span 
                                       class="bg-red-600 py-1 px-2 border rounded-full cursor-pointer absolute top-0 left-0 z-50 text-white hover:shadow-lg transform hover:scale-110 transition ease-in-out duration-300" 
                                       @click="removeFromGallery(index)"
                                       >
                                       -
                                       </span>
                                  </div>   
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
    import JetButton from "@/Jetstream/Button";

    export default {
        components: {
            AppLayout,
            DashLayout,
            JetButton
        },
        props:["categories","errors"],
        data(){
            return{
                form:this.$inertia.form({
                    name:"",
                    description:"",
                    categories:[],
                    galleries:[],
                    price:"",
                    quantity:"",
                    image:"",
                    currentGallery:[]
                }),
                currentImage:"",
            }        
        },
         methods: {
            submit() {
             this.form.post(route('products.store'));
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
            GalleryChanged(e){
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length) {
                    console.log('no files');
                }

                Object.values(this.form.galleries).forEach(item => {
                    this.getBase64(item).then(
                        data => {
                            this.form.currentGallery.push(data)
                        }
                    );
                });
            },
            removeFromGallery(i){
                this.form.currentGallery= this.form.currentGallery.filter((item,index)=>{return index!=i})
            },
        },
    }

</script>