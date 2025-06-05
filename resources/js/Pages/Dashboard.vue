<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';

import { ref, computed, watch } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { useToast } from 'vue-toastification';

const { props } = usePage();
const toast = useToast();

const form = useForm({
    projectId: '',
    blockId: '',
    pieceId: '',
    theoreticalWeight: '',
    realWeight: '',
    difference: ''
});

const projects = ref(props.projects || []);

const blocks = computed(() => {
    if (!form.projectId) return [];
    const project = projects.value.find(p => p.id === form.projectId);
    return project ? project.blocks : [];
});

const pieces = computed(() => {
    if (!form.blockId) return [];
    const block = blocks.value.find(b => b.id === form.blockId);
    return block ? block.pieces : [];
});

watch(() => form.projectId, () => {
    form.blockId = '';
    form.pieceId = '';
    form.theoreticalWeight = '';
    form.realWeight = '';
    form.difference = '';
    form.clearErrors();
});

watch(() => form.blockId, () => {
    form.pieceId = '';
    form.theoreticalWeight = '';
    form.realWeight = '';
    form.difference = '';
    form.clearErrors();
});

watch(() => form.pieceId, () => {
    if (!form.pieceId) {
        form.theoreticalWeight = '';
        form.realWeight = '';
        form.difference = '';
        form.clearErrors();
        return;
    }

    const pieceObj = pieces.value.find(p => p.id === form.pieceId);

    form.theoreticalWeight = pieceObj ? pieceObj.theoretical_weight : '';
    form.realWeight = '';
    form.difference = '';
    form.clearErrors();
});

watch(() => form.realWeight, () => {
    if (form.theoreticalWeight && form.realWeight !== '') {
        form.difference = (form.theoreticalWeight - form.realWeight).toFixed(2);
    } else {
        form.difference = '';
    }
});

function submitForm() {
    if (!form.projectId) {
        toast.error('Debe seleccionar un proyecto');
        return;
    }
    if (!form.blockId) {
        toast.error('Debe seleccionar un bloque');
        return;
    }
    if (!form.pieceId) {
        toast.error('Debe seleccionar una pieza');
        return;
    }
    if (form.realWeight === '' || form.realWeight === null) {
        toast.error('Debe ingresar el peso real');
        return;
    }
    if (isNaN(form.realWeight) || Number(form.realWeight) < 0) {
        toast.error('El peso real debe ser un número positivo');
        return;
    }

    form.post(route('dashboard.store'), {
        onSuccess: () => {
            toast.success('Datos registrados correctamente');
            form.reset();
        },
        onError: () => {
            toast.error('Error al registrar los datos');
        }
    });
}
</script>

<template>
    <AppLayout title="Proyectos">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Formulario principal
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg lg:grid lg:gap-4">

                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Bienvenido al formulario principal</h3>

                        <form @submit.prevent="submitForm">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
                                <div class="mt-4">
                                    <InputLabel for="projects" value="Proyectos" />
                                    <select id="projects" v-model="form.projectId"
                                        class="mt-1 block py-3 w-full border-gray-300 rounded-md cursor-pointer shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">Selecciona un proyecto</option>
                                        <option v-for="project in projects" :key="project.id" :value="project.id">
                                            {{ project.name }}
                                        </option>
                                    </select>
                                    <InputError :message="form.errors.projectId" class="mt-2" />
                                </div>

                                <div class="mt-4">
                                    <InputLabel for="blocks" value="Bloques" />
                                    <select id="blocks" v-model="form.blockId"
                                        class="mt-1 block py-3 w-full border-gray-300 rounded-md cursor-pointer shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">Selecciona un bloque</option>
                                        <option v-for="block in blocks" :key="block.id" :value="block.id">
                                            {{ block.name }}
                                        </option>
                                    </select>
                                    <InputError :message="form.errors.blockId" class="mt-2" />
                                </div>

                                <div class="mt-4">
                                    <InputLabel for="pieces" value="Piezas" />
                                    <select id="pieces" v-model="form.pieceId"
                                        class="mt-1 block py-3 w-full border-gray-300 rounded-md cursor-pointer shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">Selecciona una pieza</option>
                                        <option v-for="piece in pieces" :key="piece.id" :value="piece.id">
                                            {{ piece.code }}
                                        </option>
                                    </select>
                                    <InputError :message="form.errors.pieceId" class="mt-2" />
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
                                <div class="mt-4">
                                    <InputLabel for="theoreticalWeight" value="Peso teórico" />
                                    <TextInput id="theoreticalWeight" type="number" class="mt-1 block w-full"
                                        v-model="form.theoreticalWeight" disabled />
                                </div>

                                <div class="mt-4">
                                    <InputLabel for="realWeight" value="Peso real" />
                                    <TextInput id="realWeight" type="number" class="mt-1 block w-full"
                                        v-model="form.realWeight" required
                                        :class="{ 'border-red-500': form.errors.realWeight }" />
                                    <InputError :message="form.errors.realWeight" class="mt-2" />
                                </div>

                                <div class="mt-4">
                                    <InputLabel for="difference" value="Diferencia peso teórico - real" />
                                    <TextInput id="difference" type="number" class="mt-1 block w-full"
                                        v-model="form.difference" disabled />
                                </div>
                            </div>

                            <div class="flex items-center justify-center mt-4">
                                <button type="submit"
                                    class="w-1/2 mt-6 inline-flex items-center justify-center px-4 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-600 focus:outline-none focus:border-blue-700 focus:ring ring-blue-200 disabled:opacity-25 transition ease-in-out duration-150">
                                    Registrar datos
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3">IdPieza</th>
                                    <th class="px-6 py-3">Pieza</th>
                                    <th class="px-6 py-3">Peso teórico</th>
                                    <th class="px-6 py-3">Peso real</th>
                                    <th class="px-6 py-3">Estado</th>
                                    <th class="px-6 py-3">IdBloque</th>
                                    <th class="px-6 py-3">Fecha de registro</th>
                                    <th class="px-6 py-3">Registrado por</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="piece in pieces" :key="piece.id" class="bg-white border-b border-gray-200">
                                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">{{ piece.id }}
                                    </td>
                                    <td class="px-6 py-4">{{ piece.code }}</td>
                                    <td class="px-6 py-4">{{ piece.theoretical_weight }}</td>
                                    <td class="px-6 py-4">{{ piece.real_weight ?? '-' }}</td>
                                    <td class="px-6 py-4">{{ piece.status }}</td>
                                    <td class="px-6 py-4">{{ piece.block_id }}</td>
                                    <td class="px-6 py-4">{{ piece.created_at }}</td>
                                    <td class="px-6 py-4">{{ piece.registeredBy ? piece.registeredBy.name : '-' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </AppLayout>
</template>
