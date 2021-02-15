<template>
    <InertiaLink
        :href="url"
        class="px-8 py-6 rounded-lg shadow-lg flex flex-col items-center justify-center h-full bg-gray-200"
    >
        <h4 class="font-bold text-xl text-gray-800 text-center">
            {{ history.name }}
        </h4>
    </InertiaLink>
</template>

<script>
export default {
    name: "HistoryCard",

    props: ["history", "url"]
};
</script>
