<template>
    <div>
        <canvas ref="canvas"></canvas>
    </div>
</template>

<script setup>
import { ref, watch, onMounted } from 'vue'
import { Pie } from 'vue-chartjs'
import {
    Chart,
    Title,
    Tooltip,
    Legend,
    ArcElement,
    CategoryScale,
} from 'chart.js'

Chart.register(Title, Tooltip, Legend, ArcElement, CategoryScale)

const props = defineProps({
    pending: { type: Number, required: true },
    fabricated: { type: Number, required: true },
})

const canvas = ref(null)
let chart = null

const createChart = () => {
    if (chart) {
        chart.destroy()
    }
    chart = new Chart(canvas.value.getContext('2d'), {
        type: 'pie',
        data: {
            labels: ['Pendientes', 'Fabricadas'],
            datasets: [
                {
                    label: 'Piezas',
                    data: [props.pending, props.fabricated],
                    backgroundColor: ['#3b82f6', '#10b981'],
                },
            ],
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' },
                title: {
                    display: true,
                    text: 'Piezas Pendientes vs Fabricadas',
                },
            },
        },
    })
}

onMounted(() => {
    createChart()
})

watch(() => [props.pending, props.fabricated], () => {
    createChart()
})
</script>
