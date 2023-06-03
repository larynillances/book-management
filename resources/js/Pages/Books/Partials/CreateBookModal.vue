<script setup>
import Modal from "@/Components/Modal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import SelectInput from "@/Components/SelectInput.vue";
import Checkbox from "@/Components/Checkbox.vue";
import { PlusIcon } from "@heroicons/vue/20/solid";
import { useForm, usePage } from "@inertiajs/vue3";
import { ref } from "vue";

const showModal = ref(false);
const authors = usePage().props.authors;
const categories = usePage().props.categories;

const form = useForm({
  title: "",
  description: "",
  author_id: null,
  category_id: null,
  is_published: false,
});

const createBook = () => {
  form.post(route("books.store"), {
    preserveScroll: true,
    onSuccess: () => closeModal(),
    onFinish: () => form.reset(),
  });
};

const createBookModal = () => {
  showModal.value = !showModal.value;
};

const closeModal = () => {
  showModal.value = false;
  form.reset();
};
</script>

<template>
  <div>
    <div class="md:flex md:items-center md:justify-between">
      <div class="min-w-0 flex-1">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Book Management
        </h2>
      </div>
      <div class="mt-4 flex md:ml-4 md:mt-0">
        <PrimaryButton @click="createBookModal">
          <PlusIcon class="-ml-1.5 h-5 w-5" aria-hidden="true" />
          Add Book
        </PrimaryButton>
      </div>
    </div>
    <Modal :show="showModal" @close="closeModal">
      <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900">Add Book</h2>
        <form @submit.prevent="createBook">
          <div class="mt-6">
            <InputLabel for="title" value="Title" />

            <TextInput
              id="title"
              type="text"
              class="mt-1 block w-full"
              v-model="form.title"
              required
              autofocus
              autocomplete="title"
            />

            <InputError class="mt-2" :message="form.errors.title" />
          </div>

          <div class="mt-6">
            <InputLabel for="description" value="Description" />

            <TextInput
              id="description"
              type="text"
              class="mt-1 block w-full"
              v-model="form.description"
              required
              autofocus
              autocomplete="description"
            />

            <InputError class="mt-2" :message="form.errors.description" />
          </div>

          <div class="mt-6">
            <InputLabel for="author" value="Author" />

            <SelectInput
              id="author"
              class="mt-1 block w-full"
              v-model="form.author_id"
              :options="authors"
              required
              autofocus
              autocomplete="author"
            />

            <InputError class="mt-2" :message="form.errors.author_id" />
          </div>

          <div class="mt-6">
            <InputLabel for="categories" value="Category" />

            <SelectInput
              id="categories"
              class="mt-1 block w-full"
              v-model="form.category_id"
              :options="categories"
              required
              autofocus
              autocomplete="categories"
            />

            <InputError class="mt-2" :message="form.errors.author_id" />
          </div>

          <div class="mt-6">
            <InputLabel for="publish" value="Publish?" />

            <Checkbox
              id="publish"
              class="mt-1 h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600"
              v-model="form.is_published"
              autofocus
              autocomplete="publish"
            />

            <InputError class="mt-2" :message="form.errors.is_published" />
          </div>

          <div class="mt-6 flex justify-end">
            <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

            <PrimaryButton
              class="ml-3"
              :class="{ 'opacity-25': form.processing }"
              :disabled="form.processing"
            >
              Create
            </PrimaryButton>
          </div>
        </form>
      </div>
    </Modal>
  </div>
</template>