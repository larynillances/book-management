<script setup>
import { onMounted, ref } from "vue";

defineProps(["modelValue", "options"]);

defineEmits(["update:modelValue"]);

const input = ref(null);

onMounted(() => {
  if (input.value.hasAttribute("autofocus")) {
    input.value.focus();
  }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
  <select
    ref="input"
    @change="$emit('update:modelValue', $event.target.value)"
    :value="modelValue"
    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
  >
    <option v-for="(option, index) in options" :key="index" :value="index">
      {{ option }}
    </option>
  </select>
</template>
