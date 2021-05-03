<template>
    <app-layout>
        <Carousel />
        <Body :products="productsPag.data" :links="productsPag.links" :categories="categories"/>
    </app-layout>

</template>
<script>

    import AppLayout from '@/Layouts/AppLayout'
    import Carousel from "./Home/Carousel";
    import Body from "./Home/Body";

    export default {
        components: {
            AppLayout,
            Carousel,
            Body
        },
        name: "Home",
        props:["productsPag","categories"],
        mounted(){
            console.log("pag",this.productsPag)
        }
    }

</script>
