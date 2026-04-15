<script setup lang="ts">
import { dashboard, login, register } from '@/routes';
import { Head, Link } from '@inertiajs/vue3';

withDefaults(
    defineProps<{
        canRegister: boolean;
    }>(),
    {
        canRegister: true,
    },
);

import { computed } from 'vue'

const titleText = 'Dedicated Servers'
const titleChars = computed(() => titleText.split(''))

const features = [
  'NVMe SSD storage with blazing-fast I/O performance.',
  'Unmetered bandwidth on all dedicated plans.',
  '99.99% uptime SLA backed by redundant infrastructure.',
  'Full root access — deploy any OS or control panel.',
  '24/7 expert support via live chat, tickets, and phone.',
]

const plans = [
  {
    name: 'Starter',
    price: '49',
    featured: false,
    features: ['4-core CPU', '16 GB RAM', '500 GB NVMe', '1 Gbps port', 'Basic DDoS protection'],
  },
  {
    name: 'Pro',
    price: '99',
    featured: true,
    features: ['8-core CPU', '64 GB RAM', '2 TB NVMe', '10 Gbps port', 'Advanced DDoS protection'],
  },
  {
    name: 'Enterprise',
    price: '199',
    featured: false,
    features: ['16-core CPU', '128 GB RAM', '4 TB NVMe', '10 Gbps port', 'Full DDoS mitigation'],
  },
]

function scrollToPlans() {
  document.getElementById('plans')?.scrollIntoView({ behavior: 'smooth' })
}
</script>

<template>
  <div style="font-family: 'DM Sans', sans-serif; background: var(--bg); color: var(--text); min-height: 100vh; overflow-x: hidden;">

    <nav style="display: flex; align-items: center; justify-content: space-between; padding: 0 2.5rem; height: 68px; border-bottom: 1px solid var(--border); backdrop-filter: blur(12px); background: rgba(13, 13, 15, 0.85); position: sticky; top: 0; z-index: 100;">
      <div style="display: flex; align-items: center; gap: .6rem;">
        <div aria-hidden="true" style="display: flex;">
          <svg width="28" height="36" viewBox="0 0 28 36" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="6" y="0" width="16" height="22" rx="2" fill="#c4a8ff" opacity="0.9" />
            <rect x="0" y="8" width="16" height="22" rx="2" fill="#a87cff" opacity="0.7" />
            <rect x="6" y="14" width="16" height="22" rx="2" fill="#d4bcff" opacity="0.55" />
          </svg>
        </div>
        <span style="font-family: 'Syne', sans-serif; font-weight: 700; font-size: 1.35rem; letter-spacing: -.01em; color: #fff;">Sili</span>
      </div>

      <div style="display: flex; align-items: center; gap: 2rem;">
        <a href="#" style="font-size: .85rem; color: var(--muted); text-decoration: none; letter-spacing: .02em; transition: color .2s;" class="nav-link">Dedicated Server Hosting</a>
        <Link v-if="$page.props.auth.user" :href="dashboard()"
          class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]">
        Dashboard
        </Link>
        <template v-else>
          <Link :href="login()"
            class="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]">
          Log in
          </Link>
          <Link v-if="canRegister" :href="register()"
            class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]">
          Register
          </Link>
        </template>
      </div>
    </nav>

    <main style="position: relative; min-height: calc(100vh - 68px); display: flex; align-items: center; padding: 5rem 2.5rem; overflow: hidden;">

      <div aria-hidden="true" style="position: absolute; width: 480px; height: 480px; background: radial-gradient(circle, rgba(168, 124, 255, .18) 0%, transparent 70%); top: -120px; left: -100px; border-radius: 50%; filter: blur(90px); pointer-events: none;"></div>
      <div aria-hidden="true" style="position: absolute; width: 360px; height: 360px; background: radial-gradient(circle, rgba(34, 197, 94, .1) 0%, transparent 70%); bottom: 60px; right: 15%; border-radius: 50%; filter: blur(90px); pointer-events: none;"></div>
      <div aria-hidden="true" style="position: absolute; inset: 0; background-image: linear-gradient(var(--border) 1px, transparent 1px), linear-gradient(90deg, var(--border) 1px, transparent 1px); background-size: 48px 48px; mask-image: radial-gradient(ellipse 70% 60% at 30% 50%, black 40%, transparent 100%); pointer-events: none;"></div>

      <div style="position: relative; z-index: 2; max-width: 580px;">
        <h1 style="font-family: 'Syne', sans-serif; font-weight: 800; font-size: clamp(2.4rem, 5vw, 3.6rem); line-height: 1.05; letter-spacing: -.03em; color: #fff; margin-bottom: 2rem; display: flex; flex-wrap: wrap;" ref="title">
          <span
            v-for="(char, i) in titleChars"
            :key="i"
            class="char"
            :style="{ animationDelay: `${i * 0.04}s` }"
          >{{ char }}</span>
        </h1>

        <ul style="list-style: none; display: flex; flex-direction: column; gap: .65rem; margin-bottom: 2.5rem; padding: 0;">
          <a style="display: flex; align-items: flex-start; gap: .65rem; opacity: 0; transform: translateX(-12px); animation: slideIn .5s forwards;" class="feature-item">
            Beheer al je Docker-containers vanaf één plek. Met dit dashboard start, stop, update en verwijder je
            containers eenvoudig via een overzichtelijke interface, zonder dat je de command line in hoeft.
            Upload je eigen Docker Compose-bestanden, gebruik kant-en-klare templates om snel nieuwe services op te
            zetten, en wijs automatisch subdomeinen toe zodat meerdere webservers tegelijkertijd bereikbaar zijn zonder gedoe
            met poortnummers.
          </a>
        </ul>
      </div>

      <div aria-hidden="true" style="position: absolute; right: 8%; top: 50%; transform: translateY(-50%); width: 260px; height: 260px; display: none;" class="hero__visual">
        <div
          v-for="n in 3"
          :key="n"
          :class="`server-card--${n}`"
          style="position: absolute; width: 220px; height: 48px; border-radius: 10px; border: 1px solid var(--border); background: var(--surface); display: flex; align-items: center; padding: 0 1rem; gap: .75rem; animation: float 4s ease-in-out infinite;"
        >
          <div style="width: 8px; height: 8px; border-radius: 50%; background: var(--green); box-shadow: 0 0 8px var(--green); flex-shrink: 0;"></div>
          <div style="display: flex; flex-direction: column; gap: 4px; flex: 1;">
            <span style="display: block; height: 5px; border-radius: 3px; width: 60%; background: rgba(196, 168, 255, .3);"></span>
            <span style="display: block; height: 5px; border-radius: 3px; width: 40%; background: var(--border);"></span>
            <span style="display: block; height: 5px; border-radius: 3px; width: 75%; background: rgba(34, 197, 94, .2);"></span>
          </div>
        </div>
        <div style="position: absolute; width: 200px; height: 200px; border-radius: 50%; background: radial-gradient(circle, rgba(168, 124, 255, .15) 0%, transparent 70%); top: 50%; left: 50%; transform: translate(-50%, -50%); filter: blur(30px); pointer-events: none;"></div>
      </div>

    </main>

  </div>
