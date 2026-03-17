<template>
    <div
        class="relative overflow-hidden rounded-xl bg-sidebar p-4 md:p-6 flex flex-col items-center justify-center min-h-40 md:min-h-48 cursor-pointer hover:bg-gray-700 transition-colors border-2 border-dashed border-gray-600 hover:border-gray-400"
        @click="emit('open')"
    >
        <span class="text-4xl text-gray-400 mb-2">+</span>
        <p class="text-white text-lg md:text-2xl font-normal">Create Instance</p>
    </div>
</template>

<script setup lang="ts">
const emit = defineEmits<{ open: [] }>();
</script>
