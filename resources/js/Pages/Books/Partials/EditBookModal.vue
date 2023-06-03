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

const props = defineProps({
  book: Object,
});

const emits = defineEmits(["closeModal"]);

const authors = usePage().props.authors;
const categories = usePage().props.categories;

const form = useForm({
  id: props.book.id,
  title: props.book?.title,
  description: props.book?.description,
  author_id: props.book?.author_id,
  category_id: props.book?.category[0]?.id,
  is_published: props.book?.published_date ? true : false,
});

console.log(props.book);

const updateBook = () => {
  form.patch(route("books.update"), {
    preserveScroll: true,
    onSuccess: () => emits("closeModal"),
    onFinish: () => form.reset(),
  });
};
</script>

<template>
  <Modal @close="emits('closeModal')">
    <div class="p-6">
      <h2 class="text-lg font-medium text-gray-900">Update Book</h2>
      <form @submit.prevent="updateBook">
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
          <SecondaryButton @click="emits('closeModal')">
            Cancel
          </SecondaryButton>

          <PrimaryButton
            class="ml-3"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
          >
            Update
          </PrimaryButton>
        </div>
      </form>
    </div>
  </Modal>
</template>