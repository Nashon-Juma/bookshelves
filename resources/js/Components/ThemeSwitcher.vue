<!-- ThemeSwitcher.vue -->
<script setup lang="ts">
import { inject } from "vue";

const { isDarkMode, setTheme } = inject("themeContext") as {
  isDarkMode: boolean;
  setTheme: (mode: "light" | "dark") => void;
};
</script>

<template>
  <div class="flex items-center justify-center space-x-4 mt-4">
    <!-- Light Mode Button -->
    <button
      @click="setTheme('light')"
      class="flex items-center space-x-1 px-4 py-1 rounded-md border border-gray-500 text-sm font-medium transition hover:bg-gray-200 dark:hover:bg-gray-600"
      :class="{ 'bg-gray-700': !isDarkMode }"
    >
      <SvgIcon name="manga" class="h-5 w-5" />
      <span>Light</span>
    </button>

    <!-- Dark Mode Button -->
    <button
      @click="setTheme('dark')"
      class="flex items-center space-x-1 px-4 py-1 rounded-md border border-gray-500 text-sm font-medium transition hover:bg-gray-700 dark:hover:bg-gray-800"
      :class="{ 'bg-gray-700 text-white': isDarkMode }"
    >
      <SvgIcon name="comic_manga" class="h-5 w-5" />
      <span>Dark</span>
    </button>
  </div>
</template>
