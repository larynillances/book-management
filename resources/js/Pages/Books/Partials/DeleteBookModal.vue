<script setup>
import Modal from "@/Components/Modal.vue";
import DangerButton from "@/Components/DangerButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
  book: Object,
});

const emits = defineEmits(["closeModal"]);

const form = useForm({
  id: props.book?.id,
});

const deleteBook = () => {
  form.delete(route("books.destroy"), {
    preserveScroll: true,
    onSuccess: () => emits("closeModal"),
    onFinish: () => form.reset(),
  });
};
</script>

<template>
  <Modal @close="emits('closeModal')">
    <div class="p-6">
      <h2 class="text-lg font-medium text-gray-900">
        Are you sure you want to delete book called {{ props.book?.title }}?
      </h2>

      <p class="mt-1 text-sm text-gray-600">
        Once the book is deleted, all of its resources and data will be
        permanently deleted.
      </p>
      <div class="mt-6 flex justify-end">
        <SecondaryButton @click="emits('closeModal')"> Cancel </SecondaryButton>

        <DangerButton
          class="ml-3"
          :class="{ 'opacity-25': form.processing }"
          :disabled="form.processing"
          @click="deleteBook"
        >
          Delete Book
        </DangerButton>
      </div>
    </div>
  </Modal>
</template>