<template>
    <div>
        <div class="header my-0">
            <div class="container mx-auto grid md:grid-cols-6 gap-2">
                <div class="md:col-span-4">
                    <h1 class="text-3xl mb-3">Furniture</h1>  
                    <p>When choosing furniture, it is necessary to take into consideration the style that you wish to use in your own spaces. An interior design project includes a variety of products, articles and models in different shapes and materials, from leather and wood to metal and velvet finishes. From iconic pieces of classical inspiration to contemporary metal solutions, the composition of the furniture can involve the use of elements with common or contrasting characteristics, preferring an impressive mix&match. For this reason, it is essential to evaluate both aesthetics and functionality, to be sure of designing an environment that is both beautiful and comfortable.</p> 
                </div>
                <div class="md:col-span-2">
                    <img src="../.././assets/images/logo.png" class="w-full h-full">
                </div>
            </div>
            <div class="filter-block">

            </div>
        </div>
    </div>
</template>
<script>
export default {
    name:"Header"
}
</script>

<style scoped>
    .header{
        position: relative;
        background-image: url("../.././assets/images/header1.jpg");
        background-repeat: no-repeat;
        background-size: cover;
        padding: 7% 2%;
    }
    .filter-block{
        position: absolute;
        top:0;
        left:0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.2);
        z-index: 2;
    }
</style>