<script setup lang="ts">
import { computed, ref } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, router, usePage } from '@inertiajs/vue3';
import NewInstance from '@/components/NewInstance.vue';
import CreateInstanceCard from '@/components/CreateInstanceCard.vue';
import ProjectCard from '@/components/ProjectCard.vue';
import projectsRoute from '@/routes/projects';

const showModal = ref(false);

const page = usePage();
const projects = computed(() => page.props.projects);

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Projects',
        href: projectsRoute.index.url(),
    },
];
</script>

<template>
    <Head title="Projects" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto">
            <button
                class="mt-4 w-fit rounded bg-blue-600 px-3 py-1 text-white"
                @click="router.post(`/containers/sync`)"
            >
                sync
            </button>
            <div
                class="grid auto-rows-[250px] grid-cols-1 gap-4 md:grid-cols-3 lg:grid-cols-3"
            >
                <ProjectCard
                    v-for="project in projects"
                    :key="project.id"
                    :id="project.id"
                    :name="project.name"
                    :state="project.state"
                />

                <CreateInstanceCard @open="showModal = true" />
            </div>
        </div>

        <NewInstance v-if="showModal" @close="showModal = false" />
    </AppLayout>
</template>
