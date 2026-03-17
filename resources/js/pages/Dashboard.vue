<script setup lang="ts">
import { ref } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import ContainerCard from '@/components/ContainerCard.vue';
import NewInstance from '@/components/NewInstance.vue';
import CreateInstanceCard from '@/components/CreateInstanceCard.vue';

const showModal = ref(false);

const containers = Array.from({ length: 6 }, (_, i) => ({
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
                class="mt-4 rounded bg-blue-600 px-3 py-1 text-white w-fit"
                @click="router.post(`/containers/sync`)"
            >
                sync
            </button>
            <div class="grid gap-4 grid-cols-1 md:grid-cols-3 lg:grid-cols-3 auto-rows-[250px]">
                <ContainerCard
                    v-for="container in containers"
                    :key="container.id"
                    :id="container.id"
                    :container_id="container.container_id.toString()"
                    :name="container.name"
                    :status="container.status"
                />
                <CreateInstanceCard @open="showModal = true" />
            </div>
        </div>

        <NewInstance v-if="showModal" @close="showModal = false" />
    </AppLayout>
</template>
