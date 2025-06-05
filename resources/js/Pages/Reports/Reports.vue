<template>
    <AppLayout title="Piezas pendientes">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Piezas pendientes
            </h2>
        </template>

        <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                <!-- Tabs -->
                <div class="mb-6 border-b border-gray-200">
                    <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                        <button :class="tab === 'list' ? activeClass : inactiveClass" @click="tab = 'list'">
                            Lista
                        </button>
                        <button :class="tab === 'chart' ? activeClass : inactiveClass" @click="tab = 'chart'">
                            Gráfico
                        </button>
                    </nav>

                    {{ console.log(projectsStats) }}
                </div>

                <!-- Contenido Tabs -->
                <div v-if="tab === 'list'">
                    <div v-if="projects.length === 0" class="text-center text-gray-600">
                        No hay proyectos pendientes.
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



                <div v-else-if="tab === 'chart'">
                    <!-- Aquí va tu componente gráfico, ejemplo: -->
                    <div v-if="projectsStats.length === 0" class="text-center text-gray-600">
                        No hay datos para mostrar en el gráfico.
                    </div>

                    <div v-for="stat in projectsStats" :key="stat.id" class="mb-8 max-w-md">
                        <h3 class="font-semibold mb-4">{{ stat.name }}</h3>
                        <PieChart :pending="stat.pending_count" :fabricated="stat.fabricated_count" />
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref } from 'vue'
import { usePage } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import PieChart from '@/Components/PieChart.vue' // tu componente gráfico, ajústalo a tu ruta

const { props } = usePage()

// Tab activo
const tab = ref('list')

// Datos para cada tab
const projects = ref(props.projectsPending || [])
const projectsStats = ref(props.projectsStats || [])

// Clases tailwind para tabs activas / inactivas
const activeClass = 'border-indigo-500 text-indigo-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm'
const inactiveClass = 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm'
</script>