</template>

<style scoped>
:root,
.site-wrapper {
  --bg: #0d0d0f;
  --surface: #13131a;
  --border: rgba(255, 255, 255, 0.07);
  --purple-lo: #c4a8ff;
  --purple-hi: #a87cff;
  --green: #22c55e;
  --text: #e8e8f0;
  --muted: #7a7a96;
}

.nav-link:hover { color: var(--text); }
.btn-login:hover { background: rgba(196, 168, 255, 0.1); border-color: var(--purple-lo); }
.btn-cta:hover { background: var(--purple-lo); transform: translateY(-2px); box-shadow: 0 0 40px rgba(196, 168, 255, .45); }
.btn-cta:hover .btn-cta__arrow { transform: translateX(4px); }
.plan-card:hover { transform: translateY(-4px); border-color: rgba(196, 168, 255, .25); }
.plan-btn:hover { background: rgba(255, 255, 255, .06); border-color: rgba(255, 255, 255, .2); }
.plan-btn--featured:hover { background: var(--purple-lo); border-color: var(--purple-lo); }

@keyframes charIn {
  to { opacity: 1; transform: translateY(0); }
}
@keyframes slideIn {
  to { opacity: 1; transform: translateX(0); }
}
@keyframes float {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-8px); }
}
@keyframes fadeUp {
  to { opacity: 1; }
}

.char {
  display: inline-block;
  opacity: 0;
  transform: translateY(20px);
  animation: charIn .5s forwards;
}

@media (min-width: 900px) {
  .hero__visual { display: block !important; }
}

.server-card--1 { top: 20px; left: 20px; animation-delay: 0s; }
.server-card--2 { top: 90px; left: 0px; animation-delay: .5s; }
.server-card--3 { top: 160px; left: 20px; animation-delay: 1s; }
</style>