<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { login, logout, register } from '@/routes';

const page = usePage();

const accountNav = computed(() => {
    const user = page.props.auth.user;
    const links: Array<{ href: string; label: string }> = [];

    if (user) {
        links.push({ href: '/account', label: 'Account' });

        if (user.privileges?.includes('SUPERUSER')) {
            links.push({ href: '/users', label: 'Users' });
        }

        links.push({ href: logout().url, label: 'Logout' });
    } else {
        links.push({ href: login().url, label: 'Login' });

        if (page.props.site.enableRegistration) {
            links.push({ href: register().url, label: 'Register' });
        }
    }

    return links;
});
</script>

<template>
    <div>
        <header>
            <p class="headerLogo">
                <Link href="/">
                    <img
                        id="headerLogo"
                        src="/resources/images/technowax.png"
                        alt="technowax.net"
                        title="technowax.net"
                    />
                </Link>
            </p>
            <button id="sidebarToggle" type="button" onclick="sidebarToggle()">
                &laquo; Close
            </button>
        </header>

        <nav>
            <ul id="navigationMain">
                <li v-for="item in page.props.site.nav" :key="item.href">
                    <Link :href="item.href">{{ item.label }}</Link>
                </li>
            </ul>
            <ul id="navigationAccount">
                <li v-for="item in accountNav" :key="item.href">
                    <Link :href="item.href">{{ item.label }}</Link>
                </li>
            </ul>
        </nav>

        <main>
            <slot />
        </main>
    </div>
</template>
