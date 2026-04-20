<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import playIcon from '/resources/images/play.svg'
import stopIcon from '/resources/images/stop.svg'
import placeholderIcon from '/resources/images/placeholder.svg'

const props = defineProps<{
    id: number;
    container_id: string;
    name: string;
    status: string;
}>();

const containerName = props.name.includes('/')
    ? props.name.split('/').pop() || props.name
    : props.name;

const stop = () => router.post(`/containers/${props.container_id}/stop`);
const start = () => router.post(`/containers/${props.container_id}/start`);
</script>

<template>
    <div class="relative overflow-hidden rounded-xl bg-sidebar p-4 md:p-6 flex flex-col min-h-40 md:min-h-48">
        <div class="mb-4 md:mb-6">
            <div class="text-lg md:text-2xl font-normal leading-tight text-white truncate">
                {{ containerName }}
            </div>
        </div>
        
        <div class="space-y-2 mt-auto">
            <p class="text-xs md:text-sm text-gray-400">Status: {{ status }}</p>

            <div class="flex gap-0 border-2 border-gray-600 w-fit">
                <button class="h-8 w-8 md:h-10 md:w-10 bg-red-600 text-sm text-white hover:bg-red-700" @click="stop">
                    <img :src="stopIcon" alt="stop" class="w-full h-full">
                </button>

                <button v-for="_ in 5" class="h-8 w-8 md:h-10 md:w-10 bg-blue-600 text-sm text-white hover:bg-blue-700" @click="stop">
                    <img :src="placeholderIcon" alt="placeholder" class="w-full h-full">
                </button>

                <button class="h-8 w-8 md:h-10 md:w-10 bg-green-600 text-sm text-white hover:bg-green-700" @click="start">
                    <img :src="playIcon" alt="play" class="w-full h-full">
                </button>
            </div>
        </div>
    </div>
</template>