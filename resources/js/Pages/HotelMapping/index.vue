<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Hotel Mapping
            </h2>
        </template>

        <div class="overflow-x-auto">
            <div class="min-w-screen min-h-screen bg-gray-100 flex  justify-center bg-gray-100 font-sans overflow-hidden">
                <div class="w-full lg:w-5/6">
                    <Link href="hotel-mapping/create" class="inline-flex items-center mt-6  px-6 py-3 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"   >
                        <div class="side-menu__title">
                            Add Mapping
                        </div>
                    </Link>
                    <div v-if="show"   class=" my-5  max-w-9xl w-full bg-green-500 shadow-lg rounded-lg pointer-events-auto flex ring-1 ring-black ring-opacity-5 divide-x divide-gray-200 ">
                        <div class="w-0 flex-1 flex items-center p-4">
                            <div class="w-full">
                                <p class="mt-1 text-sm text-white">Deleted with success</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white shadow-md rounded my-6">




                        <table class="min-w-max w-full table-auto">
                            <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left">name</th>
                                <th class="py-3 px-6 text-center">Actions</th>
                            </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-light">
                            <tr v-for="hotel in hotels" class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                    <div class="flex items-center">

                                        <span class="font-medium">{{hotel.name}}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-center">
                                    <div class="flex item-center justify-center">
                                        <Link :href="route('EditMapping', hotel.hotel_id)">
                                        <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">

                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </div>
                                        </Link>

                                        <div @click="destroyMapping(hotel.hotel_id)" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </div>

                                    </div>
                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
<script>
import { Link } from '@inertiajs/inertia-vue3'
import axios from 'axios';
export default {
    components: {
        Link

    },
    props: {
        hotels : Array ,
    },
    data() {
        return {
            show : false ,
            hotel_id : '',
        }
    },
    methods: {
        destroyMapping(id){
            if (confirm("Do you really want to delete this item") == true) {
                this.hotel_id = id ;
                axios.post('/destroy-mapping-hotel/delete', {
                    hotel_id: this.hotel_id ,
                }).then( (response ) =>  {
                    this.errors = {};
                    this.message = '';
                    this.$inertia.get('/hotel-mapping');
                    this.show = true ;
                    setTimeout(() => {
                        this.show = false ;

                    }, "2000")
                }).catch((error)=>{
                    console.log(error.response.data);
                    this.errors = error.response.data.errors;
                    this.message = error.response.data.message;
                    this.show = false ;
                });
            }



        },
    },


}
</script>

