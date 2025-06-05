<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref, watch, computed } from 'vue';
import { useToast } from 'vue-toastification';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({
    projects: Array,
});

const toast = useToast();

const form = useForm({
    id: '',
    project_id: '',
    name: '',
});

const editMode = ref(false);
const editingProjectId = ref(null);

function startEdit(project) {
    form.id = project.id;
    form.project_id = project.project_id;
    form.name = project.name;
    editMode.value = true;
    editingProjectId.value = project.id;
}

function cancelEdit() {
    form.reset();
    editMode.value = false;
    editingProjectId.value = null;
}

// Computed para validar si el formulario está completo
const isFormValid = computed(() => {
    return form.project_id.trim() !== '' && form.name.trim() !== '';
});

function submit() {
    if (!isFormValid.value) {
        toast.error('Por favor complete todos los campos.');
        return;
    }

    console.log(form.name, form.project_id);

    if (editMode.value) {
        form.put(route('projects.update', editingProjectId.value), {
            onSuccess: () => {
                cancelEdit();
                toast.success("Proyecto actualizado exitosamente");
            },
            onError: () => {
                toast.error("Error al actualizar el proyecto");
            },
        });
    } else {
        form.post(route('projects.store'), {
            onSuccess: () => {
                form.reset();
                toast.success("Proyecto creado exitosamente");
            },
            onError: () => {
                toast.error("Error al crear el proyecto");
            },
        });
    }
}

function deleteProject(id) {
    if (confirm('¿Está seguro que desea eliminar este proyecto?')) {
        form.delete(route('projects.destroy', id), {
            onSuccess: () => {
                toast.success("Proyecto eliminado exitosamente");
            },
            onError: () => {
                toast.error("Error al eliminar el proyecto");
            },
        });
    }
}
</script>

<template>
    <AppLayout title="Proyectos">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Gestión de Proyectos
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg lg:grid lg:gap-4">

                    <div class="p-4">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900">Proyectos</h3>
                            <p class="mt-1 text-sm text-gray-600">Aquí puedes gestionar tus proyectos.</p>
                        </div>

                        <form @submit.prevent="submit">
                            <div class="mt-4">
                                <InputLabel for="project_id" value="ID del Proyecto" />
                                <TextInput v-model="form.project_id" id="project_id" type="text"
                                    class="mt-1 block w-full" :disabled="editMode" autocomplete="off"
                                    placeholder="Ejemplo: BRF" />
                                <p v-if="form.errors.project_id" class="text-red-600 text-sm mt-1">
                                    {{ form.errors.project_id }}
                                </p>
                            </div>

                            <div class="mt-4">
                                <InputLabel for="name" value="Nombre" />
                                <TextInput v-model="form.name" id="name" type="text" class="mt-1 block w-full"
                                    autocomplete="off" placeholder="Nombre del proyecto" />
                                <p v-if="form.errors.name" class="text-red-600 text-sm mt-1">
                                    {{ form.errors.name }}
                                </p>
                            </div>

                            <div class="mt-4 flex gap-2">
                                <button type="submit" :disabled="!isFormValid"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-200 transition ease-in-out duration-150 disabled:opacity-50 disabled:cursor-not-allowed">
                                    {{ editMode ? 'Actualizar' : 'Agregar' }}
                                </button>

                                <button v-if="editMode" type="button" @click="cancelEdit"
                                    class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 active:bg-gray-700 focus:outline-none focus:border-gray-700 focus:ring ring-gray-200 transition ease-in-out duration-150">
                                    Cancelar
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">ID (numérico)</th>
                                    <th scope="col" class="px-6 py-3">ID Proyecto</th>
                                    <th scope="col" class="px-6 py-3">Nombre</th>
                                    <th scope="col" class="px-6 py-3">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="project in props.projects" :key="project.id"
                                    class="bg-white border-b border-gray-200">
                                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">{{ project.id }}
                                    </td>
                                    <td class="px-6 py-4">{{ project.project_id }}</td>
                                    <td class="px-6 py-4">{{ project.name }}</td>
                                    <td class="px-6 py-4 flex gap-2">
                                        <button @click="startEdit(project)"
                                            class="px-2 py-1 bg-blue-500 rounded text-white hover:bg-blue-600">
                                            Editar
                                        </button>
                                        <button @click="deleteProject(project.id)"
                                            class="px-2 py-1 bg-red-600 rounded text-white hover:bg-red-700">
                                            Eliminar
                                        </button>
                                    </td>
                                </tr>

                                <tr v-if="props.projects.length === 0">
                                    <td colspan="4" class="px-6 py-4 text-center">No hay proyectos</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </AppLayout>
</template>
