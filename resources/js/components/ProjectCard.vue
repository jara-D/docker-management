<script setup lang="ts">
import { computed } from 'vue';
import stopIcon from '/resources/images/stop.svg';
import playIcon from '/resources/images/play.svg';
import settingsIcon from '/resources/images/settings.svg';
import { Link, router } from '@inertiajs/vue3';

const props = defineProps<{
    id: number;
    name: string;
    state: string;
}>();

const stateClass = computed(() => {
    switch (props.state) {
        case 'healthy':
            return 'border-green-500';
        case 'degraded':
            return 'border-yellow-500';
        case 'stopped':
            return 'border-red-500';
        default:
            return 'border-gray-600';
    }
});

const stop = () => router.post(`/projects/${props.id}/stop`);
const start = () => router.post(`/containers/${props.id}/start`);
</script>

<template>
    <div
        class="relative flex min-h-40 flex-col overflow-hidden rounded-xl border-s-12 bg-sidebar p-4 md:min-h-48 md:p-6"
        :class="stateClass"
    >
        <!-- Top content -->
        <div class="mb-4 flex items-center justify-between md:mb-6">
            <!-- Name -->
            <div
                class="truncate text-lg leading-tight font-normal text-white md:text-2xl"
            >
                {{ props.name }}
            </div>

            <!-- Button on the right -->
            <Link
                :href="`/projects/${props.id}`"
                class="h-8 w-8 rounded-lg bg-blue-600 hover:bg-blue-700 md:h-10 md:w-10"
            >
                <img :src="settingsIcon" alt="icon" class="h-full w-full p-1" />

            </Link>
        </div>

        <!-- Bottom-right buttons -->
        <div class="mt-auto flex justify-end">
            <div class="flex w-fit gap-0">
                <button
                    class="h-8 w-8 rounded-l-lg bg-red-600 text-sm text-white hover:bg-red-700 md:h-10 md:w-10"
                    @click="stop"
                >
                    <img
                        :src="stopIcon"
                        alt="stop"
                        class="h-full w-full text-white"
                    />
                </button>

                <button
                    class="h-8 w-8 rounded-r-lg bg-green-600 text-sm text-white hover:bg-green-700 md:h-10 md:w-10"
                    @click="start"
                >
                    <img
                        :src="playIcon"
                        alt="play"
                        class="h-full w-full text-white"
                    />
                </button>
            </div>
        </div>
    </div>
</template>
