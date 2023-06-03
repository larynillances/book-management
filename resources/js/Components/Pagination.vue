<script setup>
import { ChevronLeftIcon, ChevronRightIcon } from "@heroicons/vue/20/solid";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
  links: Array | Object,
});
</script>

<template>
  <div
    class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6"
  >
    <div class="flex flex-1 justify-between sm:hidden">
      <Link
        v-if="props.links.prev_page_url"
        :href="props.links.prev_page_url"
        :class="[
          props.links.prev_page_url
            ? 'cursor-default bg-gray-300'
            : 'relative inline-flex items-center rounded-md border border-sky-300 bg-sky-400 px-4 py-2 text-sm font-medium text-white hover:bg-sky-500',
        ]"
        >Previous</Link
      >
      <Link
        :href="props.links.next_page_url"
        :class="[
          props.links.next_page_url
            ? 'cursor-default bg-gray-300'
            : 'relative inline-flex items-center rounded-md border border-sky-300 bg-sky-400 px-4 py-2 text-sm font-medium text-white hover:bg-sky-500',
        ]"
        >Next</Link
      >
    </div>
    <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
      <div>
        <p class="text-sm text-gray-700">
          Showing
          {{ " " }}
          <span class="font-medium">{{ props.links.from }}</span>
          {{ " " }}
          to
          {{ " " }}
          <span class="font-medium">{{ props.links.to }}</span>
          {{ " " }}
          of
          {{ " " }}
          <span class="font-medium">{{ props.links.total }}</span>
          {{ " " }}
          results
        </p>
      </div>
      <div>
        <nav
          class="isolate inline-flex -space-x-px rounded-md shadow-sm"
          aria-label="Pagination"
        >
          <!-- Current: "z-10 bg-indigo-600 text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600", Default: "text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:outline-offset-0" -->
          <template v-for="(link, key) in props.links.links" :key="key">
            <div
              v-if="key == 0"
              class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0"
              v-html="link.label"
            />
            <Link
              v-if="key !== 0 && key !== props.links.links.length - 1"
              :href="link.url"
              :class="[
                link.active
                  ? 'bg-indigo-600 text-white hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600'
                  : 'text-gray-900 ring-1 ring-inset ring-gray-300',
                'relative z-10 inline-flex items-center px-4 py-2 text-sm font-semibold hover:bg-gray-50 focus:z-20 focus:outline-offset-0',
              ]"
              v-html="link.label"
            />
            <Link
              v-if="key == props.links.links.length - 1"
              :href="link.url"
              class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0"
              v-html="link.label"
            />
          </template>
        </nav>
      </div>
    </div>
  </div>
</template>