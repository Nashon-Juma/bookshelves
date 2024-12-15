<script lang="ts" setup>
import { useNavigation } from "@/Composables/useNavigation";
import { ref } from "vue";

const { mainLinks, secondaryLinks } = useNavigation();

const isDarkMode = ref(localStorage.getItem("theme") === "dark");

function setTheme(mode: "light" | "dark") {
  isDarkMode.value = mode === "dark";
  document.documentElement.classList.toggle("dark", isDarkMode.value);
  localStorage.setItem("theme", mode);
}
</script>

<template>
  <div class="hidden xl:fixed xl:inset-y-0 xl:z-50 xl:flex xl:w-72 xl:flex-col">
    <!-- Sidebar component, swap this element with another sidebar if you like -->
    <div
      class="flex grow flex-col gap-y-5 overflow-y-auto bg-black/10 px-6 ring-1 ring-white/5"
    >
      <!-- Logo Section -->
      <ILink class="flex h-16 shrink-0 items-center space-x-2" href="/">
        <Logo class="h-9 w-auto" />
        <EventFlag />
        <SvgIcon name="logo-text" class="h-7 w-auto" />
      </ILink>

      <!-- Navigation Links -->
      <nav class="flex flex-1 flex-col">
        <ul class="flex flex-1 flex-col gap-y-7" role="list">
          <li>
            <ul class="-mx-2 space-y-1" role="list">
              <LayoutSidebarLink
                v-for="link in mainLinks"
                :key="link.label"
                :link="link"
              />
            </ul>
          </li>

          <!-- Bottom Section -->
          <li class="mb-5 mt-auto">
            <ul class="-mx-2 space-y-1" role="list">
              <LayoutSidebarLink
                v-for="link in secondaryLinks"
                :key="link.label"
                :link="link"
              />
            </ul>

            <!-- Side-by-Side Theme Switcher Buttons -->
            <div class="flex items-center justify-center space-x-4 mt-4">
              <!-- Light Mode Button -->
              <button
                @click="setTheme('light')"
                class="flex items-center space-x-1 px-4 py-1 rounded-md border border-gray-500 text-sm font-medium transition hover:bg-gray-200 dark:hover:bg-gray-600"
                :class="{ 'bg-gray-700': !isDarkMode }"
              >
                <SvgIcon name="catalog" class="h-5 w-5" />
                <span>Light</span>
              </button>

              <!-- Dark Mode Button -->
              <button
                @click="setTheme('dark')"
                class="flex items-center space-x-1 px-4 py-1 rounded-md border border-gray-500 text-sm font-medium transition hover:bg-gray-700 dark:hover:bg-gray-800"
                :class="{ 'bg-gray-700 text-white': isDarkMode }"
              >
                <SvgIcon name="quill" class="h-5 w-5" />
                <span>Dark</span>
              </button>
            </div>
          </li>
        </ul>
      </nav>
    </div>
  </div>
</template>
