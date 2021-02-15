<template>
    <div class="flex flex-col" style="flex: 1 0 auto;">
        <Navigation />

        <main class="flex-1">
            <FlashMessage />

            <slot />
        </main>

        <portal-target name="modal" slim></portal-target>
    </div>
</template>

<script>
import FlashMessage from "../../components/FlashMessage";
import Navigation from "../../components/Navigation";

export default {
    name: 'Layout',

    components: {
        Navigation,
        FlashMessage,
    },

    data() {
        return {
            open: false,
        };
    },

    methods: {
        toggle() {
            this.open = !this.open;
        },
    },
};
</script>
