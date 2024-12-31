<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
      <!-- Decorative circles -->
      <div class="absolute top-0 right-0 -mt-20 -mr-20 w-80 h-80 rounded-full bg-blue-200 opacity-20 blur-xl"></div>
    <div class="absolute bottom-0 left-0 -mb-20 -ml-20 w-80 h-80 rounded-full bg-indigo-200 opacity-20 blur-xl"></div>

    <!-- Main Content -->
    <div class="relative min-h-screen flex flex-col">
        <!-- Navigation -->
        <nav class="p-4">
            <div class="max-w-7xl mx-auto">
                <Link href="/" class="text-blue-600 font-semibold text-lg flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"/>
                    </svg>
                    Back to Home
                </Link>
            </div>
        </nav>

        <!-- Login Container -->
        <div class="flex-1 flex items-center justify-center p-4">
            <div class="max-w-md w-full">
                <!-- Login Box -->
                <div class="relative">
                    <!-- Decorative Elements -->
                    <div class="absolute -top-4 -right-4 w-24 h-24 bg-gradient-to-r from-blue-400 to-indigo-400 rounded-lg opacity-50 blur"></div>
                    <div class="absolute -bottom-4 -left-4 w-24 h-24 bg-gradient-to-r from-blue-400 to-indigo-400 rounded-lg opacity-50 blur"></div>
                    
                    <!-- Login Form -->
                    <div class="relative bg-white/80 backdrop-blur-sm p-8 rounded-2xl shadow-xl">
                        <div class="text-center mb-8">
                            <h2 class="text-3xl font-bold text-gray-900">Welcome Back</h2>
                            <p class="mt-2 text-gray-600">Please sign in to your account</p>
                        </div>

                        <form class="space-y-6" @submit.prevent="submit">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                        </svg>
                                    </div>
                                    <input type="email" v-model="form.email" required class="pl-10 w-full px-4 py-2 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <InputError class="mt-2" :message="form.errors.email" />
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                        </svg>
                                    </div>
                                    <input type="password" v-model="form.password" required class="pl-10 w-full px-4 py-2 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <InputError class="mt-2" :message="form.errors.password" />
                                </div>
                            </div>

                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <Checkbox type="checkbox" v-model:checked="form.remember" class="h-4 w-4 text-blue-600 rounded border-gray-300"/>
                                    <label class="ml-2 text-sm text-gray-600">Remember me</label>
                                </div>
                                <a :href="route('password.request')" v-if="canResetPassword" class="text-sm text-blue-600 hover:text-blue-500">Forgot password?</a>
                            </div>

                            <button type="submit" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" class="w-full px-4 py-3 text-white font-medium bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transform hover:scale-105 transition-all duration-200">
                                Sign in
                            </button>
                        </form>

                        <div class="mt-6 text-center">
                            <p class="text-sm text-gray-600">
                                Don't have an account? 
                                <a href="#" class="font-medium text-blue-600 hover:text-blue-500">Register here</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
