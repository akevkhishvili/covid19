<template>
    <div class="ml-4">
        <div class="inline-flex rounded-md shadow-sm">
            <InertiaLink :href="route('language', 'ka')" aria-current="page" class="language-button-left">
                ქარ
            </InertiaLink>
            <InertiaLink :href="route('language', 'en')" class=" language-button-right">
                ENG
            </InertiaLink>
        </div>
    </div>
</template>

