<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
    first_name: '',
    last_name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
      <!-- Decorative circles -->
      <div class="absolute right-0 top-0 -mr-20 -mt-20 h-80 w-80 rounded-full bg-blue-200 opacity-20 blur-xl"></div>
    <div class="absolute bottom-0 left-0 -mb-20 -ml-20 h-80 w-80 rounded-full bg-indigo-200 opacity-20 blur-xl"></div>

    <!-- Main Content -->
    <div class="relative flex min-h-screen flex-col">
      <!-- Navigation -->
      <nav class="p-4">
        <div class="mx-auto max-w-7xl">
          <a href="#" class="flex items-center gap-2 text-lg font-semibold text-blue-600">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
            </svg>
            Back to Home
          </a>
        </div>
      </nav>

      <!-- Register Container -->
      <div class="flex flex-1 items-center justify-center p-4">
        <div class="w-full max-w-md">
          <!-- Register Box -->
          <div class="relative">
            <!-- Decorative Elements -->
            <div class="absolute -right-4 -top-4 h-24 w-24 rounded-lg bg-gradient-to-r from-blue-400 to-indigo-400 opacity-50 blur"></div>
            <div class="absolute -bottom-4 -left-4 h-24 w-24 rounded-lg bg-gradient-to-r from-blue-400 to-indigo-400 opacity-50 blur"></div>

            <!-- Register Form -->
            <div class="relative rounded-2xl bg-white/80 p-8 shadow-xl backdrop-blur-sm">
              <div class="mb-8 text-center">
                <h2 class="text-3xl font-bold text-gray-900">Create Account</h2>
                <p class="mt-2 text-gray-600">Join our employee management system</p>
              </div>

              <form class="space-y-6" @submit.prevent="submit">
                <div class="grid grid-cols-2 gap-4">
                  <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">First Name</label>
                    <div class="relative">
                      <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                      </div>
                      <input type="text" v-model="form.first_name" required class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2 pl-10 focus:border-transparent focus:ring-2 focus:ring-blue-500" />
                      <InputError class="mt-2" :message="form.errors.first_name" />
                    </div>
                  </div>
                  <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Last Name</label>
                    <input type="text" v-model="form.last_name" required class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2 focus:border-transparent focus:ring-2 focus:ring-blue-500" />
                    <InputError class="mt-2" :message="form.errors.last_name" />
                  </div>
                </div>

                <!-- <div>
                  <label class="mb-1 block text-sm font-medium text-gray-700">Employee ID</label>
                  <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                      <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                      </svg>
                    </div>
                    <input type="text" required class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2 pl-10 focus:border-transparent focus:ring-2 focus:ring-blue-500" />
                  </div>
                </div> -->

                <div>
                  <label class="mb-1 block text-sm font-medium text-gray-700">Email Address</label>
                  <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                      <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                      </svg>
                    </div>
                    <input type="email" v-model="form.email" required class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2 pl-10 focus:border-transparent focus:ring-2 focus:ring-blue-500" />
                    <InputError class="mt-2" :message="form.errors.email" />
                  </div>
                </div>

                <div>
                  <label class="mb-1 block text-sm font-medium text-gray-700">Password</label>
                  <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                      <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                      </svg>
                    </div>
                    <input type="password" v-model="form.password" required class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2 pl-10 focus:border-transparent focus:ring-2 focus:ring-blue-500" />
                    <InputError class="mt-2" :message="form.errors.password" />
                  </div>
                  <p class="mt-1 text-xs text-gray-500">Password must be at least 8 characters long</p>
                </div>

                <div>
                  <label class="mb-1 block text-sm font-medium text-gray-700">Confirm Password</label>
                  <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                      <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                      </svg>
                    </div>
                    <input type="password" v-model="form.password_confirmation" required class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2 pl-10 focus:border-transparent focus:ring-2 focus:ring-blue-500" />
                    <InputError class="mt-2" :message="form.errors.password_confirmation" />
                  </div>
                </div>
                <button type="submit" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" class="w-full transform rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 px-4 py-3 font-medium text-white transition-all duration-200 hover:scale-105 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Create Account</button>
              </form>

              <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                  Already have an account?
                  <Link :href="route('login')" class="font-medium text-blue-600 hover:text-blue-500">Sign in here</Link>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</template>
