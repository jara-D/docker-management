<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';
import projectsRoute from '@/routes/projects';
import { usePage } from '@inertiajs/vue3';
import { Card } from '@/components/ui/card';
import Health from '@/components/Health.vue';
import Delete from '@/components/container/actions/delete.vue';

const page = usePage();
const project = page.props.project;

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Projects',
        href: projectsRoute.index.url(),
    },
    {
        title: project.name,
        href: projectsRoute.status.url(project.id),
    },
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="grid auto-rows-max grid-cols-1 gap-4 md:grid-cols-3 lg:grid-cols-3"
        >
            <card class="max-w-sm gap-1 p-3">
                <h1 class="text-2xl font-bold">Health</h1>
                <health
                    v-for="container in project.containers"
                    :key="container.id"
                    :name="container.name"
                    :state="container.state"
                    :id="container.id"
                />
            </card>
            <card class="max-w-sm gap-1 p-3">
                <h1 class="text-2xl font-bold">Actions</h1>
                <delete :project="project.name"/>
            </card>
        </div>
    </AppLayout>
</template>

<style scoped></style>
