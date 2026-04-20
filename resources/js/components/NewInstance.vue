<script setup lang="ts">
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

const emit = defineEmits<{ close: [] }>();

const fileInput = ref<HTMLInputElement | null>(null);

const form = useForm({
    projectName: '',
    yaml: '',
    file: null as File | null,
});

const handleFile = (e: Event) => {
    const target = e.target as HTMLInputElement;
    form.file = target.files?.[0] ?? null;
};

const handleDrop = (e: DragEvent) => {
    e.preventDefault();
    form.file = e.dataTransfer?.files?.[0] ?? null;
};
</script>

<template>
    <div
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 backdrop-blur-sm"
        @click.self="emit('close')"
    >
        <Form
            @submit.prevent="
                form.post('/containers/compose/up', {
                    forceFormData: true,
                    onSuccess: () => emit('close'),
                })
            "
            class="relative mx-4 flex w-full max-w-lg flex-col gap-4 rounded-xl border border-gray-700 bg-sidebar p-6 shadow-2xl"
        >
            <div class="flex items-center justify-center">
                <h2 class="text-center text-2xl font-semibold text-white">
                    New Instance
                </h2>
                <button
                    class="absolute top-4 right-4 text-2xl leading-none text-gray-400 transition-colors hover:text-white"
                    @click="emit('close')"
                >
                    &times;
                </button>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <!-- File Upload -->
                <div class="flex flex-col gap-2">
                    <label class="text-sm text-gray-300">Add a file:</label>

                    <input
                        ref="fileInput"
                        type="file"
                        class="hidden"
                        @change="handleFile"
                    />

                    <div
                        class="flex min-h-36 flex-1 cursor-pointer flex-col items-center justify-center rounded-lg border border-gray-600 bg-gray-900 text-sm text-gray-400 transition-colors hover:border-gray-400"
                        @click="fileInput?.click()"
                        @dragover.prevent
                        @drop="handleDrop"
                    >
                        <span
                            v-if="form.file"
                            class="px-2 text-center text-xs break-all text-white"
                        >
                            {{ form.file.name }}
                        </span>

                        <template v-else>
                            <span>Drag & drop</span>
                            <span
                                >or
                                <span class="text-blue-400 hover:underline"
                                    >browse</span
                                ></span
                            >
                        </template>
                    </div>
                </div>

                <!-- Name + YAML -->
                <div class="flex flex-col gap-3">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm text-gray-300">Name:</label>
                        <input
                            v-model="form.projectName"
                            type="text"
                            required
                            class="rounded border border-gray-600 bg-gray-900 px-3 py-1.5 text-sm text-white transition-colors outline-none focus:border-gray-400"
                        />
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm text-gray-300">Yaml:</label>
                        <textarea
                            v-model="form.yaml"
                            rows="4"
                            class="resize-none rounded border border-gray-600 bg-gray-900 px-3 py-1.5 font-mono text-sm text-white transition-colors outline-none focus:border-gray-400"
                        />
                    </div>
                </div>
            </div>

            <div class="flex justify-center">
                <button
                    type="submit"
                    class="w-fit rounded bg-gray-200 px-4 py-1.5 text-sm font-medium text-gray-900 transition-colors hover:bg-white"
                >
                    Create Instance
                </button>
            </div>
        </Form>
    </div>
</template>
