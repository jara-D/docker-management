<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import projectsRoute from '@/routes/projects';
import { router, usePage } from '@inertiajs/vue3';
import { Card } from '@/components/ui/card';
import Health from '@/components/Health.vue';
import Delete from '@/components/container/actions/delete.vue';
import { FolderOpen, LayoutDashboard } from 'lucide-vue-next';
import { useNavigation } from '@/composables/useNavigation';
import { BreadcrumbItem } from '@/types';

const page = usePage();
const project = page.props.project;

function deleteProject() {
    router.post(projectsRoute.delete(project.id));
}

const { setNavigation } = useNavigation();

setNavigation([
    { title: 'Back', href: projectsRoute.index.url(), icon: LayoutDashboard },
    { title: 'Status', href: projectsRoute.status.url(project.id), icon: FolderOpen },
]);

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
                <delete :project="project.name" />

                <button
                    class="rounded bg-red-600 px-3 py-1 text-white"
                    @click="deleteProject"
                >
                    Delete
                </button>
            </card>
        </div>
    </AppLayout>
</template>

<style scoped></style>
