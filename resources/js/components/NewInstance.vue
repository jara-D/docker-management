<script setup lang="ts">
import { ref } from 'vue';

const emit = defineEmits<{ close: [] }>();

const name = ref('');
const yaml = ref('');
const file = ref<File | null>(null);
const fileInput = ref<HTMLInputElement | null>(null);

const handleFile = (e: Event) => {
    const target = e.target as HTMLInputElement;
    file.value = target.files?.[0] ?? null;
};

const handleDrop = (e: DragEvent) => {
    e.preventDefault();
    file.value = e.dataTransfer?.files?.[0] ?? null;
};
</script>

<template>
    <!-- Backdrop -->
    <div
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 backdrop-blur-sm"
        @click.self="emit('close')"
    >
        <!-- Modal -->
        <div class="relative w-full max-w-lg mx-4 bg-sidebar rounded-xl border border-gray-700 shadow-2xl p-6 flex flex-col gap-4">

            <!-- Header -->
            <div class="flex items-center justify-center">
                <h2 class="text-white text-2xl font-semibold text-center">New Instance</h2>
                <button
                    class="absolute right-4 top-4 text-gray-400 hover:text-white transition-colors text-2xl leading-none"
                    @click="emit('close')"
                >&times;</button>
            </div>

            <!-- Two column layout -->
            <div class="grid grid-cols-2 gap-4">

                <!-- Left: Add a file -->
                <div class="flex flex-col gap-2">
                    <label class="text-sm text-gray-300">Add a file:</label>
                    <input ref="fileInput" type="file" class="hidden" @change="handleFile">
                    <div
                        class="flex-1 min-h-36 flex flex-col items-center justify-center border border-gray-600 bg-gray-900 rounded-lg text-sm text-gray-400 cursor-pointer hover:border-gray-400 transition-colors"
                        @click="fileInput?.click()"
                        @dragover.prevent
                        @drop="handleDrop"
                    >
                        <span v-if="file" class="text-white text-xs px-2 text-center break-all">{{ file.name }}</span>
                        <template v-else>
                            <span>Drag & drop</span>
                            <span>or <span class="text-blue-400 hover:underline">browse</span></span>
                        </template>
                    </div>
                </div>

                <!-- Right: Name + Yaml -->
                <div class="flex flex-col gap-3">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm text-gray-300">Name:</label>
                        <input
                            v-model="name"
                            type="text"
                            class="bg-gray-900 border border-gray-600 focus:border-gray-400 rounded px-3 py-1.5 text-white text-sm outline-none transition-colors"
                        >
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm text-gray-300">Yaml:</label>
                        <textarea
                            v-model="yaml"
                            rows="4"
                            class="bg-gray-900 border border-gray-600 focus:border-gray-400 rounded px-3 py-1.5 text-white text-sm outline-none transition-colors resize-none font-mono"
                        />
                    </div>
                </div>
            </div>

            <div class="flex justify-center">
                <button
                    class="w-fit bg-gray-200 hover:bg-white text-gray-900 font-medium px-4 py-1.5 rounded transition-colors text-sm"
                    @click="emit('close')"
                >
                    Create Instance
                </button>
            </div>
        </div>
    </div>
</template>