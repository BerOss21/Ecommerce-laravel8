<template>
    <app-layout>
        <Carousel />
        <Body :products="products"/>
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
        props:["products"]
    }

</script>
