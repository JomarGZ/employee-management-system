<template>
    <div class="fixed inset-0 bg-gray-700 bg-opacity-50 z-40"></div>
    <div class="fixed inset-0 items-center flex justify-center z-50">
        <div class="max-w-lg bg-white shadow-md rounded-lg p-8">
           <header class="border-b border-gray-300 mb-6">
                <slot name="header"></slot>
           </header>
           <main>
                <slot></slot>
           </main>
           <footer>
                <slot name="footer"></slot>
           </footer>
        </div> 
    </div>
</template>