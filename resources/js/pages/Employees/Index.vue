<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Employee, type BreadcrumbItem, type SharedData } from '@/types';
import { Head, usePage, Link, router } from '@inertiajs/vue3';
import {
  Table,
  TableBody,
  TableCaption,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from '@/components/ui/table'
import { computed } from 'vue';
import { Button } from '@/components/ui/button';
import { Pencil, Trash, CirclePlus } from 'lucide-vue-next';
interface EmployeesPageProps extends ShareData {
    employees: Employee[];
}

const { props } = usePage<EmployeesPageProps>();
const employees = computed(() => props.employees);

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Employees',
        href: '/employees',
    },
];

const deleteEmployee = async (id:number) => {
    if (!window.confirm('¿Esta seguro que quiere eliminar este registro?')) return;

    router.delete(`/employees/${id}`, {
        preserveScroll: true,
        onSuccess: () => {
            router.visit(`/employes`, { replace: true });
        },
        onError: (errors) => {
            console.error('Error eliminando el registro: ', errors);
        }
    });
}
</script>

<template>
    <Head title="Employees" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="flex">
                <Button as-child size="sm" class="bg-indigo-500 text-white hover:bg-indigo-700">
                    <Link href="/employees/create"> <CirclePlus /> Create </Link>
                </Button>
            </div>
        </div>

        <div class="relative  min-h-[100vh] flex-1 rounded-xl border-sidebar-border/70 dark:border-sidebar-bordr ms:min-h-min">
            <Table>
                <TableCaption>Employees List.</TableCaption>
                <TableHeader>
                    <TableRow>
                        <TableHead>Nombre</TableHead>
                        <TableHead>Email</TableHead>
                        <TableHead>Posicion</TableHead>
                        <TableHead class="text-right">Salario</TableHead>
                        <TableHead class="text-center">Acciones</TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <TableRow v-for="employee in employees" :key="employee.id">
                        <TableCell class="font-medium">
                            {{ employee.nombre }}
                        </TableCell>
                        <TableCell>
                            {{ employee.email ?? 'N/A' }}
                        </TableCell>
                        <TableCell>
                            {{ employee.posicion }}
                        </TableCell>
                        <TableCell class="text-right">
                            {{new Intl.NumberFormat('en-US', {style: 'currency', currency: 'USD'}).format(employee.salario) }}
                        </TableCell>
                        <TableCell class="text-right">
                            <Button as-child size="sm" class="bg-blue-500 text-white hover:bg-blue-700">
                                <Link href="`/employees/${employee.id}/edit`">
                                    <Pencil />
                                </Link>
                            </Button>
                            <Button as-child size="sm" class="bg-rose-500 text-white hover:bg-rose-700" @click="deleteEmployee(employee.id)" >
                                <Trash />
                            </Button>
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>
    </AppLayout>

</template>
