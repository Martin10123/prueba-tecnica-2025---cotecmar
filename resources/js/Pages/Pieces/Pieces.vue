<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { useToast } from 'vue-toastification';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({
    pieces: Array,
    blocks: Array,
    authUser: Object,
});

const toast = useToast();

const form = useForm({
    code: '',
    theoretical_weight: '',
    real_weight: '',
    status: 'Pendiente',
    block_id: '',
});

const editMode = ref(false);
const editingPieceId = ref(null);

function startEdit(piece) {
    form.code = piece.code;
    form.theoretical_weight = piece.theoretical_weight;
    form.real_weight = piece.real_weight ?? '';
    form.status = piece.status;
    form.block_id = piece.block_id;
    editMode.value = true;
    editingPieceId.value = piece.id;
}

function cancelEdit() {
    form.reset();
    editMode.value = false;
    editingPieceId.value = null;
}

function submit() {
    if (editMode.value) {

        form.put(route('pieces.update', editingPieceId.value), {
            onSuccess: () => {
                cancelEdit();
                toast.success('Pieza actualizada exitosamente');
            },
            onError: () => {
                toast.error('Error al actualizar la pieza');
            },
        });
    } else {
        form.post(route('pieces.store'), {
            onSuccess: () => {
                form.reset();
                toast.success('Pieza creada exitosamente');
            },
            onError: () => {
                toast.error('Error al crear la pieza');
            },
        });
    }
}

function deletePiece(id) {
    if (confirm('¿Está seguro que desea eliminar esta pieza?')) {
        form.delete(route('pieces.destroy', id), {
            onSuccess: () => {
                toast.success('Pieza eliminada exitosamente');
            },
            onError: () => {
                toast.error('Error al eliminar la pieza');
            },
        });
    }
}
</script>

<template>
    <AppLayout title="Piezas">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Gestión de Piezas
            </h2>
        </template>

        <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                <div class="mb-6 p-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        {{ editMode ? 'Editar Pieza' : 'Nueva Pieza' }}
                    </h3>

                    <form @submit.prevent="submit">
                        <div class="mb-4">
                            <InputLabel for="code" value="Código" />
                            <TextInput v-model="form.code" id="code" type="text" :readonly="editMode"
                                class="mt-1 block w-full bg-gray-100" autocomplete="off" />
                            <p v-if="form.errors.code" class="text-red-600 text-sm mt-1">{{ form.errors.code }}</p>
                        </div>

                        <div class="mb-4">
                            <InputLabel for="theoretical_weight" value="Peso Teórico" />
                            <TextInput v-model="form.theoretical_weight" id="theoretical_weight" type="number"
                                class="mt-1 block w-full" step="0.01" autocomplete="off" />
                            <p v-if="form.errors.theoretical_weight" class="text-red-600 text-sm mt-1">{{
                                form.errors.theoretical_weight }}</p>
                        </div>

                        <div class="mb-4">
                            <InputLabel for="real_weight" value="Peso Real" />
                            <TextInput v-model="form.real_weight" id="real_weight" type="number" step="0.01"
                                class="mt-1 block w-full" autocomplete="off" />
                            <p v-if="form.errors.real_weight" class="text-red-600 text-sm mt-1">{{
                                form.errors.real_weight }}
                            </p>
                        </div>

                        <div class="mb-4">
                            <InputLabel for="status" value="Estado" />
                            <select v-model="form.status" id="status"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="Pendiente">Pendiente</option>
                                <option value="Fabricado">Fabricado</option>
                            </select>
                            <p v-if="form.errors.status" class="text-red-600 text-sm mt-1">{{ form.errors.status }}</p>
                        </div>

                        <div class="mb-4">
                            <InputLabel for="block_id" value="Bloque" />
                            <select v-model="form.block_id" id="block_id"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="" disabled>-- Seleccione un bloque --</option>
                                <option v-for="block in props.blocks" :key="block.id" :value="block.id">
                                    {{ block.name }} (Proyecto: {{ block.project?.name || 'N/A' }})
                                </option>
                            </select>
                            <p v-if="form.errors.block_id" class="text-red-600 text-sm mt-1">{{ form.errors.block_id }}
                            </p>
                        </div>

                        <div class="flex gap-2">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-500">
                                {{ editMode ? 'Actualizar' : 'Agregar' }}
                            </button>
                            <button v-if="editMode" type="button" @click="cancelEdit"
                                class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-500">
                                Cancelar
                            </button>
                        </div>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left text-gray-500">
                        <thead class="bg-gray-50 text-xs uppercase text-gray-700">
                            <tr>
                                <th class="px-6 py-3">Código</th>
                                <th class="px-6 py-3">Peso Teórico</th>
                                <th class="px-6 py-3">Peso Real</th>
                                <th class="px-6 py-3">Estado</th>
                                <th class="px-6 py-3">Bloque</th>
                                <th class="px-6 py-3">Fecha Registro</th>
                                <th class="px-6 py-3">Registrado por</th>
                                <th class="px-6 py-3">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="piece in props.pieces" :key="piece.id" class="bg-white border-b border-gray-200">
                                <td class="px-6 py-4 font-medium text-gray-900">{{ piece.code }}</td>
                                <td class="px-6 py-4">{{ Number(piece.theoretical_weight).toFixed(2) }}</td>
                                <td class="px-6 py-4">{{ Number(piece.real_weight) !== null ?
                                    Number(piece.real_weight).toFixed(2) : '-'
                                }}</td>
                                <td class="px-6 py-4">{{ piece.status }}</td>
                                <td class="px-6 py-4">{{ piece.block?.name || 'N/A' }}</td>
                                <td class="px-6 py-4">{{ piece.registration_date ? new
                                    Date(piece.registration_date).toLocaleString() : 'Sin tiempo' }}</td>
                                <td class="px-6 py-4">{{ piece.registered_by?.name || 'Sin asignación' }}</td>
                                <td class="px-6 py-4 flex gap-2">
                                <td class="px-6 py-4 flex gap-2">
                                    <button v-if="piece.registered_by && piece.registered_by.id === props.authUser.id"
                                        @click="startEdit(piece)"
                                        class="px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">
                                        Editar
                                    </button>

                                    <button v-if="piece.registered_by && piece.registered_by.id === props.authUser.id"
                                        @click="deletePiece(piece.id)"
                                        class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                        Eliminar
                                    </button>
                                </td>
                                </td>
                            </tr>

                            <tr v-if="props.pieces.length === 0">
                                <td colspan="8" class="text-center px-6 py-4">No hay piezas registradas</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </AppLayout>
</template>
