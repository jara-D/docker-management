<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import playIcon from '/resources/images/play.svg'
import stopIcon from '/resources/images/stop.svg'
import placeholderIcon from '/resources/images/placeholder.svg'

interface Props {
    id: number;
    container_id: string;
    name: string;
    status: string;
}

// eslint-disable-next-line @typescript-eslint/no-unused-vars
const props = defineProps<Props>();

const getContainerName = (name: string) => {
    if (name.includes('/')) {
        return name.split('/').pop() || name;
    }
    return name;
};
console.log("v8")
</script>

<template>
    <div class="relative overflow-hidden rounded-xl bg-gray-200 p-6">
        <!-- Container names in 2x2 grid - no gaps between text -->
        <div class="mb-6">
            <div class="text-2xl font-normal leading-tight text-gray-900">
                {{ getContainerName(name) }} {{ getContainerName(name) }}
            </div>
            <div class="text-2xl font-normal leading-tight text-gray-900">
                {{ getContainerName(name) }} {{ getContainerName(name) }}
            </div>
        </div>

        <!-- Status section -->
        <div class="space-y-2">
            <p class="text-sm text-gray-700">
                Status: {{ status }}
            </p>

            <!-- Diamond icons row -->
            <div class="flex gap-0 border-2 border-gray-600 w-fit">
                <button class="h-6 w-6 bg-gray-400 bg-red-600 text-sm text-white hover:bg-red-700"
                    @click="router.post(`/containers/${container_id}/stop`)">
                    <img :src="stopIcon" alt="stop">
                </button>

                <button class="h-6 w-6 bg-blue-400 bg-blue-600 text-sm text-white hover:bg-blue-700"
                    @click="router.post(`/containers/${container_id}/stop`)">
                    <img :src="placeholderIcon" alt="placeholder">
                </button>
                <button class="h-6 w-6 bg-blue-400 bg-blue-600 text-sm text-white hover:bg-blue-700"
                    @click="router.post(`/containers/${container_id}/stop`)">
                    <img :src="placeholderIcon" alt="placeholder">
                </button>
                <button class="h-6 w-6 bg-blue-400 bg-blue-600 text-sm text-white hover:bg-blue-700"
                    @click="router.post(`/containers/${container_id}/stop`)">
                    <img :src="placeholderIcon" alt="placeholder">
                </button>
                <button class="h-6 w-6 bg-blue-400 bg-blue-600 text-sm text-white hover:bg-blue-700"
                    @click="router.post(`/containers/${container_id}/stop`)">
                    <img :src="placeholderIcon" alt="placeholder">
                </button>
                <button class="h-6 w-6 bg-blue-400 bg-blue-600 text-sm text-white hover:bg-blue-700"
                    @click="router.post(`/containers/${container_id}/stop`)">
                    <img :src="placeholderIcon" alt="placeholder">
                </button>

                <button class="h-6 w-6 bg-gray-400 bg-green-600 text-sm text-white hover:bg-green-700"
                    @click="router.post(`/containers/${container_id}/start`)">
                    <img :src="playIcon" alt="play">
                </button>

                <!-- <div v-for="i in 7" :key="i" class="h-6 w-6 bg-gray-400">
                    <button class="bg-blue-600 text-sm text-white hover:bg-blue-700"
                        @click="router.post(`/containers/${container_id}/start`)">
                        <img :src="playIcon" alt="play">
                    </button>
                </div> -->
            </div>

            <!-- Action buttons -->
            <!-- <div class="flex gap-2 pt-2">
                <button class="rounded bg-blue-600 px-3 py-1 text-sm text-white hover:bg-blue-700"
                    @click="router.post(`/containers/${container_id}/start`)">
                    Start
                </button>
                <button class="rounded bg-red-600 px-3 py-1 text-sm text-white hover:bg-red-700"
                    @click="router.post(`/containers/${container_id}/stop`)">
                    Stop
                </button>
            </div> -->
        </div>
    </div>
</template>
