<script setup lang="ts">
import { KeyRound, Shield } from '@lucide/vue';
import { Head, Link } from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
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

    <div class="mx-auto max-w-4xl space-y-8">
        <Heading
            title="Your account"
            description="Manage your profile, security settings, and personal services."
        />

        <div class="grid gap-6 md:grid-cols-2">
            <Card>
                <CardHeader>
                    <CardTitle>Profile</CardTitle>
                    <CardDescription>Your account details on technowax.net</CardDescription>
                </CardHeader>
                <CardContent>
                    <dl class="grid gap-4 text-sm">
                        <div class="flex items-center justify-between gap-4">
                            <dt class="text-muted-foreground">Username</dt>
                            <dd class="font-medium">{{ user.username }}</dd>
                        </div>
                        <div class="flex items-center justify-between gap-4">
                            <dt class="text-muted-foreground">User ID</dt>
                            <dd class="font-mono text-xs font-medium">{{ user.id }}</dd>
                        </div>
                        <div
                            v-if="user.email"
                            class="flex items-center justify-between gap-4"
                        >
                            <dt class="text-muted-foreground">Email</dt>
                            <dd class="truncate font-medium">{{ user.email }}</dd>
                        </div>
                    </dl>
                </CardContent>
            </Card>

            <Card>
                <CardHeader>
                    <CardTitle class="flex items-center gap-2">
                        <Shield class="size-4 text-muted-foreground" />
                        Permissions
                    </CardTitle>
                    <CardDescription>
                        Special access granted to your account
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    <p
                        v-if="permissions.length === 0"
                        class="text-sm text-muted-foreground"
                    >
                        You don't have any special permissions.
                    </p>
                    <div v-else class="flex flex-wrap gap-2">
                        <Badge
                            v-for="permission in permissions"
                            :key="permission.key"
                            variant="secondary"
                            :title="permission.description ?? undefined"
                        >
                            {{ permission.key }}
                        </Badge>
                    </div>
                </CardContent>
            </Card>
        </div>

        <Card>
            <CardHeader>
                <CardTitle class="flex items-center gap-2">
                    <KeyRound class="size-4 text-muted-foreground" />
                    Security
                </CardTitle>
                <CardDescription>
                    Update your password and manage authentication options
                </CardDescription>
            </CardHeader>
            <CardContent>
                <Button variant="outline" as-child>
                    <Link href="/settings/security">Change password</Link>
                </Button>
            </CardContent>
        </Card>

        <div class="space-y-4">
            <Heading
                variant="small"
                title="My services"
                description="Services tied to your account. See the services page for full documentation."
            />

            <div class="grid gap-4 sm:grid-cols-2">
                <Link href="/services" class="group block h-full">
                    <Card
                        class="h-full transition-colors group-hover:border-foreground/20 group-hover:bg-muted/40"
                    >
                        <CardHeader>
                            <CardTitle>All services</CardTitle>
                            <CardDescription>
                                Browse DNS lookup, document repos, and other utilities.
                            </CardDescription>
                        </CardHeader>
                    </Card>
                </Link>
            </div>
        </div>
    </div>
</template>
