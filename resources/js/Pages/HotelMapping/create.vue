<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import JetNavLink from '@/Components/NavLink.vue';
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
               ADD Hotel Mapping
            </h2>
        </template>


        <div class="overflow-x-auto">
            <div class="min-w-screen min-h-screen bg-gray-100 flex  justify-center bg-gray-100 font-sans overflow-hidden">
                <div class="w-full lg:w-5/6 m-10">

                    <select @change="changeHotel" v-model="hotel"   placeholder="Select a person..."  autocomplete="off">
                        <option value="">Select a Hotel...</option>
                        <option v-for=" hotel in hotels" :value="hotel.hotel_id">{{hotel.name}}</option>
                    </select>

                    <div v-if="show"  class=" mt-5  max-w-9xl w-full bg-green-500 shadow-lg rounded-lg pointer-events-auto flex ring-1 ring-black ring-opacity-5 divide-x divide-gray-200 ">
                        <div class="w-0 flex-1 flex items-center p-4">
                            <div class="w-full">
                                <p class="mt-1 text-sm text-white">Create with success</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white shadow-md rounded my-6">
                        <table class="min-w-max w-full table-auto">
                            <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left">Room Type</th>
                                <th class="py-3 px-6 text-center">Names</th>
                            </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-light">
                            <tr v-for="(room ,index) in array_rooms " class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="font-medium">{{room.name}}</span>
                                    </div>
                                </td>

                                <td class="py-3 px-6 text-center">
                                    <div class="flex item-center justify-center">
                                        <input class="focus:ring-indigo-500 focus:border-indigo-500 block w-full  sm:text-sm border-gray-300 rounded-md"  type="text" v-model="room.names" >
                                    </div>
                                    <div v-if="errors['rooms.' + index + '.names']" class="flex item-left justify-center">
                                        <h1 class="text-red-500" v-if="errors['rooms.'+index+'.names']">{{ errors['rooms.' + index + '.names'][0] }}</h1>
                                    </div>
                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>

                    <h1 class="text-red-500" v-if="this.message">{{ this.message }}</h1>
                    <button v-if="array_rooms.length != 0  " @click="save" type="button" class="inline-flex items-center mt-2  px-6 py-3 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Save Change</button>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
<script >
import axios from 'axios';
// Import the CSS or use your own!
export default {
    props: {
        hotels : Array ,
        rooms : Array ,
    },

    data() {
        return {
            TomSelect : {} ,
            errors : {} ,
            message : '' ,
            hotel:'',
            array_rooms :[] ,
            mappings_rooms :[],
            show : false ,

        }
    },
    setup () {

    },
    methods: {
        changeHotel(){
            this.array_rooms = [];
            this.rooms.find(room => {
                if (room.hotel_id  === this.hotel) {
                    room.names = "";
                    this.array_rooms.push(room);
                }
            });
        },

        save(){

            axios.post('/hotel-mapping', {
                rooms: this.array_rooms ,
            }).then( (response ) =>  {
                this.errors = {};
                this.message = '';
                this.show = true ;
                setTimeout(() => {
                    this.show = false ;
                    this.$inertia.get('/hotel-mapping');
                }, "1000")


            })
                .catch((error)=>{
                    console.log(error.response.data);
                    this.errors = error.response.data.errors;
                    this.message = error.response.data.message;
                    this.show = false ;
                });
          }


    },

    watch: {
    },
    mounted() {

    }
}


</script>

