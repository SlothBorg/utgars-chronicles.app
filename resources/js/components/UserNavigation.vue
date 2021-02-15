<template>
    <div class="w-full flex-grow sm:flex sm:w-auto">
        <CreateHistoryModal v-if="showModal" @close="showModal = false" />
        <div class="sm:flex justify-start relative">
            <button
                @click="showModal = true"
                class="sm:px-8 py-4 sm:py-2 bg-indigo-800 text-gray-100 underline hover:bg-indigo-500 hover:text-gray-900 hover:underline"
            >Start new history</button>
        </div>
        <div class="sm:flex justify-end relative">
            <InertiaLink
                :href="$route('profile')"
                class="sm:px-8 py-4 sm:py-2 sm:text-sm text-gray-100 hover:bg-gray-100 hover:text-gray-800"
                @click="dropdownOpen = false"
            >Profile</InertiaLink>

            <InertiaLink
                as="button"
                method="POST"
                :href="$route('logout')"
                class="sm:text-sm w-full sm:px-8 py-4 sm:py-2 text-gray-100 hover:bg-gray-100 hover:text-gray-800"
            >Logout</InertiaLink>
        </div>
    </div>
</template>

<script>
import vClickOutside from "v-click-outside";
import CreateHistoryModal from "../components/Modal/CreateHistoryModal";

export default {
    name: "UserNavigation",

    components: {
        CreateHistoryModal,
    },

    directives: {
        clickOutside: vClickOutside.directive
    },

    computed: {
        token() {
            return document.head
                .querySelector("meta[name=csrf-token]")
                .getAttribute("content");
        }
    },

    data() {
        return {
            dropdownOpen: false,
            showModal: false,
        };
    }
};
</script>
