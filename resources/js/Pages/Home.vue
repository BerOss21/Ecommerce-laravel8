<template>
    <app-layout>
        <Header />
        <Body :products="productsPag.data" :links="productsPag.links" :categories="categories"/>
    </app-layout>

</template>
<script>

    import AppLayout from '@/Layouts/AppLayout'
    import Header from "./Home/Header";
    import Body from "./Home/Body";

    export default {
        components: {
            AppLayout,
            Header,
            Body
        },
        name: "Home",
        props:["productsPag","categories"],
        mounted(){
            console.log("pag",this.productsPag)
        }
    }

</script>
