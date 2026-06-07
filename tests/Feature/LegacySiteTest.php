<?php

namespace Tests\Feature;

use App\Models\Permission;
use App\Models\User;
use Database\Seeders\LegacyBootstrapSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LegacySiteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(LegacyBootstrapSeeder::class);
    }

    public function test_home_page_renders_wiki_content(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('Wiki/Show')
                ->where('page.title', 'home'));
    }

    public function test_services_and_tools_pages_are_available(): void
    {
        $this->get('/services')->assertOk()->assertInertia(fn ($page) => $page->component('Services/Index'));
        $this->get('/tools')->assertOk()->assertInertia(fn ($page) => $page->component('Tools/Index'));
        $this->get('/projects')->assertOk()->assertInertia(fn ($page) => $page->component('Projects/Index'));
    }

    public function test_tool_subpages_render_on_get(): void
    {
        $this->get('/tools/team-maker')->assertOk()->assertInertia(fn ($page) => $page->component('Tools/TeamMaker'));
        $this->get('/tools/indenter')->assertOk()->assertInertia(fn ($page) => $page->component('Tools/Indenter'));
        $this->get('/tools/dns-lookup')->assertOk()->assertInertia(fn ($page) => $page->component('Tools/DnsLookup'));
    }

    public function test_superuser_can_view_user_list(): void
    {
        $permission = Permission::query()->where('key', 'SUPERUSER')->firstOrFail();

        $user = User::factory()->create([
            'username' => 'admin',
            'group_id' => 1,
        ]);

        $user->permissions()->attach($permission);

        $this->actingAs($user)
            ->get('/users')
            ->assertOk()
            ->assertInertia(fn ($page) => $page->component('Users/Index'));
    }

    public function test_wiki_page_can_be_created(): void
    {
        $this->get('/wiki/new-page/create')
            ->assertRedirect('/wiki/new-page');

        $this->assertDatabaseHas('wiki_pages', ['title' => 'new-page']);
    }

}
