<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HomePageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('homes')->updateOrInsert(
            ['title' => 'Home'],
            [
                'meta_description' => 'DVLA: a deliberately vulnerable Laravel 12 + Livewire 3 application for AppSec training and OSWE exam preparation.',
                'page_content' =>
<<<'HTML'

    <!-- Hero -->
    <section class="dvla-hero">
        <div class="container text-center">
            <div class="dvla-hero-warning">
                <i class="fa-solid fa-triangle-exclamation me-2"></i>
                Local educational use only. Never deploy on a public-facing server.
            </div>
            <h1 class="dvla-hero-title">DVLA: Damn Vulnerable Laravel Application for AppSec Training</h1>
            <p class="dvla-hero-subtitle">
                A modern, guided security lab targeting real-world Laravel stack exploits.<br>
                Built for OSWE prep, AppSec training, and Laravel developers who want to understand<br>
                what production vulnerabilities actually look like, and how they chain together.
            </p>
            <div class="dvla-hero-ctas">
                <a target="_blank"  href="https://jcadima.dev/blog/getting-started-docker-laravel-security-lab" class="btn dvla-btn-primary">
                    <i class="fa-solid fa-terminal me-2"></i>Get Started
                </a>
                <a href="https://github.com/jcadima/dvla" target="_blank" rel="noopener" class="btn dvla-btn-ghost">
                    <i class="fa-brands fa-github me-2"></i>View on GitHub
                </a>
            </div>
        </div>
    </section>

    <!-- Why DVLA -->
    <section class="dvla-section dvla-why">
        <div class="container">
            <h2 class="dvla-section-title text-center">Why DVLA?</h2>
            <p class="dvla-section-sub text-center">
                DVWA and similar tools demonstrate generic, early-era web vulnerabilities on outdated PHP. DVLA targets the real attack surface of a modern Laravel stack.
            </p>
            <div class="row g-4 mt-2">
                <div class="col-md-4">
                    <div class="dvla-why-card h-100">
                        <div class="dvla-why-icon">
                            <i class="fa-solid fa-layer-group"></i>
                        </div>
                        <h5>Modern Stack</h5>
                        <p>PHP 8.2, Laravel 12, Livewire 3, Docker Compose, Redis &amp; Horizon. The same stack running in production today, not CGI-era PHP.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="dvla-why-card h-100">
                        <div class="dvla-why-icon">
                            <i class="fa-solid fa-link-slash"></i>
                        </div>
                        <h5>Full Kill Chain</h5>
                        <p>Vulnerabilities chain into a complete host compromise: <code>.env</code> leak -&gt; APP_KEY RCE -&gt; Redis job injection -&gt; <code>docker.sock</code> escape.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="dvla-why-card h-100">
                        <div class="dvla-why-icon">
                            <i class="fa-solid fa-book-open"></i>
                        </div>
                        <h5>Blog-Guided</h5>
                        <p>Every exploit module has a companion post right here with source code walkthroughs, proof-of-concept steps, and side-by-side remediation.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Kill Chain Overview -->
    <section class="dvla-section dvla-killchain">
        <div class="container">
            <h2 class="dvla-section-title text-center">The Kill Chain</h2>
            <p class="dvla-section-sub text-center">Five individually defensible shortcuts that compound into a full host compromise.</p>
            <div class="dvla-chain">
                <div class="dvla-chain-step">
                    <span class="dvla-chain-num">1</span>
                    <div>
                        <strong>Nginx</strong><br>
                        <small><code>.env</code> exposed, readable via HTTP</small>
                    </div>
                </div>
                <div class="dvla-chain-arrow"><i class="fa-solid fa-arrow-right"></i></div>
                <div class="dvla-chain-step">
                    <span class="dvla-chain-num">2</span>
                    <div>
                        <strong>Credentials</strong><br>
                        <small><code>APP_KEY</code> extracted from <code>.env</code></small>
                    </div>
                </div>
                <div class="dvla-chain-arrow"><i class="fa-solid fa-arrow-right"></i></div>
                <div class="dvla-chain-step">
                    <span class="dvla-chain-num">3</span>
                    <div>
                        <strong>Laravel App</strong><br>
                        <small>Forged cookie -&gt; deserialization RCE</small>
                    </div>
                </div>
                <div class="dvla-chain-arrow"><i class="fa-solid fa-arrow-right"></i></div>
                <div class="dvla-chain-step">
                    <span class="dvla-chain-num">4</span>
                    <div>
                        <strong>Redis</strong><br>
                        <small>No-auth queue backend -&gt; job injection</small>
                    </div>
                </div>
                <div class="dvla-chain-arrow"><i class="fa-solid fa-arrow-right"></i></div>
                <div class="dvla-chain-step">
                    <span class="dvla-chain-num">5</span>
                    <div>
                        <strong>Docker</strong><br>
                        <small><code>docker.sock</code> mounted -&gt; host escape</small>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Vulnerability Modules -->
    <section class="dvla-section dvla-modules">
        <div class="container">
            <h2 class="dvla-section-title text-center">Vulnerability Modules</h2>
            <p class="dvla-section-sub text-center">Eight intentional misconfigurations across the full stack. Explore each one in your own local instance, then check the companion blog series below for the full walkthrough.</p>

            <!-- Easy -->
            <div class="dvla-tier-header dvla-tier-easy">
                <i class="fa-solid fa-circle-check me-2"></i>Easy
            </div>
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="dvla-module-card dvla-module-easy">
                        <h6><i class="fa-solid fa-user-gear me-2"></i>Mass Assignment</h6>
                        <p>Eloquent model lacks <code>$fillable</code>, so the registration endpoint accepts <code>is_admin=1</code> and grants admin on signup.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="dvla-module-card dvla-module-easy">
                        <h6><i class="fa-solid fa-file-lines me-2"></i>.env Exposure + <i class="fa-solid fa-key me-2"></i>APP_KEY -&gt; RCE</h6>
                        <p>Nginx misconfiguration serves the <code>.env</code> file over HTTP, exposing <code>APP_KEY</code>, database credentials, and all secrets.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="dvla-module-card dvla-module-medium">
                        <h6><i class="fa-solid fa-code me-2"></i>PHP Type Juggling</h6>
                        <p>Custom auth uses <code>==</code> instead of <code>===</code>, so magic hash values like <code>0e...</code> bypass authentication entirely.</p>
                    </div>
                </div>

            </div>

            <!-- Medium -->
            <div class="dvla-tier-header dvla-tier-medium">
                <i class="fa-solid fa-triangle-exclamation me-2"></i>Medium
            </div>
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="dvla-module-card dvla-module-medium">
                        <h6><i class="fa-solid fa-code me-2"></i>Stored XSS</h6>
                        <p>User-controlled content injection. <code>Stored XSS</code> is the highest-impact variant: the payload
          executes automatically for every visitor.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="dvla-module-card dvla-module-medium">
                        <h6><i class="fa-solid fa-id-badge me-2"></i>IDOR via Route Binding</h6>
                        <p>No ownership check on <code>/users/{id}/data</code>, so any authenticated user can access any other user's records just by changing the ID.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="dvla-module-card dvla-module-medium">
                        <h6><i class="fa-solid fa-upload me-2"></i>Livewire File Upload Bypass</h6>
                        <p>Component trusts MIME type over extension. Upload a <code>.php</code> shell as <code>image/png</code> and it lands in <code>public/storage/</code> ready to execute.</p>
                    </div>
                </div>
            </div>

            <!-- Hard -->
            <div class="dvla-tier-header dvla-tier-hard">
                <i class="fa-solid fa-skull-crossbones me-2"></i>Hard
            </div>
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="dvla-module-card dvla-module-hard">
                        <h6><i class="fa-solid fa-database me-2"></i>Redis Job Injection</h6>
                        <p>Unauthenticated Redis exposed on all interfaces. Push a serialized Laravel job directly and the Horizon worker picks it up and executes it.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="dvla-module-card dvla-module-hard">
                        <h6><i class="fa-brands fa-docker me-2"></i>docker.sock Escape</h6>
                        <p><code>docker.sock</code> mounted in the app and Horizon containers. From container RCE you can spawn a privileged container and mount the host filesystem.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Blog Series -->
    <section class="dvla-section dvla-blog">
        <div class="container">
            <h2 class="dvla-section-title text-center">Companion Blog Series</h2>
            <p class="dvla-section-sub text-center">
                Full write-ups for every module above. Each post includes source code review, step-by-step exploit, and remediation.
            </p>

            <a target="_blank" href="https://jcadima.dev/blog/getting-started-docker-laravel-security-lab" class="dvla-starthere mt-4">
                <div class="dvla-starthere-icon"><i class="fa-brands fa-space-awesome"></i></div>
                <div>
                    <h5>Start Here: Getting DVLA Running Locally</h5>
                    <p>Clone and build the full Docker lab.</p>
                </div>
            </a>

            <div class="row g-3 mt-2">
                <div class="col-md-6 col-lg-4">
                    <a target="_blank" href="https://jcadima.dev/blog/laravel-mass-assignment-vulnerability-eloquent" class="dvla-blog-card">
                        <span class="dvla-blog-num">1</span>
                        <div>
                            <p>Mass assignment in Eloquent: the vulnerability hiding in plain sight</p>
                            <span class="dvla-read-more text-danger">Read Post <i class="fa-solid fa-arrow-right ms-1"></i></span>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-lg-4">
                    <a href="#" class="dvla-blog-card">
                        <span class="dvla-blog-num">2</span>
                        <div>
                            <p>Nginx misconfiguration to RCE: the .env leak and the APP_KEY deserialization chain</p>
                            <span class="dvla-read-more">Coming Soon <i class="fa-solid fa-arrow-right ms-1"></i></span>
                        </div>
                    </a>
                </div>

                <div class="col-md-6 col-lg-4">
                    <a href="#" class="dvla-blog-card">
                        <span class="dvla-blog-num">3</span>
                        <div>
                            <p>Type juggling in PHP: bypassing authentication with == vs ===</p>
                            <span class="dvla-read-more">Coming Soon <i class="fa-solid fa-arrow-right ms-1"></i></span>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-lg-4">
                    <a href="#" class="dvla-blog-card">
                        <span class="dvla-blog-num">4</span>
                        <div>
                            <p>IDOR on Laravel API routes: when route model binding is not enough</p>
                            <span class="dvla-read-more">Coming Soon <i class="fa-solid fa-arrow-right ms-1"></i></span>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-lg-4">
                    <a href="#" class="dvla-blog-card">
                        <span class="dvla-blog-num">5</span>
                        <div>
                            <p>Livewire file upload bypass: MIME trust and the path to RCE</p>
                            <span class="dvla-read-more">Coming Soon <i class="fa-solid fa-arrow-right ms-1"></i></span>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-lg-4">
                    <a href="#" class="dvla-blog-card">
                        <span class="dvla-blog-num">6</span>
                        <div>
                            <p>Stored XSS via the admin panel: when {!! !!} trusts unsanitized input</p>
                            <span class="dvla-read-more">Coming Soon <i class="fa-solid fa-arrow-right ms-1"></i></span>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-lg-4">
                    <a href="05-redis-injection/blog_post_redis_injection.html" class="dvla-blog-card">
                        <span class="dvla-blog-num">7</span>
                        <div>
                            <p>Redis with no authentication: how your queue worker becomes a backdoor</p>
                            <span class="dvla-read-more">Read post <i class="fa-solid fa-arrow-right ms-1"></i></span>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-lg-4">
                    <a href="#" class="dvla-blog-card">
                        <span class="dvla-blog-num">8</span>
                        <div>
                            <p>Docker misconfigurations: turning container RCE into host compromise</p>
                            <span class="dvla-read-more">Coming Soon <i class="fa-solid fa-arrow-right ms-1"></i></span>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-lg-4">
                    <a href="#" class="dvla-blog-card">
                        <span class="dvla-blog-num">9</span>
                        <div>
                            <p>Chaining all of it: a full kill chain against a Laravel application</p>
                            <span class="dvla-read-more">Coming Soon <i class="fa-solid fa-arrow-right ms-1"></i></span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

HTML,
            'created_at' => '2026-07-05',
            'updated_at' => '2026-07-05',
        ]);
    }
}
