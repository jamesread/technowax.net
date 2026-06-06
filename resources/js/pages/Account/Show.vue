<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import SiteLayout from '@/layouts/SiteLayout.vue';

defineOptions({ layout: SiteLayout });

type Permission = {
    key: string;
    description: string | null;
};

defineProps<{
    user: {
        id: number;
        username: string;
        email: string | null;
    };
    permissions: Permission[];
}>();
</script>

<template>
    <Head title="Your account" />
    <section>
        <h2>Your Account</h2>
        <p><strong>Username: </strong>{{ user.username }}</p>
        <p><strong>ID: </strong>{{ user.id }}</p>

        <h3>Permissions</h3>
        <p v-if="permissions.length === 0">You don't have any special permissions.</p>
        <ul v-else>
            <li v-for="permission in permissions" :key="permission.key">{{ permission.key }}</li>
        </ul>

        <h3>Account</h3>
        <ul>
            <li><Link href="/settings/security">Change my password</Link></li>
        </ul>

        <h3>My services</h3>
        <p>Manage services tied to your account. Overview and documentation: <Link href="/services">Services</Link>.</p>
        <dl>
            <dt><Link href="/dyndns/updates">Dynamic DNS</Link></dt>
            <dd>View update history and your personal HTTP update endpoint.</dd>
        </dl>
    </section>
</template>
