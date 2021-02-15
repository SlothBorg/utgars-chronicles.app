<template>
    <button
        type="submit"
        class="text-white w-full rounded py-2 px-4"
        :class="{ 'bg-grey-400 cursor-not-allowed': loading, 'bg-grey-700 ': !loading }"
        :disabled="loading"
    >
        <slot v-if="!loading" />
        <template v-else>Hang on...</template>
    </button>
</template>

<script>
export default {
    name: 'LoadingButton',

    props: {
        loading: {
            required: true,
            type: Boolean,
        },
    },
};
</script>
