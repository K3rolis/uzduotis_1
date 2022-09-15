<script setup>
import {useForm} from '@inertiajs/inertia-vue3';
import {ref} from 'vue';

const form = useForm({
    file: null
})

let imageFile = ref("");

function handleImageSelected(event) {
    console.log(event)
    if (event.target.files.length === 0) {
        return;
    }
    imageFile.value = event.target.files[0];
}

const props = defineProps({
    result: Array,
    notFound: String,
    errors: Object
})

</script>


<template>
    <div class="max-w-3xl mx-auto">
        <div class="flex justify-center mx-auto my-12 items-center">
            <form @submit.prevent="form.post(route('update'))">
                <input class="block w-full text-sm text-gray-500 file:py-2 file:px-6 file:rounded file:border-1 file:border-gray-400"
                    type="file" name="file" @input="form.file = $event.target.files[0]"/>
                <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                    {{ form.progress.percentage }}%
                </progress>
                <button type="submit" class="w-full my-3 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full">Submit</button>
                <div v-if="errors.file" class="text-red-600">
                    {{ errors.file }}
                </div>
            </form>
        </div>

        <div v-if="result" class="text-center" v-for="resul in result">
            <li class="" style="list-style-type: none">{{ resul }}</li>
        </div>
        <div v-else>
            {{ notFound }}
        </div>

    </div>

</template>
