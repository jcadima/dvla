<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('email', 'admin@artisanbreach.com')->first();
        $contributor = User::where('email', 'contributor@artisanbreach.com')->first();

        $acp = Category::where('slug', 'acp')->first();
        $events = Category::where('slug', 'events')->first();

        $contributorDraft = Post::create([
            'user_id' => $contributor->id,
            'title' => 'Q3 Roadmap Notes',
            'slug' => 'q3-roadmap-notes',
            'meta_description' => 'Working notes for the Q3 roadmap review.',
            'post_content' => '<p>Draft notes for the Q3 planning session. Not ready for publication yet.</p>',
            'is_sticky' => false,
            'container_type' => 'container',
            'status' => 'draft',
            'created_at' => Carbon::now()->subDays(2),
            'updated_at' => Carbon::now()->subDays(2),
        ]);
        if ($events) {
            $contributorDraft->categories()->sync([$events->id]);
        }

        $adminDraft = Post::create([
            'user_id' => $admin->id,
            'title' => 'CONFIDENTIAL: Executive Compensation Review',
            'slug' => 'confidential-executive-compensation-review',
            'meta_description' => 'Internal draft — do not distribute.',
            'post_content' => '<p>Internal draft covering executive compensation adjustments for the next fiscal year. This has not been approved for release.</p>',
            'is_sticky' => false,
            'container_type' => 'container',
            'status' => 'draft',
            'created_at' => Carbon::now()->subDays(5),
            'updated_at' => Carbon::now()->subDays(5),
        ]);
        if ($acp) {
            $adminDraft->categories()->sync([$acp->id]);
        }
    }
}
