<template>
    <AppLayout title="Piezas pendientes">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Piezas pendientes
            </h2>
        </template>

        <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div v-if="projects.length === 0" class="text-center text-gray-600">

                </div>

                <div v-for="project in projects" :key="project.id" class="mb-6">
                    <h3 class="text-lg font-semibold mb-2">{{ project.name }}</h3>
                    <ul class="list-disc list-inside">
                        <li v-for="block in project.blocks" :key="block.id" class="ml-4 mb-2">
                            <span class="font-medium">{{ block.name }}</span>
                            <ul class="list-decimal list-inside ml-6 mt-1">
                                <li v-for="piece in block.pieces" :key="piece.id" class="text-gray-700">
                                    {{ piece.code }} - Status: {{ piece.status }}
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref } from 'vue'
import { usePage } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

const { props } = usePage()
const projects = ref(props.projects || [])
</script>
