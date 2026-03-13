<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head, usePage, router } from '@inertiajs/vue3';
import ContainerCard from '@/components/ContainerCard.vue';

// eslint-disable-next-line @typescript-eslint/no-unused-vars
interface Container {
    id: number;
    container_id: string;
    name: string;
    status: string;
}

// eslint-disable-next-line @typescript-eslint/no-unused-vars
const page = usePage();
const containers = Array.from({ length: 1000 }, (_, i) => ({
    id: i + 1,
    container_id: i + 1,
    image: `image-${i + 1}`,
    name: `Container ${i + 1}`,
    status: "stopped",
}));

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboards',
        href: dashboard().url,
    },
];
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <button
                class="mt-4 rounded bg-blue-600 px-3 py-1 text-white"
                @click="router.post(`/containers/sync`)"
            >
                sync
            </button>
            <div class="grid auto-rows-min gap-4 grid-cols-1 md:grid-cols-3 lg:grid-cols-3">
                <!-- <div class="grid auto-rows-min gap-4 md:grid-cols-auto"></div> -->
                <ContainerCard
                    v-for="container in containers"
                    :key="container.id"
                    :id="container.id"
                    :container_id="container.container_id.toString()"
                    :name="container.name"
                    :status="container.status"
                />
            </div>
        </div>
    </AppLayout>
</template>
