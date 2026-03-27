<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import compose from '@/routes/containers/compose';

const props = defineProps({
    project: String,
});

function composeDown() {
    if (!props.project) return;

    router.post(compose.down(props.project));
}
</script>

<template>
    <button
        class="rounded bg-red-600 px-3 py-1 text-white"
        @click="composeDown"
    >
        Compose Down
    </button>
</template>
2
