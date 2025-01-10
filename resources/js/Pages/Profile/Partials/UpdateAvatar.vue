<!-- resources/js/Pages/Profile/Partials/UpdateAvatarForm.vue -->
<template>
    <div class="mt-10 sm:mt-0">
      <form @submit.prevent="submit">
        <label for="avatar" class="block text-sm font-medium text-gray-700">Upload Avatar</label>
        <input type="file" id="avatar" ref="avatar" class="mt-2" accept="image/*" />
        <button
          type="submit"
          class="mt-2 inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700"
        >
          Update Avatar
        </button>
      </form>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  import { useForm } from '@inertiajs/inertia-vue3';
  
  const props = defineProps({
    user: Object,
  });
  
  const avatar = ref(null);
  
  const form = useForm({
    avatar: null,
  });
  
  const submit = () => {
    form.post(route('profile.updateAvatar'), {
      data: { avatar: avatar.value },
    });
  };
  </script>
  