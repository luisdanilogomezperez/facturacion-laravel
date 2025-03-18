<script setup lang="ts">
   import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, router, usePage } from '@inertiajs/vue3';
import { onMounted, reactive } from 'vue';
import { Employee } from '@/types';

type BreadcrumbItem = { title: string; href: string };
const { props } = usePage();
const employee = props.employee as Employee;

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Employees', href: '/employees' },
    { title: 'Edit', href: '#' },
];

const form = reactive<Partial<{ nombre: string; email: string | undefined; posicion: string; salario: number | undefined }>>({
    nombre: '',
    email: undefined,
    posicion: '',
    salario: undefined,
});

onMounted(() => {
    form.nombre = employee.nombre ?? '';
    form.email = employee.email ?? '';
    form.posicion = employee.posicion ?? '';
    form.salario = employee.salario ?? undefined;
});

const resetForm = () => {
    form.nombre = '';
    form.email = '';
    form.posicion = '';
    form.salario = undefined;
};

const submit = () => {
    router.put(`/employees/${employee.id}`, form, { onSuccess: resetForm });
};
</script>

<template>
    <Head title="Create Employee" />

    <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex flex-1 flex-col gap-4 rounded-xl p-4">
      <h1 class="text-2xl font-bold">Create</h1>
      <form @submit.prevent="submit" class="space-y-6 max-w-lg">
        <div v-for="(label, key) in { nombre: 'Nombre', email: 'Email', posicion: 'Posición', salario: 'Salario' }" :key="key" class="space-y-2">
          <Label :for="key">{{ label }}</Label>
          <Input
            :id="key"
            v-model="form[key]"
            :type="key === 'salario' ? 'number' : key === 'email' ? 'email' : 'text'"
            :placeholder="label"
            :required="key !== 'email'"
            :step="key === 'salario' ? '0.01' : undefined"
          />
        </div>
        <div class="flex gap-4">
          <Button type="submit" class="bg-indigo-500 hover:bg-indigo-600">Save</Button>
          <Button as="a" href="/employees" variant="outline">Cancel</Button>
        </div>
      </form>
    </div>
  </AppLayout>
</template>