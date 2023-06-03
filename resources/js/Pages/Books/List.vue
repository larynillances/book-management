<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import CreateBookModal from "@/Pages/Books/Partials/CreateBookModal.vue";
import Pagination from "@/Components/Pagination.vue";
import EditBookModal from "@/Pages/Books/Partials/EditBookModal.vue";
import DeleteBookModal from "@/Pages/Books/Partials/DeleteBookModal.vue";
import { XMarkIcon, PencilSquareIcon } from "@heroicons/vue/20/solid";
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";
import _ from "lodash";

const showUpdateModal = ref(false);
const showDeleteModal = ref(false);
const bookData = ref(null);
const props = defineProps({
  books: Object | null | undefined,
  authors: Object | null | undefined,
  categories: Object | null | undefined,
});

const editBook = (id) => {
  showUpdateModal.value = !showUpdateModal.value;
  bookData.value = _.find(props.books.data, { id: id });
};

const deleteBook = (id) => {
  showDeleteModal.value = !showDeleteModal.value;
  bookData.value = _.find(props.books.data, { id: id });
};
</script>

<template>
  <Head title="Books Management" />

  <AuthenticatedLayout>
    <template #header>
      <CreateBookModal />
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <div
              class="grid grid-cols-1 gap-y-4 sm:grid-cols-2 sm:gap-x-6 sm:gap-y-10 lg:grid-cols-3 lg:gap-x-8"
            >
              <template v-if="Object.keys(props.books).length">
                <div
                  v-for="book in props.books.data"
                  :key="book.id"
                  class="group relative flex flex-col overflow-hidden rounded-lg border border-gray-200 bg-white"
                >
                  <div
                    class="aspect-h-4 aspect-w-3 bg-gray-500 sm:aspect-none group-hover:opacity-75 sm:h-96"
                  >
                    <img
                      src="https://tailwindui.com/img/ecommerce-images/product-page-05-menu-04.jpg"
                      :alt="book.title"
                      class="h-full w-full object-cover object-center sm:h-full sm:w-full"
                    />
                  </div>
                  <div class="flex flex-1 flex-col space-y-2 p-4">
                    <h3 class="text-sm font-medium text-gray-900 capitalize">
                      <a :href="book.href">
                        <span aria-hidden="true" class="absolute inset-0" />
                        {{ book.title }}
                      </a>
                    </h3>
                    <p class="text-sm text-gray-500">{{ book.description }}</p>
                    <div class="flex justify-between">
                      <div class="text-sm italic text-gray-500">
                        By: {{ book.authorName }}
                      </div>
                      <div
                        class="flex justify-between items-end text-base font-medium text-gray-900"
                      >
                        <span class="isolate inline-flex rounded-md shadow-sm">
                          <button
                            type="button"
                            @click="deleteBook(book.id)"
                            class="relative inline-flex items-center rounded-l-md bg-rose-500 px-2 py-2 text-white ring-1 ring-inset ring-rose-300 hover:text-gray-500 hover:bg-rose-300 focus:z-10"
                          >
                            <span class="sr-only">Delete</span>
                            <XMarkIcon class="h-5 w-5" aria-hidden="true" />
                          </button>
                          <button
                            type="button"
                            @click="editBook(book.id)"
                            class="relative -ml-px inline-flex items-center rounded-r-md bg-sky-500 px-2 py-2 text-white ring-1 ring-inset ring-sky-300 hover:text-gray-500 hover:bg-sky-300 focus:z-10"
                          >
                            <span class="sr-only">Update</span>
                            <PencilSquareIcon
                              class="h-5 w-5"
                              aria-hidden="true"
                            />
                          </button>
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
              </template>
              <template v-else>
                <h3 class="text-base font-medium text-gray-900">
                  No results found.
                </h3>
              </template>
            </div>
          </div>
          <Pagination :links="props.books" />
          <EditBookModal
            v-if="showUpdateModal"
            :show="showUpdateModal"
            :book="bookData"
            @close-modal="showUpdateModal = false"
          />
          <DeleteBookModal
            v-if="showDeleteModal"
            :show="showDeleteModal"
            :book="bookData"
            @close-modal="showDeleteModal = false"
          />
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>