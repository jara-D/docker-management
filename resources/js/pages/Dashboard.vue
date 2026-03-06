<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head, usePage, router, Form } from '@inertiajs/vue3';
import { Input } from '@/components/ui/input';
import { Button } from '@/components/ui/button';
import { reactive } from 'vue';

const page = usePage();
const containers = page.props.containers;

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboards',
        href: dashboard().url,
    },
];

const form = reactive({ projectName: '', yaml: '' });
const submit = () => {
    router.post('/containers/compose/up', form);
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
            <Form @submit.prevent="submit">
                <Input name="projectName" v-model="form.projectName" />
                <textarea name="yaml" v-model="form.yaml"></textarea>

                <Button type="submit">Submit</Button>
            </Form>

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
</template>
