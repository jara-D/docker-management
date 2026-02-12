<!-- <script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head, usePage, router } from '@inertiajs/vue3';

const page = usePage();
const containers = page.props.containers;

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboards',
        href: dashboard().url,
    },
];
</script>

<template>
    <Head title="Dashboard" />button

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <button
                class="mt-4 rounded bg-blue-600 px-3 py-1 text-white"
                @click="router.post(`/containers/sync`)"
            >
                sync
            </button>
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div
                    v-for="{
                        id,
                        container_id,
                        image,
                        name,
                        status,
                    } in containers"
                    :key="id"
                    class="relative aspect-video overflow-hidden rounded-xl border p-4"
                >
                    <h2 class="text-lg font-semibold">
                        {{ name }}
                    </h2>

                    <p class="text-sm text-gray-500">Image: {{ image }}</p>

                    <p class="text-sm text-gray-500">Status: {{ status }}</p>

                    <button
                        class="mt-4 rounded bg-blue-600 px-3 py-1 text-white"
                        @click="
                            router.post(`/containers/${container_id}/start`)
                        "
                    >
                        Start
                    </button>
                    <button
                        class="mt-4 rounded bg-blue-600 px-3 py-1 text-white"
                        @click="router.post(`/containers/${container_id}/stop`)"
                    >
                        stop
                    </button>
                </div>
            </div>
        </div>
    </AppLayout>
</template> -->

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head, usePage, router } from '@inertiajs/vue3';

const page = usePage();
const containers = page.props.containers;

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboards',
        href: dashboard().url,
    },
];

// Function to get a clean container name
const getContainerName = (name: string) => {
    // If name contains slashes or looks like an ID, try to extract a cleaner name
    if (name.includes('/')) {
        return name.split('/').pop() || name;
    }
    return name;
};
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <button
                class="mt-4 rounded bg-blue-600 px-3 py-1 text-white"
                @click="router.post(`/containers/sync`)"
            >
                sync
            </button>
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div
                    v-for="{
                        id,
                        container_id,
                        //image,
                        name,
                        status,
                    } in containers"
                    :key="id"
                    class="relative overflow-hidden rounded-xl bg-gray-200 p-6"
                >
                    <!-- Container names in 2x2 grid -->
                    <div class="mb-8 grid grid-cols-2 gap-x-2 gap-y-1">
                        <div class="text-base font-medium text-gray-800 truncate">
                            {{ getContainerName(name) }}
                        </div>
                        <div class="text-base font-medium text-gray-800 truncate">
                            {{ getContainerName(name) }}
                        </div>
                        <div class="text-base font-medium text-gray-800 truncate">
                            {{ getContainerName(name) }}
                        </div>
                        <div class="text-base font-medium text-gray-800 truncate">
                            {{ getContainerName(name) }}
                        </div>
                    </div>

                    <!-- Status section -->
                    <div class="space-y-3">
                        <p class="text-sm text-gray-700">
                            Status: {{ status }}
                        </p>

                        <!-- Diamond icons row -->
                        <div class="flex gap-0">
                            <div
                                v-for="i in 7"
                                :key="i"
                                class="h-6 w-6 rotate-45 border-2 border-gray-600 bg-gray-400"
                            ></div>
                        </div>

                        <!-- Action buttons -->
                        <div class="flex gap-2 pt-2">
                            <button
                                class="rounded bg-blue-600 px-3 py-1 text-sm text-white hover:bg-blue-700"
                                @click="router.post(`/containers/${container_id}/start`)"
                            >
                                Start
                            </button>
                            <button
                                class="rounded bg-red-600 px-3 py-1 text-sm text-white hover:bg-red-700"
                                @click="router.post(`/containers/${container_id}/stop`)"
                            >
                                Stop
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
