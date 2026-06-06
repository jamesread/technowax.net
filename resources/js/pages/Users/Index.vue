<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import SiteLayout from '@/layouts/SiteLayout.vue';

defineOptions({ layout: SiteLayout });

type ListedUser = {
    id: number;
    username: string;
    groupName: string | null;
};

defineProps<{
    users: ListedUser[];
}>();
</script>

<template>
    <Head title="Users" />
    <section>
        <h2>Users</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Group</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="user in users" :key="user.id">
                    <td>{{ user.id }}</td>
                    <td>{{ user.username }}</td>
                    <td>{{ user.groupName ?? 'N/A' }}</td>
                </tr>
            </tbody>
        </table>
    </section>
</template>
