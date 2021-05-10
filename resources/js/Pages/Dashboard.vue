<template>
    <app-layout>
        <!-- <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template> -->
        <dash-layout>
            <div class="p-8 sm:px-20 bg-white border-b border-gray-200 rounded-md">
                <div class="mt-8 text-2xl">
                    Welcome to your Dashboard!
                </div>

                <div class="mt-6 text-gray-500">
                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Amet odio beatae laborum similique nobis
                    autem cum, distinctio id accusantium maiores. Corporis reprehenderit laboriosam ipsa aspernatur
                    nobis fugit culpa, natus nihil?
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
            DashLayout,
        },
    }

</script>
