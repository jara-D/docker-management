<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import playIcon from '/resources/images/play.svg';
import stopIcon from '/resources/images/stop.svg';
import placeholderIcon from '/resources/images/placeholder.svg';
import trashIcon from '/resources/images/trash.svg';

const props = defineProps<{
    id: number;
    container_id: string;
    name: string;
    status: string;
}>();

const containerName = props.name ? props.name.replace(/^\//, '') : 'unknown';

const stop = () => router.post(`/containers/${props.container_id}/stop`);
const start = () => router.post(`/containers/${props.container_id}/start`);
const deleteContainer = () =>
    router.delete(`/containers/${props.container_id}`);
</script>

<template>
    <div
        class="relative flex min-h-40 flex-col overflow-hidden rounded-xl bg-sidebar p-4 md:min-h-48 md:p-6"
    >
        <div class="mb-4 md:mb-6">
            <div
                class="truncate text-lg leading-tight font-normal text-white md:text-2xl"
            >
                {{ containerName }}
            </div>
        </div>

        <div class="mt-auto space-y-2">
            <p class="text-xs text-gray-400 md:text-sm">Status: {{ status }}</p>

            <div class="flex w-fit gap-0 border-2 border-gray-600">
                <button
                    class="h-8 w-8 bg-red-600 text-sm text-white hover:bg-red-700 md:h-10 md:w-10"
                    @click="stop"
                >
                    <img :src="stopIcon" alt="stop" class="h-full w-full" />
                </button>
                <button
                    class="h-8 w-8 bg-red-600 text-sm text-white hover:bg-red-700 md:h-10 md:w-10"
                    @click="deleteContainer"
                >
                    <img :src="trashIcon" alt="stop" class="h-full w-full" />
                </button>

                <button
                    v-for="(_, i) in 2"
                    :key="i"
                    class="h-8 w-8 bg-blue-600 text-sm text-white hover:bg-blue-700 md:h-10 md:w-10"
                    @click="stop"
                >
                    <img
                        :src="placeholderIcon"
                        alt="placeholder"
                        class="h-full w-full"
                    />
                </button>

                <button
                    class="h-8 w-8 bg-green-600 text-sm text-white hover:bg-green-700 md:h-10 md:w-10"
                    @click="start"
                >
                    <img :src="playIcon" alt="play" class="h-full w-full" />
                </button>
            </div>
        </div>
    </div>
</template>
